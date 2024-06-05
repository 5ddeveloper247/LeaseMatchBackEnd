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

use App\Models\Api\LandlordPersonal;
use App\Models\Api\LandlordProperty;
use App\Models\Api\LandlordRental;
use App\Models\Api\LandlordTenant;
use App\Models\Api\LandlordAdditional;
use App\Models\Api\LandlordPropertyImages;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    // Use dependency injection to bring in the PaymentEncode class
    public function __construct()
    {
        
    }

    public function noaccess(Request $request)
    {
        $data['error'] = 'Access denied. You do not have permission to access this page.';
        $data['page'] = '';
        return view('admin/noaccess')->with($data);
    }
    
    public function login(Request $request)
    {
        $data['page'] = 'Login';
        return view('admin/login')->with($data);
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
                return redirect()->intended('/admin/dashboard');
            }else{
                $request->session()->flash('error', 'The user is not active, please contact admin.');
                return redirect('admin/login');
            }
        }

        $request->session()->flash('error', 'The provided credentials do not match our records.');
        return redirect('admin/login');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect('admin');
    }

    public function dashboard(Request $request)
    {
        $data['page'] = 'Dashboard';
        
        return view('admin/dashboard')->with($data);
    }

    public function subscription(Request $request)
    {
        $data['page'] = 'Subscriptions';
        $data['plans'] = Pricing_plan::get();//orderBy('created_at', 'asc')->
        return view('admin/subscriptions')->with($data);
    }

    public function adminUser()
    {
        $data['page'] = 'Admin Users';
        return view('admin/admin_users')->with($data);
    }

    public function landlord()
    {
        $data['page'] = 'Landlord';
        return view('admin/landlord')->with($data);
    }

    public function editSpecificPlan(Request $request)
    {

        $plan_id = $request->plan_id;
        
        $data['plan_detail'] = Pricing_plan::where('id', $plan_id)->first();
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    public function savePlanDetail(Request $request)
    {
        $validatedData = $request->validate([
            'package_title' => 'required|max:100',
            'initial_price' => 'required|numeric|digits_between:1,5',
            'monthly_price' => 'required|numeric|digits_between:1,5',
            'number_matches' => 'required|numeric|digits_between:1,5',
        ]);

        $plan = Pricing_plan::find($request->plan_id);
        if(!isset($plan->id)){
            $plan = new Pricing_plan();
            $plan->id = $request->plan_id;
        }
        
        $plan->title = $request->package_title;
        $plan->initial_price = $request->initial_price;
        $plan->monthly_price = $request->monthly_price;
        $plan->number_of_matches = $request->number_matches;

        if(isset($request->tenant_directly_contact) && $request->tenant_directly_contact == 'on'){
            $plan->directly_contact_flag = 1;
        }else{
            $plan->directly_contact_flag = 0;
        }

        if(isset($request->process_application) && $request->process_application == 'on'){
            $plan->process_application_flag = 1;
        }else{
            $plan->process_application_flag = 0;
        }

        if(isset($request->necessary_document) && $request->necessary_document == 'on'){
            $plan->necessary_doc_flag = 1;
        }else{
            $plan->necessary_doc_flag = 0;
        }
        
        $plan->created_at = date('Y-m-d H:i:s');
        // Save the changes
        $plan->save();

        //Handle Registeration Payment
        return response()->json(['status' => 200, 'message' => "Plan updated successfully!"]);
    }

    public function get_admin_users_list()
    {
        $data['admin_list'] = User::where('type','2')->get();
        $data['inactive_users'] = User::where('type','2')->where('status', 0)->count();
        $data['active_users'] = User::where('type','2')->where('status', 1)->count();
        
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function add_user(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:50',
            'middle_name' => 'max:50',
            'last_name' => 'max:50',
            'email' => 'required|email|max:50|unique:users',
            'phone_number' => 'max:15',
            'menu_control' => 'required',
        ],[
            'menu_control.required' => 'Choose atleast one menu control.'
        ]);
            $user = new User;
            $user->type = '2';
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->created_by = Auth::user()->id;
            $password = Str::random(10);
            $user->password = bcrypt($password);//Hash::make();
            $user->save();

            $menu_controls = isset($request->menu_control) ? $request->menu_control : [];
            if(count($menu_controls) > 0){
                foreach($menu_controls as $value){
                    $MenuControl = new MenuControl();
                    $MenuControl->user_id =  $user->id;
                    $MenuControl->menu_id =  $value;
                    $MenuControl->created_by =  Auth::user()->id;
                    $MenuControl->save();
                }
            }

            $mailData['name'] = $user->first_name;
            $mailData['email'] = $user->email;
            $mailData['password'] = $password;
            $body = view('emails.user_created', $mailData);
            $userEmailsSend[] = 'hamza@5dsolutions.ae';//$user->email;
            // to username, to email, from username, subject, body html
            sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'User Created', $body); // send_to_name, send_to_email, email_from_name, subject, body
            return response()->json(['status' => 200, 'message' => "Admin user created successfully"]);
    }

    public function delete_user(Request $request)
    {

        $user_id = $request->del_id;
        $user = User::where('id',$user_id)->where('type','2')->first();

        if(!$user){
            return response()->json(['status' => 402, 'message' => "User Not found"]);
        }
        else{
            $user->delete();
            return response()->json(['status' => 200, 'message' => "User Deleted Successfully"]);
        }
    }

    public function change_status(Request $request)
    {
        $user_id = $request->id;
        $user = User::where('id',$user_id)->first();
        if($user->status == 0){
            $user->status = 1;
            $user->updated_by = Auth::user()->id;
            $user->save();
            return response()->json(['status' => 200, 'message' => "Status Updated Successfully"]);
        }
        else{
            $user->status = 0;
            $user->save();
            $user->updated_by = Auth::user()->id;
            return response()->json(['status' => 200, 'message' => "Status Updated Successfully"]);
        }
    }

    public function get_user_data(Request $request)
    {
        $user_id = $request->id;
        $user = User::where('id', $user_id)->with(['menuControls'])->first();
        if(!$user){
            return response()->json(['status' => 402, 'message' => "User Not found"]);
        }
        else{
            return response()->json(['status' => 200, 'data' => $user]);
        }
    }

    public function update_user(Request $request)
    {
        $validatedData = $request->validate([
            'first_name_edit' => 'required|max:50',
            'middle_name_edit' => 'max:50',
            'last_name_edit' => 'max:50',
            // 'email' => 'required|email|max:50|unique:users',
            'phone_number_edit' => 'max:15',
            'menu_control' => 'required',
        ],[
            'menu_control.required' => 'Choose atleast one menu control.'
        ]);
        $user = User::where('id', $request->user_id)->first();
        $user->first_name = $request->first_name_edit;
        $user->middle_name = $request->middle_name_edit;
        $user->last_name = $request->last_name_edit;
        // $user->email = $request->email;
        $user->phone_number = $request->phone_number_edit;
        $user->updated_by = Auth::user()->id;
        $user->save();

        $menu_controls = isset($request->menu_control) ? $request->menu_control : [];
        MenuControl::where('user_id', $user->id)->delete();
        if(count($menu_controls) > 0){
            foreach($menu_controls as $value){
                $MenuControl = new MenuControl();
                $MenuControl->user_id =  $user->id;
                $MenuControl->menu_id =  $value;
                $MenuControl->updated_by =  Auth::user()->id;
                $MenuControl->save();
            }
        }

        return response()->json(['status' => 200, 'message' => "User Updated Successfully"]);
    }

    public function get_landlord_data()
    {
        $data['landlord_list'] = LandlordPersonal::with(['propertyDetail'])->get();
        $data['total'] = LandlordPersonal::count();
        $data['total_inactive'] = LandlordPersonal::where('status', '0')->count();
        $data['total_active'] = LandlordPersonal::where('status', '1')->count();
        return response()->json(['status' => 200, 'data' => $data]);
    }



}
