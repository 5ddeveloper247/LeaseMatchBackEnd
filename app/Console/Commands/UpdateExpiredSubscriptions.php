<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionExpiryMail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Pricing_plan;
use App\Models\UserPayments;

class UpdateExpiredSubscriptions extends Command
{

    protected $signature = 'subscriptions:update-expired';

    protected $description = 'Set subscription status to expired if the end date is past';


    public function handle()
    {

        $today = Carbon::today();

        // Find subscriptions where the end_date is before today and the status is not already expired
        $expiredSubscriptions = UserSubscription::where('end_date', '<', $today)
            ->where('status', 'active')
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->status = 'expired';
            $subscription->save();

            $user = User::find($subscription->user_id);
            $renewalDate = Carbon::now()->format('Y-m-d');
            $newExpiryDate = Carbon::createFromFormat('Y-m-d', $renewalDate)->addDays(30)->format('Y-m-d');
            $nextBillingDate = Carbon::createFromFormat('Y-m-d', $renewalDate)->addDays(31)->format('Y-m-d');
            $plan_detail = Pricing_plan::findOrFail($subscription->plan_id);
            $packageName = $plan_detail->title;
            $amount = '$' . number_format($plan_detail->monthly_price, 2);
            // dd('ok');
            try {
                Mail::to($user->email)->send(new SubscriptionExpiryMail($user, $packageName, $renewalDate, $nextBillingDate, $amount, $newExpiryDate));
                Log::info('Subscription expiry email sent to user: ' . $user->id);
            } catch (\Exception $e) {
                Log::error('Failed to send subscription expiry email: ' . $e->getMessage());
            }


            $start_date = Carbon::now()->format('Y-m-d');

            $end_date = Carbon::createFromFormat('Y-m-d', $start_date)->addDays(30)->format('Y-m-d');
            $userSubscription = new UserSubscription();

            $userSubscription->user_id = $subscription->user_id;
            $userSubscription->plan_id = $subscription->plan_id;
            $userSubscription->start_date = $start_date;
            $userSubscription->end_date = $end_date;
            $userSubscription->status = 'active';
            $userSubscription->duration_days = 30;
            $userSubscription->stripe_subscription_id = $subscription->stripe_subscription_id;  // Store Stripe subscription ID
            $userSubscription->save();



            $this->info("Subscription for user ID {$subscription->user_id} has been set to expired.");
        }

        // expiredFreeSubscriptions
        $expiredFreeSubscriptions = UserSubscription::where('end_date', '<', $today)
            ->where('status', 'free')
            ->get();

        foreach ($expiredFreeSubscriptions as $subscription) {
            $user = User::find($subscription->user_id);
            $plan_detail = Pricing_plan::findOrFail($subscription->plan_id);

            // Check if user has a valid Stripe customer ID and can be charged
            if ($user->stripe_customer_id) {
                try {
                    // Set the Stripe API key
                    \Stripe\Stripe::setApiKey(getStripeSk());

                    // Try to retrieve the existing Stripe customer
                    $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);

                    // Check if customer was deleted or is invalid
                    if ($customer->deleted ?? false) {
                        throw new \Exception('Customer account was deleted');
                    }

                    // Create a new product and price for the subscription
                    $product = \Stripe\Product::create([
                        'name' => $plan_detail->title,
                        'description' => $plan_detail->title,
                    ]);

                    $price = \Stripe\Price::create([
                        'unit_amount' => $plan_detail->monthly_price * 100, // In cents
                        'currency' => 'usd',
                        'recurring' => ['interval' => 'month'],
                        'product' => $product->id,
                    ]);

                    // Create a subscription for the user
                    $stripeSubscription = \Stripe\Subscription::create([
                        'customer' => $customer->id,
                        'items' => [
                            [
                                'price' => $price->id,
                            ]
                        ],
                        'expand' => ['latest_invoice.payment_intent'],
                    ]);

                    // Save the payment details
                    $payment = new UserPayments();
                    $payment->user_subscription_id = null;
                    $payment->user_id = $user->id;
                    $payment->plan_id = $plan_detail->id;
                    $payment->payment_method_id = null;
                    $payment->amount = $plan_detail->monthly_price;
                    $payment->transaction_id = $stripeSubscription->id;
                    $payment->stripe_customer_id = $customer->id;
                    $payment->stripe_subscription_id = $stripeSubscription->id;
                    $payment->status = $stripeSubscription->status;
                    $payment->response = json_encode($stripeSubscription, true);
                    $payment->date = Carbon::now()->format('Y-m-d');
                    $payment->save();

                    // Check if the subscription payment was successful
                    if ($stripeSubscription->status == 'active') {
                        // Update the current subscription to free-expired
                        $subscription->status = 'free-expired';
                        $subscription->save();

                        // Create new active subscription
                        $start_date = Carbon::now()->format('Y-m-d');
                        $duration_days = 30;
                        $end_date = Carbon::createFromFormat('Y-m-d', $start_date)->addDays($duration_days)->format('Y-m-d');

                        $userSubscription = new UserSubscription();
                        $userSubscription->user_id = $user->id;
                        $userSubscription->plan_id = $plan_detail->id;
                        $userSubscription->start_date = $start_date;
                        $userSubscription->end_date = $end_date;
                        $userSubscription->status = 'active';
                        $userSubscription->duration_days = $duration_days;
                        $userSubscription->stripe_subscription_id = $stripeSubscription->id;
                        $userSubscription->save();

                        // Send subscription renewal email
                        try {
                            $mailData['name'] = $user->first_name;
                            $mailData['email'] = $user->email;
                            $mailData['plan_name'] = $plan_detail->title;
                            $mailData['plan_start'] = $start_date;
                            $mailData['plan_end'] = $end_date;

                            $body = view('emails.buy_plan_mail_tenant', $mailData);
                            $userEmailsSend = [$user->email];
                            sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'Subscription Auto-Renewal', $body);
                            Log::info('Auto-renewal email sent to user: ' . $user->id);
                        } catch (\Exception $e) {
                            Log::error('Failed to send auto-renewal email: ' . $e->getMessage());
                        }

                        Log::info('Auto-renewal successful for user: ' . $user->id);
                        $this->info("Free trial for user ID {$user->id} has been automatically renewed with payment.");
                    } else {
                        // Payment failed, set subscription to free-expired and create new active subscription
                        $subscription->status = 'free-expired';
                        $subscription->save();

                        // Still create new active subscription even if payment failed initially
                        $start_date = Carbon::now()->format('Y-m-d');
                        $duration_days = 30;
                        $end_date = Carbon::createFromFormat('Y-m-d', $start_date)->addDays($duration_days)->format('Y-m-d');

                        $userSubscription = new UserSubscription();
                        $userSubscription->user_id = $user->id;
                        $userSubscription->plan_id = $plan_detail->id;
                        $userSubscription->start_date = $start_date;
                        $userSubscription->end_date = $end_date;
                        $userSubscription->status = 'active';
                        $userSubscription->duration_days = $duration_days;
                        $userSubscription->stripe_subscription_id = $stripeSubscription->id;
                        $userSubscription->save();

                        Log::warning('Auto-renewal payment failed for user: ' . $user->id . ' but subscription created');
                        $this->info("Auto-renewal payment failed for user ID {$user->id} but new active subscription created.");

                        // Send payment failed email
                        try {
                            $supportEmail = env('SUPPORT_EMAIL', 'info@leasematch.nyc');
                            $base_url = route('customer.mySubscription');
                            $supportEmailLink = '<a href="mailto:' . $supportEmail . '">' . $supportEmail . '</a>';

                            $body = '
                        <html>
                        <head>
                            <style>
                                body { font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px; }
                                .container { background-color: #ffffff; border: 1px solid #ddd; padding: 20px; max-width: 600px; margin: auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                                .footer { margin-top: 20px; font-size: 12px; color: #999; }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <h2>Payment Failed - Action Required</h2>
                                <p>Dear ' . $user->first_name . ',</p>
                                <p>We attempted to automatically renew your subscription for ' . $plan_detail->title . ', but the payment could not be processed.</p>
                                <p>Please <a href="' . $base_url . '" target="_blank">update your payment method</a> to continue enjoying our services without interruption.</p>
                                <p>If you have any questions, please contact our support team at ' . $supportEmailLink . '.</p>
                                <p>Thank you,<br>Lease Match Team</p>
                                <div class="footer">&copy; ' . date("Y") . ' Lease Match. All rights reserved.</div>
                            </div>
                        </body>
                        </html>';

                            sendMail($user->first_name, $user->email, 'LEASE MATCH', 'Payment Failed - Action Required', $body);
                            Log::info('Payment failed email sent to user: ' . $user->id);
                        } catch (\Exception $e) {
                            Log::error('Failed to send payment failed email: ' . $e->getMessage());
                        }
                    }
                } catch (\Exception $e) {
                    // If payment processing fails, set to free-expired and create new active subscription
                    $subscription->status = 'free-expired';
                    $subscription->save();

                    // Create new active subscription even if payment failed
                    $start_date = Carbon::now()->format('Y-m-d');
                    $duration_days = 30;
                    $end_date = Carbon::createFromFormat('Y-m-d', $start_date)->addDays($duration_days)->format('Y-m-d');

                    $userSubscription = new UserSubscription();
                    $userSubscription->user_id = $user->id;
                    $userSubscription->plan_id = $plan_detail->id;
                    $userSubscription->start_date = $start_date;
                    $userSubscription->end_date = $end_date;
                    $userSubscription->status = 'active';
                    $userSubscription->duration_days = $duration_days;
                    $userSubscription->stripe_subscription_id = null;
                    $userSubscription->save();

                    Log::error('Failed to process auto-renewal for user ' . $user->id . ': ' . $e->getMessage());
                    $this->info("Auto-renewal failed for user ID {$user->id} but new active subscription created.");

                    // Send trial expired email
                    try {
                        $supportEmail = env('SUPPORT_EMAIL', 'info@leasematch.nyc');
                        $base_url = route('customer.mySubscription');
                        $supportEmailLink = '<a href="mailto:' . $supportEmail . '">' . $supportEmail . '</a>';

                        $body = '
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px; }
                            .container { background-color: #ffffff; border: 1px solid #ddd; padding: 20px; max-width: 600px; margin: auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                            .footer { margin-top: 20px; font-size: 12px; color: #999; }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h2>Free Trial Expired</h2>
                            <p>Dear ' . $user->first_name . ',</p>
                            <p>We hope you enjoyed exploring Lease Match. Your free trial period has now expired.</p>
                            <p>To continue using all the features, please consider <a href="' . $base_url . '" target="_blank">upgrading</a> your subscription.</p>
                            <p>If you have any questions, feel free to reach out to our support team ' . $supportEmailLink . '.</p>
                            <p>Thank you,<br>Lease Match Team</p>
                            <div class="footer">&copy; ' . date("Y") . ' Lease Match. All rights reserved.</div>
                        </div>
                    </body>
                    </html>';

                        sendMail($user->first_name, $user->email, 'LEASE MATCH', 'Free Trial Expired', $body);
                        Log::info('Trial expired email sent to user: ' . $user->id);
                    } catch (\Exception $e) {
                        Log::error('Failed to send trial expired email: ' . $e->getMessage());
                    }
                }
            } else {
                // No payment method available, set to free-expired and create new active subscription
                $subscription->status = 'free-expired';
                $subscription->save();

                // Create new active subscription
                $start_date = Carbon::now()->format('Y-m-d');
                $duration_days = 30;
                $end_date = Carbon::createFromFormat('Y-m-d', $start_date)->addDays($duration_days)->format('Y-m-d');

                $userSubscription = new UserSubscription();
                $userSubscription->user_id = $user->id;
                $userSubscription->plan_id = $plan_detail->id;
                $userSubscription->start_date = $start_date;
                $userSubscription->end_date = $end_date;
                $userSubscription->status = 'active';
                $userSubscription->duration_days = $duration_days;
                $userSubscription->stripe_subscription_id = null;
                $userSubscription->save();

                Log::info('No payment method available for user: ' . $user->id . ' but subscription created');
                $this->info("No payment method for user ID {$user->id} but new active subscription created.");

                // Send trial expired email
                try {
                    $supportEmail = env('SUPPORT_EMAIL', 'info@leasematch.nyc');
                    $base_url = route('customer.mySubscription');
                    $supportEmailLink = '<a href="mailto:' . $supportEmail . '">' . $supportEmail . '</a>';

                    $body = '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px; }
                        .container { background-color: #ffffff; border: 1px solid #ddd; padding: 20px; max-width: 600px; margin: auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                        .footer { margin-top: 20px; font-size: 12px; color: #999; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h2>Free Trial Expired</h2>
                        <p>Dear ' . $user->first_name . ',</p>
                        <p>We hope you enjoyed exploring Lease Match. Your free trial period has now expired.</p>
                        <p>To continue using all the features, please consider <a href="' . $base_url . '" target="_blank">upgrading</a> your subscription.</p>
                        <p>If you have any questions, feel free to reach out to our support team ' . $supportEmailLink . '.</p>
                        <p>Thank you,<br>Lease Match Team</p>
                        <div class="footer">&copy; ' . date("Y") . ' Lease Match. All rights reserved.</div>
                    </div>
                </body>
                </html>';

                    sendMail($user->first_name, $user->email, 'LEASE MATCH', 'Free Trial Expired', $body);
                    Log::info('Trial expired email sent to user: ' . $user->id);
                } catch (\Exception $e) {
                    Log::error('Failed to send trial expired email: ' . $e->getMessage());
                }
            }
        }
    }
}
