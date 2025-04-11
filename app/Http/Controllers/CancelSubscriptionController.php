<?php

namespace App\Http\Controllers;

use App\Models\UserSubscription;
use App\Models\Pricing_plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Stripe\Stripe;
use Log;

class CancelSubscriptionController extends Controller
{

    public function cancelSubscription(Request $request)
    {
        try {
            // Validate the request
            $validator = \Validator::make($request->all(), [
                'id' => 'required|exists:user_subscription,id',
                'cancellation_reason' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->errors()->first()
                ]);
            }
            
            $user = Auth::user();  
            $subscription = UserSubscription::findOrFail($request->id);

            // Verify the subscription belongs to the current user
            if ($subscription->user_id != Auth::user()->id) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are not authorized to cancel this subscription'
                ]);
            }

            // Only active subscriptions can be cancelled
            if ($subscription->status == 'cancelled') {
                return response()->json([
                    'status' => 400,
                    'message' => 'This subscription is already cancelled or expired'
                ]);
            }
            if(is_null($subscription->stripe_subscription_id)){
                $subscription->status = 'free-expired';
                $subscription->end_date = Carbon::now()->subDay()->format('Y-m-d H:i:s');  // Set end date to today
                $subscription->cancelled_at = Carbon::now()->format('Y-m-d H:i:s');
                $subscription->cancellation_reason = $request->cancellation_reason;
                $subscription->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Subscription cancellation request submitted successfully.'
                ]);
            }
            // Call the method to cancel the subscription
            $cancelResult = $this->cancelStripeSubscription($user, $subscription, $request->cancellation_reason);

            if ($cancelResult['status'] === 'success') {
                return response()->json([
                    'status' => 200,
                    'message' => 'Subscription cancellation request submitted successfully.'
                ]);
                // return redirect()->route('customer.mySubscription')->with('success', 'Your subscription has been successfully cancelled.');
            } else {
                return response()->json([
                    'status' => 422,
                    'message' => 'There was an error cancelling your subscription. Please try again later.'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    
    private function cancelStripeSubscription(User $user, UserSubscription $currentSubscription, $reason = null)
    {
        try {
            // Set the Stripe API key
            Stripe::setApiKey(getStripeSk());  // Replace with your actual secret key

            // Retrieve the user's subscription from Stripe
            $stripeSubscription = \Stripe\Subscription::retrieve($currentSubscription->stripe_subscription_id);

            // Cancel the subscription on Stripe
            $stripeSubscription->cancel();

            // Update the subscription status in the database
            $currentSubscription->status = 'cancelled';
            $currentSubscription->end_date = Carbon::now()->subDay()->format('Y-m-d H:i:s');  // Set end date to today
            $currentSubscription->cancelled_at = Carbon::now()->format('Y-m-d H:i:s');
            $currentSubscription->cancellation_reason = $reason;
            $currentSubscription->save();

            // Optionally, send a confirmation email to the user
            // $mailData = [
            //     'name' => $user->first_name,
            //     'email' => $user->email,
            //     'subscription_status' => 'Cancelled',
            // ];

            // You can create a dedicated email template for subscription cancellation
            //Mail::to($user->email)->send(new SubscriptionCancelledMail($mailData));

            // Log cancellation
            Log::info("Subscription cancelled for user: {$user->id}");

            return ['status' => 'success', 'message' => 'Subscription cancelled successfully.'];
        } catch (\Exception $e) {
            // Log the error if something goes wrong
            Log::error("Failed to cancel subscription for user {$user->id}: " . $e->getMessage());

            return ['status' => 'error', 'message' => 'There was an error cancelling your subscription. Please try again later.'];
        }
    }
}
