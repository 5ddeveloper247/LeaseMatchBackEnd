# Manual Testing Guide - Free Trial Expiration Process

This guide explains how to manually test the free trial expiration features.

## Prerequisites

1. A test user account (type 3 - customer)
2. A pricing plan with free trial enabled
3. Access to database (phpMyAdmin, MySQL command line, or Laravel Tinker)
4. Access to email logs or mailtrap/test email service

---

## Test Scenario 1: Pre-Expiry Notification (1 Day Before)

### Step 1: Set Up Test Data

**Option A: Using Laravel Tinker (Recommended)**

```bash
php artisan tinker
```

Then run:
```php
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionFreeTrial;
use App\Models\Pricing_plan;
use Carbon\Carbon;

// Get your test user (replace with your user ID or email)
$user = User::where('email', 'your-test-email@example.com')->first();
$plan = Pricing_plan::first(); // Or get specific plan

// Create or get free trial record
$trial = UserSubscriptionFreeTrial::firstOrCreate([
    'user_id' => $user->id,
    'plan_id' => $plan->id
]);

// Create free trial subscription that expires TOMORROW
$tomorrow = Carbon::tomorrow()->format('Y-m-d');
$today = Carbon::today()->format('Y-m-d');

// Delete any existing free subscriptions for this user
UserSubscription::where('user_id', $user->id)
    ->where('status', 'free')
    ->delete();

// Create new free trial subscription
$subscription = UserSubscription::create([
    'user_id' => $user->id,
    'plan_id' => $plan->id,
    'start_date' => $today,
    'end_date' => $tomorrow, // Expires tomorrow
    'duration_days' => 1,
    'status' => 'free'
]);

echo "Created free trial subscription for user {$user->id} expiring on {$tomorrow}";
```

**Option B: Using SQL Directly**

```sql
-- Get your user ID and plan ID first
SELECT id, email FROM users WHERE type = '3' LIMIT 1;
SELECT id FROM pricing_plans LIMIT 1;

-- Replace USER_ID and PLAN_ID with actual values
SET @user_id = YOUR_USER_ID;
SET @plan_id = YOUR_PLAN_ID;
SET @tomorrow = DATE_ADD(CURDATE(), INTERVAL 1 DAY);
SET @today = CURDATE();

-- Create/Update free trial record
INSERT INTO user_subscription_free_trials (user_id, plan_id, created_at, updated_at)
VALUES (@user_id, @plan_id, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- Delete existing free subscriptions
DELETE FROM user_subscription WHERE user_id = @user_id AND status = 'free';

-- Create free trial subscription expiring tomorrow
INSERT INTO user_subscription (user_id, plan_id, start_date, end_date, duration_days, status, created_at, updated_at)
VALUES (@user_id, @plan_id, @today, @tomorrow, 1, 'free', NOW(), NOW());
```

### Step 2: Run the Pre-Expiry Notification Command

```bash
php artisan trials:send-pre-expiry-notifications
```

### Step 3: Verify Results

**Check Command Output:**
- Should show: "Found X free trials expiring tomorrow."
- Should show: "Pre-expiry notification sent to user ID: X"

**Check Email:**
- Check your email inbox (or mailtrap/test email service)
- Look for email with subject: "Your Free Trial Expires Tomorrow"
- Verify email content includes:
  - Trial expires in 1 day
  - Auto-upgrade notice
  - Cancel option
  - Manage subscription link

**Check Database:**
```sql
-- Check notification was created
SELECT * FROM notifications 
WHERE module_code = 'TRIAL_PRE_EXPIRY' 
AND from_user_id = YOUR_USER_ID
ORDER BY created_at DESC LIMIT 1;
```

**Check Logs:**
```bash
tail -f storage/logs/laravel.log
```
Look for: "Trial pre-expiry notification sent"

---

## Test Scenario 2: Trial Expiration - Auto-Upgrade (With Payment Method)

### Step 1: Set Up Test Data

**Using Tinker:**
```php
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionFreeTrial;
use App\Models\Pricing_plan;
use Carbon\Carbon;

$user = User::where('email', 'your-test-email@example.com')->first();
$plan = Pricing_plan::first();

// IMPORTANT: User must have a Stripe customer ID for auto-upgrade
// If testing with real Stripe, ensure user has valid stripe_customer_id
// For testing, you can set a test customer ID:
// $user->stripe_customer_id = 'cus_test123'; // Use test customer ID
// $user->save();

// Create free trial that expires TODAY (or yesterday)
$yesterday = Carbon::yesterday()->format('Y-m-d');
$today = Carbon::today()->format('Y-m-d');

// Delete existing free subscriptions
UserSubscription::where('user_id', $user->id)
    ->where('status', 'free')
    ->delete();

// Create free trial subscription that expired yesterday
$subscription = UserSubscription::create([
    'user_id' => $user->id,
    'plan_id' => $plan->id,
    'start_date' => Carbon::parse($yesterday)->subDays(29)->format('Y-m-d'),
    'end_date' => $yesterday, // Already expired
    'duration_days' => 30,
    'status' => 'free'
]);

echo "Created expired free trial for user {$user->id}";
```

**Using SQL:**
```sql
SET @user_id = YOUR_USER_ID;
SET @plan_id = YOUR_PLAN_ID;
SET @yesterday = DATE_SUB(CURDATE(), INTERVAL 1 DAY);
SET @start_date = DATE_SUB(@yesterday, INTERVAL 29 DAY);

DELETE FROM user_subscription WHERE user_id = @user_id AND status = 'free';

INSERT INTO user_subscription (user_id, plan_id, start_date, end_date, duration_days, status, created_at, updated_at)
VALUES (@user_id, @plan_id, @start_date, @yesterday, 30, 'free', NOW(), NOW());
```

### Step 2: Run the Expiration Command

```bash
php artisan subscriptions:update-expired
```

### Step 3: Verify Auto-Upgrade

**Check Command Output:**
- Should show: "Free trial for user ID X has been automatically renewed with payment."
- OR: "Auto-renewal payment failed..." (if payment method invalid)

**Check Database:**
```sql
-- Check old subscription status changed to 'free-expired'
SELECT * FROM user_subscription 
WHERE user_id = YOUR_USER_ID 
AND status = 'free-expired'
ORDER BY created_at DESC LIMIT 1;

-- Check new active subscription created
SELECT * FROM user_subscription 
WHERE user_id = YOUR_USER_ID 
AND status = 'active'
ORDER BY created_at DESC LIMIT 1;

-- Check payment record created
SELECT * FROM user_payments 
WHERE user_id = YOUR_USER_ID 
ORDER BY created_at DESC LIMIT 1;
```

**Check Email:**
- Should receive "Subscription Auto-Renewal" email
- OR "Payment Failed - Action Required" if payment failed

**Check Subscription Page:**
1. Login as the test user
2. Go to `/customer/mySubscription`
3. Should see "Selected Plan" button (disabled)
4. Should see "Cancel" button (active)

---

## Test Scenario 3: Trial Expiration - Manual Upgrade (No Payment Method)

### Step 1: Set Up Test Data

**Using Tinker:**
```php
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;

$user = User::where('email', 'your-test-email@example.com')->first();

// Ensure user has NO stripe_customer_id
$user->stripe_customer_id = null;
$user->save();

// Create expired free trial
$yesterday = Carbon::yesterday()->format('Y-m-d');

UserSubscription::where('user_id', $user->id)
    ->where('status', 'free')
    ->delete();

UserSubscription::create([
    'user_id' => $user->id,
    'plan_id' => 1, // Your plan ID
    'start_date' => Carbon::parse($yesterday)->subDays(29)->format('Y-m-d'),
    'end_date' => $yesterday,
    'duration_days' => 30,
    'status' => 'free'
]);
```

### Step 2: Run the Expiration Command

```bash
php artisan subscriptions:update-expired
```

### Step 3: Verify Manual Upgrade Required

**Check Database:**
```sql
-- Old subscription should be 'free-expired'
SELECT * FROM user_subscription 
WHERE user_id = YOUR_USER_ID 
AND status = 'free-expired';

-- New active subscription should be created (even without payment)
SELECT * FROM user_subscription 
WHERE user_id = YOUR_USER_ID 
AND status = 'active'
ORDER BY created_at DESC LIMIT 1;
```

**Check Subscription Page:**
1. Login as the test user
2. Go to `/customer/mySubscription`
3. Should see "Buy Plan" button (not "Selected Plan")
4. User can click "Buy Plan" to manually upgrade

**Check Email:**
- Should receive "Free Trial Expired" email
- Email should include link to upgrade

---

## Test Scenario 4: Active Free Trial Display

### Step 1: Set Up Active Free Trial

**Using Tinker:**
```php
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionFreeTrial;
use Carbon\Carbon;

$user = User::where('email', 'your-test-email@example.com')->first();
$plan = Pricing_plan::first();

// Create active free trial (expires in 15 days)
$today = Carbon::today()->format('Y-m-d');
$future = Carbon::today()->addDays(15)->format('Y-m-d');

UserSubscriptionFreeTrial::firstOrCreate([
    'user_id' => $user->id,
    'plan_id' => $plan->id
]);

UserSubscription::where('user_id', $user->id)
    ->where('status', 'free')
    ->delete();

UserSubscription::create([
    'user_id' => $user->id,
    'plan_id' => $plan->id,
    'start_date' => $today,
    'end_date' => $future,
    'duration_days' => 15,
    'status' => 'free'
]);
```

### Step 2: Verify Display

1. Login as the test user
2. Go to `/customer/mySubscription`
3. Should see:
   - "Free Trial" button (disabled/grayed out)
   - "Cancel" button (active/clickable)

---

## Quick Test Commands

### Check Current Trial Status
```php
php artisan tinker

use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;

$user = User::where('email', 'your-email@example.com')->first();

// Check active free trial
$trial = UserSubscription::where('user_id', $user->id)
    ->where('status', 'free')
    ->where('end_date', '>=', Carbon::today())
    ->first();

if ($trial) {
    echo "Active trial expires: {$trial->end_date}\n";
    echo "Days remaining: " . Carbon::parse($trial->end_date)->diffInDays(Carbon::today()) . "\n";
} else {
    echo "No active free trial found\n";
}
```

### List All Expiring Trials
```php
php artisan tinker

use App\Models\UserSubscription;
use Carbon\Carbon;

$tomorrow = Carbon::tomorrow()->format('Y-m-d');
$expiring = UserSubscription::where('status', 'free')
    ->where('end_date', $tomorrow)
    ->with('plan')
    ->get();

foreach ($expiring as $sub) {
    echo "User ID: {$sub->user_id}, Plan: {$sub->plan->title}, Expires: {$sub->end_date}\n";
}
```

---

## Testing Checklist

- [ ] Pre-expiry notification sent 1 day before
- [ ] Email content is correct
- [ ] Notification record created in database
- [ ] Auto-upgrade works with payment method
- [ ] Auto-upgrade creates new active subscription
- [ ] Payment record created on auto-upgrade
- [ ] "Buy Plan" button shows when no payment method
- [ ] "Selected Plan" button shows after upgrade (disabled)
- [ ] "Cancel" button works after upgrade
- [ ] "Free Trial" button shows during active trial (disabled)
- [ ] Subscription page displays correctly for all states

---

## Troubleshooting

### Email Not Sending
- Check `.env` mail configuration
- Check `storage/logs/laravel.log` for errors
- Verify email address is valid
- Check spam folder

### Command Not Finding Trials
- Verify `end_date` format is `Y-m-d` (e.g., `2024-01-15`)
- Check timezone settings in `config/app.php`
- Verify `status = 'free'` in database

### Auto-Upgrade Not Working
- Verify user has `stripe_customer_id` set
- Check Stripe API keys in settings
- Review `storage/logs/laravel.log` for Stripe errors
- Ensure Stripe customer has valid payment method

### Subscription Page Not Showing Correct Buttons
- Clear browser cache
- Check `activeTrialSubscription` is being passed to view
- Verify subscription status in database
- Check view logic in `resources/views/customer/subscriptions.blade.php`

---

## Notes

1. **Time Zones**: All dates use server timezone. Check `config/app.php` timezone setting.

2. **Stripe Testing**: For auto-upgrade testing, use Stripe test mode and test customer IDs.

3. **Email Testing**: Use Mailtrap, MailHog, or similar service for email testing.

4. **Database Cleanup**: After testing, clean up test data:
   ```sql
   DELETE FROM user_subscription WHERE user_id = YOUR_TEST_USER_ID;
   DELETE FROM user_subscription_free_trials WHERE user_id = YOUR_TEST_USER_ID;
   DELETE FROM notifications WHERE from_user_id = YOUR_TEST_USER_ID AND module_code = 'TRIAL_PRE_EXPIRY';
   ```

5. **Scheduled Tasks**: Commands run automatically via cron. For testing, run manually as shown above.
