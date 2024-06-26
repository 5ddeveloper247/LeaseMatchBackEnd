<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentIntent;
use App\Models\User;
use App\Models\Pricing_plan;
use App\Models\UserSubscription;
use App\Models\UserPayments;
use Carbon\Carbon;
use Session;

class PaymentController extends Controller
{
    public function showSubscriptionForm()
    {
        $subscriptions = Pricing_plan::all();
        return view('payment', compact('subscriptions'));
    }

    public function processSubscription(Request $request)
    {
        $request->validate([
            'plan_id' => 'required',
            'stripeToken' => 'required',
        ]);

        $user = User::find(Auth::user()->id);
        $plan_detail = Pricing_plan::findOrFail($request->plan_id);

        Stripe::setApiKey(getStripeSk());//env('STRIPE_SECRET')

        // Create Stripe customer if not already exists
        if (!$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $user->email,
                'source' => $request->stripeToken,
            ]);
            
            $user->stripe_customer_id = $customer->id;
            $user->save();
        } else {
            $customer = Customer::retrieve($user->stripe_customer_id);
        }

        $charge = \Stripe\Charge::create([
            'amount' => $plan_detail->monthly_price * 100, // Amount in cents
            'currency' => 'usd',
            'customer' => $customer->id, // Use the customer ID
            'description' => 'Payment for order',
        ]);

        $payment = new UserPayments();
        $payment->user_subscription_id = null;
        $payment->user_id = Auth::user()->id;
        $payment->plan_id = $plan_detail->id;
        $payment->payment_method_id = null;
        $payment->amount = $plan_detail->monthly_price;
        $payment->transaction_id = $charge->id;
        $payment->stripe_customer_id = $customer->id;
        $payment->stripe_subscription_id = null;
        $payment->status = $charge->status;
        $payment->response = json_encode($charge, true);
        $payment->date = Carbon::now()->format('Y-m-d');
        $payment->save();
        
        if($charge->status == 'succeeded'){
            
            $duration_days = 30;
            $start_date = Carbon::now()->format('Y-m-d');
            $date = Carbon::createFromFormat('Y-m-d', $start_date);
            $end_date = $date->addDays($duration_days)->format('Y-m-d');
            
            // if already buy plan then set to end date and then add new entry
            $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
            if($currentPlan){
                $currentPlan->end_date = Carbon::now()->format('Y-m-d');
                $currentPlan->save();
            }
            // add new plan entry in table
            $userSubscription = new UserSubscription();
            $userSubscription->user_id = Auth::user()->id;
            $userSubscription->plan_id = $plan_detail->id;
            $userSubscription->start_date = $start_date;
            $userSubscription->end_date = $end_date;
            $userSubscription->duration_days = $duration_days;
            $userSubscription->save();

            $payment->user_subscription_id = $userSubscription->id;
            $payment->save();

            $mailData['name'] = $user->first_name;
            $mailData['email'] = $user->email;
            $mailData['plan_name'] = $plan_detail->title;
            $mailData['plan_start'] = $start_date;
            $mailData['plan_end'] = $end_date;
            
            $body = view('emails.buy_plan_mail_tenant', $mailData);
            $userEmailsSend[] = $user->email;//'hamza@5dsolutions.ae';//
            // to username, to email, from username, subject, body html
            sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'Subscription Purchase', $body);

            if(!$currentPlan){ //admin email send for first time buy
                $body = view('emails.buy_plan_mail_admin', $mailData);
                $userEmailsSend[] = env('MAIL_ADMIN');
                // to username, to email, from username, subject, body html
                sendMail('Admin', $userEmailsSend, 'LEASE MATCH', 'Subscription Purchase', $body);
            }
            
            Session::flash('success', 'Payment Successful');
        }else{
            Session::flash('error', 'Payment Failed');
        }
        
        return redirect()->route('customer.mySubscription');
        // return redirect()->route('subscribe.success');
    }

    public function subscriptionSuccess()
    {
        return view('subscription-success');
    }

    public function subscriptionError()
    {
        return view('subscription-error');
    }
}
