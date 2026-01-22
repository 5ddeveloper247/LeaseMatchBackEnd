<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSubscription;
use App\Models\User;
use App\Models\Pricing_plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SendTrialPreExpiryNotifications extends Command
{
    protected $signature = 'trials:send-pre-expiry-notifications';
    protected $description = 'Send email notifications to users whose free trial expires in 1 day';

    public function handle()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        // Find all free trial subscriptions expiring tomorrow
        $expiringTrials = UserSubscription::where('status', 'free')
            ->where('end_date', $tomorrow)
            ->get();

        $this->info("Found {$expiringTrials->count()} free trials expiring tomorrow.");

        $sentCount = 0;
        $failedCount = 0;

        foreach ($expiringTrials as $subscription) {
            try {
                $user = User::find($subscription->user_id);
                if (!$user) {
                    $this->warn("User not found for subscription ID: {$subscription->id}");
                    $failedCount++;
                    continue;
                }

                $plan = Pricing_plan::find($subscription->plan_id);
                if (!$plan) {
                    $this->warn("Plan not found for subscription ID: {$subscription->id}");
                    $failedCount++;
                    continue;
                }

                // Check if notification was already sent today (prevent duplicates)
                $notificationKey = "trial_pre_expiry_{$subscription->id}_" . $today->format('Y-m-d');
                $notificationSent = DB::table('notifications')
                    ->where('module_code', 'TRIAL_PRE_EXPIRY')
                    ->where('from_user_id', $user->id)
                    ->where('created_at', '>=', $today->startOfDay())
                    ->exists();

                if ($notificationSent) {
                    $this->info("Notification already sent today for user ID: {$user->id}");
                    continue;
                }

                // Prepare email data
                $supportEmail = env('SUPPORT_EMAIL', 'info@leasematch.nyc');
                $manageSubscriptionUrl = route('customer.mySubscription');
                $trialEndDate = Carbon::createFromFormat('Y-m-d', $subscription->end_date)->format('F j, Y');

                $body = view('emails.trial_pre_expiry', [
                    'user' => $user,
                    'planName' => $plan->title,
                    'planPrice' => $plan->monthly_price,
                    'trialEndDate' => $trialEndDate,
                    'supportEmail' => $supportEmail,
                    'manageSubscriptionUrl' => $manageSubscriptionUrl,
                ])->render();

                // Send email
                sendMail(
                    $user->first_name,
                    [$user->email],
                    'LEASE MATCH',
                    'Your Free Trial Expires Tomorrow',
                    $body
                );

                // Create notification record
                DB::table('notifications')->insert([
                    'module_code' => 'TRIAL_PRE_EXPIRY',
                    'from_user_id' => $user->id,
                    'to_user_id' => $user->id,
                    'subject' => 'Free Trial Expiring Tomorrow',
                    'message' => "Your free trial for {$plan->title} expires tomorrow. Your plan will be automatically upgraded if no action is taken.",
                    'read_flag' => '0',
                    'created_by' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $sentCount++;
                $this->info("Pre-expiry notification sent to user ID: {$user->id} ({$user->email})");

                Log::info('Trial pre-expiry notification sent', [
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'plan_id' => $plan->id,
                    'trial_end_date' => $subscription->end_date,
                ]);

            } catch (\Exception $e) {
                $failedCount++;
                $this->error("Failed to send notification for subscription ID {$subscription->id}: " . $e->getMessage());
                Log::error('Failed to send trial pre-expiry notification', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->info("Pre-expiry notifications sent: {$sentCount}, Failed: {$failedCount}");
        return 0;
    }
}
