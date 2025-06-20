<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pricing_plan;
use App\Models\CustomerCardProcess;
use App\Models\UserPayments;
use App\Models\Notifications;
use App\Models\UserSubscriptionFreeTrial;
use App\Models\UserSubscription;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
//stripe
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;


class guestController extends Controller
{
    // customer.guest.payment_form
    public function guestTrailPaymentForm(Request $request, $plan_id)
    {
        // dd($plan_id);
        $data['page'] = 'Payment Form';
        $data['plans'] = Pricing_plan::all();
        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        $check_trial = UserSubscriptionFreeTrial::where('user_id', Auth::user()->id)->first();
        $is_trial = false;
        if ($check_trial) {
            $is_trial = true;
        }
        $data['is_trial'] = $is_trial;
        $data['plan_id'] = $plan_id;
        $data['currentPlan'] = isset($currentPlan->plan_id) ? $currentPlan : '';
        $plan_detail = Pricing_plan::findOrFail($plan_id);
        $data['plan_detail'] = $plan_detail;
        // dd(
        //     $data['plan_detail']
        // );
        return view('customer/guest/trail_payment_form', with($data));
    }

    public function guestSubscriptions(Request $request)
    {

        // dd("ok");
        $data['page'] = 'Payment Form';

        // Get all plans
        $plans = Pricing_plan::all();
        $data['plans'] = $plans;

        // Get the free trial plan
        $trialPlan = Pricing_plan::where('free_trial', 1)->firstOrFail();
        $plan_id = $trialPlan->id;
        $data['plan_id'] = $plan_id;

        // Get user's latest subscription
        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $data['currentPlan'] = $currentPlan ?? '';

        // Check if the user has already used free trial
        $check_trial = UserSubscriptionFreeTrial::where('user_id', Auth::user()->id)->first();
        $is_trial = false;

        if (!$check_trial) {
            // Save free trial to DB if not already used
            UserSubscriptionFreeTrial::create([
                'user_id' => Auth::user()->id,
                'plan_id' => $plan_id,
                'payment_method_id' => null, // Will be updated later during form submission
                'started_at' => now(),
            ]);
            $is_trial = true;
        } else {
            $is_trial = true;
        }

        $data['is_trial'] = $is_trial;

        // Plan details (e.g. pricing for summary section)
        $plan_detail = Pricing_plan::findOrFail($plan_id);
        $data['plan_detail'] = $plan_detail;

        // Create Stripe SetupIntent
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $intent = \Stripe\SetupIntent::create();

        return view('customer/guest/trail_payment_form', [
            'data' => $data,
            'plan_id' => $plan_id,
            'clientSecret' => $intent->client_secret,
        ]);
    }

    public function guestCardProcess(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = Auth::user()->id;
        $plan_id = $request->plan_id;

        CustomerCardProcess::create([
            'customer_id' => $data['user_id'],
            'card_number' => Crypt::encryptString($data['card_number']),
            'cvv' => Crypt::encryptString($data['card_cvc']),
            'expiry' => Crypt::encryptString($data['card_expiry']),
            'zip' => Crypt::encryptString($data['card_zip']),
            'status' => '1',
        ]);

        $existingTrial = UserSubscriptionFreeTrial::where('user_id', $data['user_id'])->first();
        if ($existingTrial) {
            $existingTrial->delete();
        }
        UserSubscriptionFreeTrial::create([
            'user_id' => $data['user_id'],
            'plan_id' => $plan_id,
        ]);
        $user = User::find(Auth::user()->id);

        $plan_detail = Pricing_plan::findOrFail($plan_id);
        $payment = new UserPayments();
        $payment->user_subscription_id = null;
        $payment->user_id = Auth::user()->id;
        $payment->plan_id = $plan_detail->id;
        $payment->payment_method_id = null;
        $payment->amount = $plan_detail->monthly_price;
        $payment->transaction_id = null;
        $payment->stripe_customer_id = $user->id;
        $payment->stripe_subscription_id = null;
        // $payment->status = 0;
        $payment->status = 'free';
        $payment->response = json_encode(["type" => "free_trial", "reason" => "Customer Trial Payment"], true);
        $payment->reason = "free trial payment";
        $payment->date = Carbon::now()->format('Y-m-d');
        $payment->save();
        $duration_days = 30;
        $start_date = Carbon::now()->format('Y-m-d');
        $date = Carbon::createFromFormat('Y-m-d', $start_date);
        $end_date = $date->addDays($duration_days)->format('Y-m-d');

        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        if ($currentPlan) {
            $currentPlan->end_date = Carbon::now()->format('Y-m-d');
            $currentPlan->save();
        }

        $userSubscription = new UserSubscription();
        $userSubscription->user_id = Auth::user()->id;
        $userSubscription->plan_id = $plan_detail->id;
        $userSubscription->start_date = $start_date;
        $userSubscription->end_date = $end_date;
        $userSubscription->duration_days = $duration_days;
        $userSubscription->status = "free";
        $userSubscription->save();
        $payment->user_subscription_id = $userSubscription->id;
        $payment->save();
        $Notification = new Notifications();
        $Notification->module_code =  'BUY SUBSCRIPTION';
        $Notification->from_user_id =   Auth::user()->id;
        $Notification->to_user_id =  '1'; // for admin notification
        $Notification->subject =  "Tenant subscribe to a free tiral Plan";
        $Notification->message =  "The tenant has successfully subscribe to a free tiral of a " . $plan_detail->title . " subscription.";
        $Notification->read_flag =  '0';
        $Notification->created_by =  Auth::user()->id;
        $Notification->save();
        return redirect()->intended('/customer/mySubscription'); //dashboard
    }

    public function guestTrailCardProcess(Request $request)
    {

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;
        $plan_id = $data['plan_id'];

        if (Session::has('trialData')) {
            $trialData = Session::get('trialData');
            $plan_id = $trialData['plan'] == null ? 1 : $trialData['plan'];
            Session::forget('trialData');
        }

        CustomerCardProcess::create([
            'customer_id' => $data['user_id'],
            'card_number' => Crypt::encryptString($data['card_number']),
            'cvv' => Crypt::encryptString($data['card_cvc']),
            'expiry' => Crypt::encryptString($data['card_expiry']),
            'zip' => Crypt::encryptString($data['card_zip']),
            'status' => '1',
        ]);


        $existingTrial = UserSubscriptionFreeTrial::where('user_id', $data['user_id'])->first();
        if ($existingTrial) {
            $existingTrial->delete();
        }


        UserSubscriptionFreeTrial::create([
            'user_id' => $data['user_id'],
            'plan_id' => $plan_id,
        ]);
        $user = User::find(Auth::user()->id);

        $plan_detail = Pricing_plan::findOrFail($plan_id);

        $payment = new UserPayments();
        $payment->user_subscription_id = null;
        $payment->user_id = Auth::user()->id;
        $payment->plan_id = $plan_detail->id;
        $payment->payment_method_id = null;
        $payment->amount = $plan_detail->monthly_price;
        $payment->transaction_id = null;
        $payment->stripe_customer_id = $user->id;
        $payment->stripe_subscription_id = null;
        //$payment->status = 0; 
        $payment->status = 'free';
        $payment->response = json_encode(["type" => "free_trial", "reason" => "Customer Trial Payment"], true);
        $payment->reason = "free trial payment";
        $payment->date = Carbon::now()->format('Y-m-d');
        $payment->save();
        $duration_days = 30;
        $start_date = Carbon::now()->format('Y-m-d');
        $date = Carbon::createFromFormat('Y-m-d', $start_date);
        $end_date = $date->addDays($duration_days)->format('Y-m-d');

        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        if ($currentPlan) {
            $currentPlan->end_date = Carbon::now()->format('Y-m-d');
            $currentPlan->save();
        }

        $userSubscription = new UserSubscription();
        $userSubscription->user_id = Auth::user()->id;
        $userSubscription->plan_id = $plan_detail->id;
        $userSubscription->start_date = $start_date;
        $userSubscription->end_date = $end_date;
        $userSubscription->duration_days = $duration_days;
        $userSubscription->status = "free";
        $userSubscription->save();
        $payment->user_subscription_id = $userSubscription->id;
        $payment->save();
        $Notification = new Notifications();
        $Notification->module_code =  'BUY SUBSCRIPTION';
        $Notification->from_user_id =   Auth::user()->id;
        $Notification->to_user_id =  '1';             //for admin notification
        $Notification->subject =  "Tenant subscribe to a free trial Plan";
        $Notification->message =  "The tenant has successfully subscribe to a free tiral of a " . $plan_detail->title . " subscription.";
        $Notification->read_flag =  '0';
        $Notification->created_by =  Auth::user()->id;
        $Notification->save();
        // dd('Payment Success');
        // set user on session
        $request->session()->put('user', Auth::user());

        // Log::info('User logged in: ' . Auth::user()->id);

        return redirect()->intended('/customer/mySubscription'); //dashboard
    }

    
    public function stripeCardStore(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $user = Auth::user();
        $paymentMethodId = $request->input('payment_method');

        // Get plan_id from session first, then fallback to request input
        $planId = $request->session()->get('plan_id') ?? 1;

        // Validate that we have a plan_id
        if (!$planId) {
            return response()->json([
                'success' => false,
                'message' => 'Plan ID is required for subscription.',
            ], 400);
        }

    
        try {
            // Step 1: Create a Stripe Customer if not already
            if (!$user->stripe_customer_id) {
                $customer = Customer::create([
                    'email' => $user->email,
                    'name'  => $user->name,
                ]);
                $user->stripe_customer_id = $customer->id;
            } else {
                $customer = Customer::retrieve($user->stripe_customer_id);
            }

            // Step 2: Attach payment method to customer
            PaymentMethod::retrieve($paymentMethodId)->attach([
                'customer' => $customer->id
            ]);

            // Step 3: Set as default payment method
            Customer::update($customer->id, [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethodId,
                ],
            ]);

            // Step 4: Get plan details
            $plan_detail = Pricing_plan::findOrFail($planId);

            // Step 5: Handle existing free trial
            $existingTrial = UserSubscriptionFreeTrial::where('user_id', $user->id)->first();
            if ($existingTrial) {
                $existingTrial->update(['payment_method_id' => $paymentMethodId]);
            }

            // Step 6: End current subscription if exists
            $currentPlan = UserSubscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($currentPlan) {
                $currentPlan->end_date = Carbon::now()->format('Y-m-d');
                $currentPlan->status = 'ended';
                $currentPlan->save();
            }

            // Step 7: Create UserPayments record
            $payment = new UserPayments();
            $payment->user_id = $user->id;
            $payment->plan_id = $plan_detail->id;
            $payment->payment_method_id = NULL;
            $payment->amount = $plan_detail->monthly_price;
            $payment->stripe_customer_id = $customer->id;
            $payment->status = $existingTrial ? 'free' : 'active'; // Free if trial exists, otherwise active
            $payment->response = json_encode([
                "type" => $existingTrial ? "free_trial_with_card" : "paid_subscription",
                "payment_method_id" => $paymentMethodId,
                "customer_id" => $customer->id,
                "plan_id" => $planId
            ]);
            $payment->reason = $existingTrial ? "free trial with card setup" : "paid subscription";
            $payment->date = Carbon::now()->format('Y-m-d');
            $payment->save();

            // Step 8: Create UserSubscription record
            $duration_days = $existingTrial ? 30 : 30; // You can adjust this based on plan
            $start_date = Carbon::now()->format('Y-m-d');
            $end_date = Carbon::now()->addDays($duration_days)->format('Y-m-d');

            $userSubscription = new UserSubscription();
            $userSubscription->user_id = $user->id;
            $userSubscription->plan_id = $plan_detail->id;
            $userSubscription->start_date = $start_date;
            $userSubscription->end_date = $end_date;
            $userSubscription->duration_days = $duration_days;
            $userSubscription->status = $existingTrial ? 'free' : 'active';
            $userSubscription->save();

            // Step 9: Update payment with subscription ID
            $payment->user_subscription_id = $userSubscription->id;
            $payment->save();

            // Step 10: Save user's Stripe info
            $user->stripe_payment_method_id = $paymentMethodId;
            $user->save();

            // Step 11: Create notification
            $Notification = new Notifications();
            $Notification->module_code = 'CARD_SETUP';
            $Notification->from_user_id = $user->id;
            $Notification->to_user_id = '1'; // for admin notification
            $Notification->subject = "Payment Method Setup";
            $Notification->message = "User has successfully set up payment method for " . $plan_detail->title . " plan.";
            $Notification->read_flag = '0';
            $Notification->created_by = $user->id;
            $Notification->save();

            // Step 12: IMPORTANT - Remove plan_id from session after successful payment setup
            $request->session()->forget('plan_id');

            return response()->json([
                'success' => true,
                'message' => 'Card saved and subscription activated successfully.',
                'subscription_id' => $userSubscription->id,
                'payment_id' => $payment->id,
                'plan_id' => $planId,
                'plan_title' => $plan_detail->title
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stripe Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
