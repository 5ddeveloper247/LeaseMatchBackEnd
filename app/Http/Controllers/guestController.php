<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pricing_plan;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;

class guestController extends Controller
{
    //

    public function guestSubscriptions(Request $request)
    {
        $data['page'] = 'Subscription';
        $data['plans'] = Pricing_plan::all();


        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        $data['currentPlan'] = isset($currentPlan->plan_id) ? $currentPlan : '';
        return view('customer/guest/subscriptions', with($data));
    }
}
