<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pricing_plan;
use App\Models\Menu;
use App\Models\MenuControl;
use App\Models\UserSubscription;
use App\Models\Api\UserPersonalInfo;
use App\Models\EnquiryHeader;
use Illuminate\Support\Facades\Validator;

// landlord models
use App\Models\Api\LandlordPersonal;
use App\Models\Api\LandlordProperty;
use App\Models\Api\LandlordRental;
use App\Models\Api\LandlordTenant;
use App\Models\Api\LandlordAdditional;
use App\Models\Api\LandlordPropertyImages;

class CustomerController extends Controller
{
    public function __construct()
    {
        
    }

    public function noaccess(Request $request)
    {
        $data['error'] = 'Access denied. You do not have permission to access this page.';
        $data['page'] = '';
        return view('customer/noaccess')->with($data);
    }
    
    public function login(Request $request)
    {
        $data['page'] = 'Login';
        return view('customer/login')->with($data);
    }

    public function loginSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|exists:users,email',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            if($user->status == 1){
                $request->session()->put('user', $user);
                // Authentication passed...
                return redirect()->intended('/customer/dashboard');
            }else{
                $request->session()->flash('error', 'The user is not active, please contact admin.');
                return redirect('customer/login');
            }
            
        }

        $request->session()->flash('error', 'The provided credentials do not match our records.');
        return redirect('customer/login');
    }

    public function logout(Request $request)
    {

        $request->session()->forget('user');

        return redirect('customer');
    }

    public function dashboard(Request $request)
    {
        if(checkUserSubscription() == true){
            $data['page'] = 'Dashboard';
        
            return view('customer/dashboard')->with($data);
        }else{
            return redirect()->route('customer.mySubscription');
        }
    }

    public function my_subscription(Request $request)
    {
        $data['page'] = 'Subscription';
        $data['plans'] = Pricing_plan::get();

        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
        $data['currentPlan'] = isset($currentPlan->plan_id) ? $currentPlan : '';

        return view('customer/subscriptions')->with($data);
    }

    public function my_matches(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        
        $data['page'] = 'Matches';

        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->where('start_date', '<=', $currentDate)
                                                    ->where('end_date', '>=', $currentDate)
                                                    ->with('plan')->orderBy('created_at', 'desc')->first();

        if(isset($currentPlan->id)){
            $data['properties'] = LandlordPersonal::with(['propertyDetail','rentalDetail','tenantDetail',
                                        'additionalDetail','propertyImages'])->limit($currentPlan->plan->number_of_matches)
                                        ->orderBy('created_at', 'desc')->get();
        }else{
            $data['properties'] = array();
        }
        
        return view('customer/my_matches')->with($data);
    }

    public function property_detail(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        
        $data['page'] = 'Matches';
        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->where('start_date', '<=', $currentDate)
                                ->where('end_date', '>=', $currentDate)
                                ->with('plan')->orderBy('created_at', 'desc')->first();

        $data['property_detail'] = LandlordPersonal::where('id', $request->landlord_id)->
                                        with(['propertyDetail','rentalDetail','tenantDetail',
                                        'additionalDetail','propertyImages'])
                                ->first();
        
        $data['curr_plan'] = isset($currentPlan->plan) ? $currentPlan->plan : '';
        // dd($data['property_detail']);
        return view('customer/property_detail')->with($data);
    }

    public function forgotpassword(){
        return view('customer/forgot_password');
    }











    public function forgot_password_validate_email(Request $request){
      
        $request->validate([
            'email' => 'required|email',

        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json(['status' => 402, 'message' => "Email is not registered in our system"]);
        }
        else{
                $mailData = [];
                $otp = implode('', array_map(function() {
                    return mt_rand(0, 9);
                }, range(1, 5)));
                $user->otp_code = $otp;
                $user->otp_created_at = date('Y-m-d H:i:s');
                $user->save();
                $mailData['otp'] = $otp;
                $mailData['username'] = $user->first_name;
                $body = view('emails.forgot_password', $mailData);
                $userEmailsSend[] = $user->email;
                // to username, to email, from username, subject, body html
                
                sendMail($user->first_name, $userEmailsSend, 'Lease Match', 'Password Reset Request', $body); // send_to_name, send_to_email, email_from_name, subject, body
                return response()->json(['status' => 200, 'message' => "otp is sent to your registered email"]);
        
        }

    }

    public function verify_otp(Request $request){
        $request->validate([
            'otp' => 'required|max:5',

        ]);
        $otp = $request->otp;
        $email = $request->email;

        $user = User::where('email', $request->email)->first();
        if($user->otp_code == null){
            return response()->json(['status' => 402, 'message' => "Invalid request"]);
        }
        if($otp == $user->otp_code){
            return response()->json(['status' => 200, 'message' => "otp validated, kindly enter your new password"]);
        }
        else{
            return response()->json(['status' => 402, 'message' => "otp mismatch, kindly use the otp we sent you"]);
            
        }
    }

    public function reset_password(Request $request){
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
            ],

        ],
        [
            'password.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);

        $user = User::where('email', $request->email)->first();
        if($user){
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return response()->json(['status' => 200, 'message' => "Passwrd changed successfully, kindly return to login page and login again"]);
        }
        
    }

    public function view_contact_info(Request $request){
        
        $landlord_id = $request->id;
        $currentDate = Carbon::now()->format('Y-m-d');

        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->where('start_date', '<=', $currentDate)
                                ->where('end_date', '>=', $currentDate)
                                ->with('plan')->orderBy('created_at', 'desc')->first();
        
        if(isset($currentPlan->plan) && $currentPlan->plan->directly_contact_flag == 1){

            $data['landlord_detail'] = LandlordPersonal::find($landlord_id);
            return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
        }else{
        
            return response()->json(['status' => 402, 'message' => "Unable to view landlord information, please update/buy package to view contact information."]);
        }
    }
    
    

    public function my_account(){
        $data['page'] = 'My Account';
        return view('customer/my_account')->with($data);
    }
    
    
    public function property_info(){
        $user_id = Auth::id();
        $data['page'] = 'Property Information';
        $data['tenant_list'] = User::where('type', 3)->where('id',$user_id)->with(['personalInfo'])->get();
        return view('customer/property_info')->with($data);
    }

    public function get_specific_tenant(){
        $tenant_id = Auth::id();
        $data['details'] = User::where('id', $tenant_id)->where('type', 3)
                                        ->with(['personalInfo','residentialInfo','financialInfo',
                                                'rentalInfo','livingInfo','householdInfo',
                                                'petInfo','accomodationInfo','additionalInfo',
                                                'legalInfo','references','additionalNote','userDocs'])
                                        ->first();
        
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_profiledata(){
        $user_id = Auth::id();
        $data['details'] = User::where('id', $user_id)->where('type', 3)
        ->with(['personalInfo','residentialInfo','financialInfo',
                'rentalInfo','livingInfo','householdInfo',
                'petInfo','accomodationInfo','additionalInfo',
                'legalInfo','references','additionalNote','userDocs'])
        ->first();
        
        return response()->json(['status' => 200, 'data' => $data]);
    }
    public function update_profile(Request $request){
        $user_id = Auth::id();
        $user = User::find($user_id);
        $request->validate([
            'first_name' => 'required',
            'phone_number' => 'max:18'
        ]);
        if($request->password){
             $request->validate([
            'first_name' => 'required',
            'phone_number' => 'max:18',
            'old_password' => 'required',
            'password' => [
                'required',
                'string',
                'min:8', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
            ],

        ],
        [
            'password.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);
        $credentials = [
            'email' => $user->email,
            'password' => $request->old_password,
        ];

        if (Auth::attempt($credentials)) {
            $user->first_name = $request->first_name;
            $user->phone_number = $request->phone_number;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json(['status' => 200, 'message' => 'Profile Updated Successfully']);
        }
        else{
            return response()->json(['status' => 402, 'message' => "Old password is incorrect"]);
        }
        }
        else{
            $user->first_name = $request->first_name;
            $user->phone_number = $request->phone_number;
            $user->save();
            return response()->json(['status' => 200, 'message' => 'Profile Updated Successfully']);
        }

        
    }
    public function update_personal_data(Request $request){
        $user_id = Auth::id();
        $user = UserPersonalInfo::where('user_id',$user_id)->first();

        if($request->name){
            $user->name = $request->name;
        }
        if($request->email){
            $user->email = $request->email;
        }
        if($request->date_of_birth){
            $user->date_of_birth = $request->date_of_birth;
        }
        if($request->phone_number_personal){
            $user->phone_number = $request->phone_number_personal;
        }
        $user->save();
        return response()->json(['status' => 200, 'message' => 'Profile Updated Successfully']);

    }

    public function process_app_request(Request $request){
        
        $user_id = Auth::id();
        
        $request->validate([
            'landlord_id' => 'required',
            'process_type' => 'required',
            'process_message' => 'required|max:100',
        ]);
        
        $enquiry = EnquiryHeader::where('user_id', Auth::user()->id)->where('landlord_id', $request->landlord_id)->first();
        
        // if(isset($check->id)){
        //     return response()->json(['status' => 402, 'message' => 'Request already submitted!']);
        // }
        
        if(!isset($enquiry->id)){
            $enquiry = new EnquiryHeader();
            $enquiry->user_id = Auth::user()->id;
            $enquiry->landlord_id = $request->landlord_id;
            $enquiry->date = Carbon::now()->format('Y-m-d');
            $enquiry->status = '1'; //
            $enquiry->created_by = Auth::user()->id;
            $enquiry->save();
        }

        $enquiryDetail = new EnquiryDetail();
        $enquiryDetail->enquiry_id = $enquiry->id;
        $enquiryDetail->type = $request->type;
        $enquiryDetail->date = Carbon::now()->format('Y-m-d');
        $enquiryDetail->status = '1'; //
        $enquiryDetail->created_by = Auth::user()->id;
        $enquiryDetail->save();
        
    
        return response()->json(['status' => 200, 'message' => 'Your request is submited successfully, we will respond you soon, Thanks']);
        
    }
}
