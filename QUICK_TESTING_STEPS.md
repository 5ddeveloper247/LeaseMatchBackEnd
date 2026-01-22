# Quick Testing Steps - Free Trial Expiration

## 1. Test Pre-Expiry Notification (1 Day Before)
Set trial `end_date` to tomorrow in database, then run `php artisan trials:send-pre-expiry-notifications` command.
Check email inbox for "Your Free Trial Expires Tomorrow" email and verify notification is created in `notifications` table.

## 2. Test Trial Expiration Auto-Upgrade  
Set trial `end_date` to yesterday with status `'free'`, ensure user has `stripe_customer_id`, then run `php artisan subscriptions:update-expired` command.
Verify new `'active'` subscription created, payment record in `user_payments`, and subscription page shows "Selected Plan" (disabled) + "Cancel" button.

## 3. Test Active Free Trial Display
Create subscription with status `'free'` and `end_date` in future (e.g., 15 days), create record in `user_subscription_free_trials` table.
Login and visit `/customer/mySubscription` page - should display "Free Trial" button (disabled/grayed) and "Cancel" button (active/clickable).
