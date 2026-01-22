# Property Matches System - Guide

## How Matches Are Created in the System

**Automatic Matching:** System matches landlords to customers based on tenant preferences (property type, bedrooms, bathrooms, household size) and subscription plan limits.

**Manual Assignment:** Admin can manually assign landlords to customers through the admin panel at `/admin/property_matches`.

**Database:** Matches are stored in `property_matches` table with `user_id` (customer), `landlord_id`, `date`, and `created_by` (admin ID).

---

## Steps to Make Matches for a Customer

### Step 1: Access Property Matches Page
Login as admin → Navigate to `/admin/property_matches` or click "Property Matches" in admin menu.

### Step 2: Select Customer
Click on a customer from the list → System loads their preferences and shows matching landlords based on property type, bedrooms, bathrooms, and household size.

### Step 3: Assign Landlord
Review available landlords in the "Available Properties" section → Click "Assign" on a landlord → Confirm assignment → Match is created and customer can see it in their "My Matches" page.

---

## Important Notes

**Requirements:** Customer must have complete profile data (property type, bedrooms, bathrooms, household size) and active subscription with match limit.

**Limits:** Number of matches depends on customer's subscription plan (`number_of_matches` field in `pricing_plans` table).

**Filters:** Admin can search landlords by name, email, property type, or rental type before assigning.
