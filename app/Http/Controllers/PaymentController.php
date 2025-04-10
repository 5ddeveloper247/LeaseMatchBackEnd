<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentIntent;
use App\Models\User;
use App\Models\Pricing_plan;
use App\Models\UserSubscription;
use App\Models\UserPayments;
use App\Models\Notifications;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionExpiryMail;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function showSubscriptionForm()
    {
        $subscriptions = Pricing_plan::all();
        return view('payment', compact('subscriptions'));
    }

    // public function processSubscriptionOld(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'plan_id' => 'required',
    //         'stripeToken' => 'required',
    //     ]);

    //     $user = User::find(Auth::user()->id);
    //     $plan_detail = Pricing_plan::findOrFail($request->plan_id);

    //     Stripe::setApiKey(getStripeSk()); //env('STRIPE_SECRET')
    //     // Create Stripe customer if not already exists
    //     if (!$user->stripe_customer_id) {
    //         $customer = Customer::create([
    //             'email' => $user->email,
    //             'source' => $request->stripeToken,
    //         ]);

    //         $user->stripe_customer_id = $customer->id;
    //         $user->save();
    //     } else {
    //         $customer = Customer::retrieve($user->stripe_customer_id);
    //     }

    //     $charge = \Stripe\Charge::create([
    //         'amount' => $plan_detail->monthly_price * 100, // Amount in cents
    //         'currency' => 'usd',
    //         'customer' => $customer->id, // Use the customer ID
    //         'description' => 'Payment for order',
    //     ]);

    //     $payment = new UserPayments();
    //     $payment->user_subscription_id = null;
    //     $payment->user_id = Auth::user()->id;
    //     $payment->plan_id = $plan_detail->id;
    //     $payment->payment_method_id = null;
    //     $payment->amount = $plan_detail->monthly_price;
    //     $payment->transaction_id = $charge->id;
    //     $payment->stripe_customer_id = $customer->id;
    //     $payment->stripe_subscription_id = null;
    //     $payment->status = $charge->status;
    //     $payment->response = json_encode($charge, true);
    //     $payment->date = Carbon::now()->format('Y-m-d');
    //     $payment->save();

    //     if ($charge->status == 'succeeded') {

    //         $duration_days = 30;
    //         $start_date = Carbon::now()->format('Y-m-d');
    //         $date = Carbon::createFromFormat('Y-m-d', $start_date);
    //         $end_date = $date->addDays($duration_days)->format('Y-m-d');

    //         // if already buy plan then set to end date and then add new entry
    //         $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
    //         if ($currentPlan) {
    //             $currentPlan->end_date = Carbon::now()->format('Y-m-d');
    //             $currentPlan->save();
    //         }
    //         // add new plan entry in table
    //         $userSubscription = new UserSubscription();
    //         $userSubscription->user_id = Auth::user()->id;
    //         $userSubscription->plan_id = $plan_detail->id;
    //         $userSubscription->start_date = $start_date;
    //         $userSubscription->end_date = $end_date;
    //         $userSubscription->status = "active";
    //         $userSubscription->duration_days = $duration_days;
    //         $userSubscription->save();


    //         // personal info save card details end
    //         // save expiry email on queue
    //         $sendDate = Carbon::now()->addMinutes(1);

    //         $user = User::find(Auth::user()->id);

    //         try {
    //             Mail::to($user->email)->later(
    //                 $sendDate,
    //                 new SubscriptionExpiryMail($user)
    //             );

    //             Log::info('Subscription expiry email scheduled for user: ' . $user->id);
    //         } catch (\Exception $e) {

    //             Log::error('Failed to queue subscription expiry email: ' . $e->getMessage());
    //         }

    //         $payment->user_subscription_id = $userSubscription->id;
    //         $payment->save();

    //         $Notification = new Notifications();
    //         $Notification->module_code =  'BUY SUBSCRIPTION';
    //         $Notification->from_user_id =   Auth::user()->id;
    //         $Notification->to_user_id =  '1'; // for admin notification
    //         $Notification->subject =  "Tenant Buy Plan";
    //         $Notification->message =  "The tenant has successfully purchased/update a " . $plan_detail->title . " subscription.";
    //         $Notification->read_flag =  '0';
    //         $Notification->created_by =  Auth::user()->id;
    //         $Notification->save();

    //         $mailData['name'] = $user->first_name;
    //         $mailData['email'] = $user->email;
    //         $mailData['plan_name'] = $plan_detail->title;
    //         $mailData['plan_start'] = $start_date;
    //         $mailData['plan_end'] = $end_date;

    //         $body = view('emails.buy_plan_mail_tenant', $mailData);
    //         $userEmailsSend[] = $user->email; //'hamza@5dsolutions.ae';//
    //         // to username, to email, from username, subject, body html
    //         sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'Subscription Purchase', $body);

    //         if (!$currentPlan) { //admin email send for first time buy
    //             $body = view('emails.buy_plan_mail_admin', $mailData);
    //             $userEmailsSend[] = env('MAIL_ADMIN');
    //             // to username, to email, from username, subject, body html
    //             sendMail('Admin', $userEmailsSend, 'LEASE MATCH', 'Subscription Purchase', $body);
    //         }

    //         Session::flash('success', 'Payment Successful');
    //     } else {
    //         Session::flash('error', 'Payment Failed');
    //     }

    //     return redirect()->route('customer.mySubscription');
    //     // return redirect()->route('subscribe.success');
    // }

    public function processSubscription(Request $request)
    {
        // Validate the request data
        $request->validate([
            'plan_id' => 'required',
            'stripeToken' => 'required',
        ]);

        $user = User::find(Auth::user()->id);  // Get the authenticated user
        $plan_detail = Pricing_plan::findOrFail($request->plan_id);  // Get the selected plan details

        // Set the Stripe API key
        Stripe::setApiKey(getStripeSk());

        // Check if the user already has a Stripe customer ID
        if (!$user->stripe_customer_id) {
            // If not, create a new Stripe customer
            $customer = \Stripe\Customer::create([
                'email' => $user->email,
                'source' => $request->stripeToken,  // Payment method token from Stripe Elements
            ]);

            // Save the Stripe customer ID in the user record
            $user->stripe_customer_id = $customer->id;
            $user->save();
        } else {
            // Retrieve the existing Stripe customer
            $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
        }

        // Step 1: Create a price for the selected plan
        try {
            // Create a new product and price (if product does not exist)
            $product = \Stripe\Product::create([
                'name' => $plan_detail->title,  // Use your plan name
                'description' => $plan_detail->title,  // Optional description
            ]);

            // Create the price for the subscription plan using the newly created product
            $price = \Stripe\Price::create([
                'unit_amount' => $plan_detail->monthly_price * 100, // In cents
                'currency' => 'usd',
                'recurring' => ['interval' => 'month'],
                'product' => $product->id,  // Link to the newly created product
            ]);
    

            // Use the price_id for creating a subscription
            $priceId = $price->id;  // This is the newly created price_id
            // dd($priceId);
            // Step 2: Create a subscription for the user
            $subscription = \Stripe\Subscription::create([
                'customer' => $customer->id,  // The Stripe customer ID
                'items' => [
                    [
                        'price' => $priceId,  // Use the price_id from the created price object
                    ]
                ],
                'expand' => ['latest_invoice.payment_intent'],  // Expand to get payment status
            ]);

            // Save the payment and subscription details
            $payment = new UserPayments();
            $payment->user_subscription_id = null;
            $payment->user_id = Auth::user()->id;
            $payment->plan_id = $plan_detail->id;
            $payment->payment_method_id = null;
            $payment->amount = $plan_detail->monthly_price;
            $payment->transaction_id = $subscription->id;
            $payment->stripe_customer_id = $customer->id;
            $payment->stripe_subscription_id = $subscription->id;
            $payment->status = $subscription->status;
            $payment->response = json_encode($subscription, true);
            $payment->date = Carbon::now()->format('Y-m-d');
            $payment->save();
            // dd($subscription);
            // Check if the subscription is successful
            if ($subscription->status == 'active') {
                $start_date = Carbon::now()->format('Y-m-d');
                $duration_days = 30;  // You can customize this based on your subscription duration
                $end_date = Carbon::createFromFormat('Y-m-d', $start_date)->addDays($duration_days)->format('Y-m-d');

                // Update the current subscription plan if necessary
                $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
                if ($currentPlan) {
                    $currentPlan->end_date = Carbon::now()->format('Y-m-d');
                    $currentPlan->save();
                }

                // Add the new subscription entry
                $userSubscription = new UserSubscription();
                $userSubscription->user_id = Auth::user()->id;
                $userSubscription->plan_id = $plan_detail->id;
                $userSubscription->start_date = $start_date;
                $userSubscription->end_date = $end_date;
                $userSubscription->status = 'active';
                $userSubscription->duration_days = $duration_days;
                $userSubscription->stripe_subscription_id = $subscription->id;  // Store Stripe subscription ID
                $userSubscription->save();

                // Send subscription confirmation email
                // $sendDate = Carbon::now()->addDays(30);

                // try {
                //     Mail::to($user->email)->later($sendDate, new SubscriptionExpiryMail($user));
                //     Log::info('Subscription expiry email scheduled for user: ' . $user->id);
                // } catch (\Exception $e) {
                //     Log::error('Failed to queue subscription expiry email: ' . $e->getMessage());
                // }

                // Send an admin notification about the successful subscription
                $Notification = new Notifications();
                $Notification->module_code = 'BUY SUBSCRIPTION';
                $Notification->from_user_id = Auth::user()->id;
                $Notification->to_user_id = '1';  // Admin notification
                $Notification->subject = "Tenant Buy Plan";
                $Notification->message = "The tenant has successfully purchased/updated a " . $plan_detail->title . " subscription.";
                $Notification->read_flag = '0';
                $Notification->created_by = Auth::user()->id;
                $Notification->save();

                // Send a confirmation email to the user
                $mailData['name'] = $user->first_name;
                $mailData['email'] = $user->email;
                $mailData['plan_name'] = $plan_detail->title;
                $mailData['plan_start'] = $start_date;
                $mailData['plan_end'] = $end_date;

                $body = view('emails.buy_plan_mail_tenant', $mailData);
                $userEmailsSend[] = $user->email; 
                sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'Subscription Purchase', $body);

                // If it's the first time the user buys a plan, send an admin notification
                if (!$currentPlan) {
                    $body = view('emails.buy_plan_mail_admin', $mailData);
                    $userEmailsSend[] = env('MAIL_ADMIN');
                    sendMail('Admin', $userEmailsSend, 'LEASE MATCH', 'Subscription Purchase', $body);
                }

                // Show a success message to the user
                Session::flash('success', 'Subscription Successful!');
            } else {
                // If the payment failed, show an error message
                Session::flash('error', 'Subscription Failed');
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            
            Log::error('Stripe API Error: ' . $e->getMessage());
            Session::flash('error', 'There was an error with Stripe. Please try again.');
        }

        return redirect()->route('customer.mySubscription');  // Redirect to subscription page
    }



    public function subscriptionSuccess()
    {
        return view('subscription-success');
    }

    public function subscriptionError()
    {
        return view('subscription-error');
    }
}
