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
        if($check_trial) {
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
        $data['page'] = 'Subscription';
        $data['plans'] = Pricing_plan::all();


        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        $check_trial = UserSubscriptionFreeTrial::where('user_id', Auth::user()->id)->first();
        $is_trial = false;
        if($check_trial) {
            $is_trial = true;
        }
        $data['is_trial'] = $is_trial;
        
        $data['currentPlan'] = isset($currentPlan->plan_id) ? $currentPlan : '';
        // dd($data);
        return view('customer/guest/subscriptions', with($data));
    }



    public function guestCardProcess(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $data['user_id'] = Auth::user()->id;
        $plan_id = "";
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
        // dd($data);
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
        // dd('Payment Success');
        // set user on session
        $request->session()->put('user', Auth::user());

        // Log::info('User logged in: ' . Auth::user()->id);
        return redirect()->intended('/customer/mySubscription'); //dashboard
    }
}
