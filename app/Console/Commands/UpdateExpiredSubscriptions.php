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

        $this->info('Expired subscriptions have been updated.');
    }
}
