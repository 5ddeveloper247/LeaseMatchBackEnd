# How Matches Work Through Registration

## Current System Flow

**During Registration:** Customer fills out registration form with preferences (property type, bedrooms, bathrooms, household size, location, etc.) → System saves all preferences to database but does NOT automatically create matches.

**After Registration:** Admin receives notification "Tenant Registration" → Admin goes to `/admin/property_matches` → System uses saved preferences to find matching landlords → Admin manually assigns matches to customer.

**Matching Logic:** System matches based on customer's saved preferences: property type, minimum bedrooms, minimum bathrooms, and household size (square feet) from registration data.

---

## How It Works

**Step 1:** Customer completes registration → Preferences saved in `residential_preference` and `household_info` tables.

**Step 2:** Admin clicks customer in Property Matches page → System queries landlords matching customer's preferences (property type, bedrooms >= needed, bathrooms >= needed, square feet >= household size).

**Step 3:** Admin assigns landlords → Matches created in `property_matches` table → Customer can view matches in "My Matches" page after login.

---

## Important Notes

**No Auto-Matching:** System does NOT automatically create matches during registration - admin must manually assign matches.

**Preference Requirements:** Customer must complete registration with all preference fields (property type, bedrooms, bathrooms, household size) for matching to work.

**Subscription Required:** Customer needs active subscription to view matches - system checks subscription status before showing matches.
