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
use Illuminate\Support\Facades\Validator;

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
}
