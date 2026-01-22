# Database Testing Steps - Changing Dates in phpMyAdmin

## Test Scenario 1: Pre-Expiry Notification (Tomorrow)

**Step 1:** Open phpMyAdmin → Select `lease_match` database → Click `user_subscription` table → Click "Browse"

**Step 2:** Find a subscription with `status = 'free'`, click "Edit" on that row

**Step 3:** Change `end_date` to tomorrow's date (e.g., if today is Jan 17, set to `2026-01-18`), click "Go"

**Step 4:** Run command: `php artisan trials:send-pre-expiry-notifications` - check email for notification

---

## Test Scenario 2: Active Free Trial Display (Current/Future Date)

**Step 1:** Open phpMyAdmin → `user_subscription` table → Click "Browse" → Find subscription with `status = 'free'` → Click "Edit"

**Step 2:** Set `end_date` to future date (e.g., `2026-02-15`), ensure `status = 'free'`, ensure `start_date` is today or past → Click "Go"

**Step 3:** Login as that user → Go to `/customer/mySubscription` → Should see "Free Trial" button (disabled) + "Cancel" button

---

## Test Scenario 3: Trial Expiration - Auto-Upgrade (Yesterday/Past Date)

**Step 1:** Open phpMyAdmin → `user_subscription` table → Find subscription with `status = 'free'` → Click "Edit"

**Step 2:** Change `end_date` to yesterday or past date (e.g., `2026-01-16`), keep `status = 'free'` → Click "Go"

**Step 3:** Ensure user has `stripe_customer_id` in `users` table (check `users` table → Edit user → verify `stripe_customer_id` field)

**Step 4:** Run command: `php artisan subscriptions:update-expired` → Check `user_subscription` table - old should be `'free-expired'`, new should be `'active'`
