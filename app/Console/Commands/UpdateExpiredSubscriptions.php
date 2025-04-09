<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSubscription;
use Carbon\Carbon;

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
