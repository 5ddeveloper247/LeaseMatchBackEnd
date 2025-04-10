<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User;
use App\Models\Pricing_plan;
use App\Models\Menu;
use App\Models\MenuControl;
use App\Models\ApiSettings;
use App\Models\Notifications;
use App\Models\UserSubscription;
use App\Models\UserPayments;

// landlord models
use App\Models\Api\LandlordPersonal;
use App\Models\Api\LandlordProperty;
use App\Models\Api\LandlordRental;
use App\Models\Api\LandlordTenant;
use App\Models\Api\LandlordAdditional;
use App\Models\Api\LandlordPropertyImages;
// tenant user models
use App\Models\Api\UserPersonalInfo;
use App\Models\Api\ResidentialPreference;
use App\Models\Api\FinancialInfo;
use App\Models\Api\RentalAssistance;
use App\Models\Api\LivingSituation;
use App\Models\Api\HouseholdInfo;
use App\Models\Api\PetInformation;
use App\Models\Api\AccommodationRequirements;
use App\Models\Api\AdditionalInfo;
use App\Models\Api\LegalCompliance;
use App\Models\Api\UserReferences;
use App\Models\Api\AdditionalNotes;
use App\Models\Api\UserDocuments;

use App\Models\Api\ContactUs;
use App\Models\EnquiryHeader;
use App\Models\RequiredDocuments;
use App\Models\PropertyMatches;
use App\Models\TenantEnquiryHeader;
use App\Models\TenantEnquiryRequests;
use App\Models\TenantEnquiryDocument;
use App\Models\Testimonial;

use App\Models\Inquiry;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // Use dependency injection to bring in the PaymentEncode class
    public function __construct() {}

    public function get_dashboard_page_data(Request $request)
    {

        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subDays(14);

        $period = CarbonPeriod::create($startDate, $endDate);

        $last30Days = [];
        $chart_payments = [];
        foreach ($period as $date) {
            $last30Days[] = $date->format('d M');
            $chart_payments[] = UserPayments::where('date', $date->format('Y-m-d'))->sum('amount');
            $chart_properties[] = LandlordPersonal::whereDate('created_at', $date->format('Y-m-d'))->count();
        }
        $data['chart_days'] = (object) $last30Days;
        $data['chart_payments'] = (object) $chart_payments;
        $data['chart_properties'] = (object) $chart_properties;

        return response()->json(['status' => 200, 'message' => '', 'data' => $data]);
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
            if ($user->status == 1) {
                $request->session()->put('user', $user);
                // Authentication passed...
                return redirect()->intended('/admin/dashboard');
            } else {
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

        $data['total_admins'] = User::where('type', '2')->count();
        $data['total_landlords'] = LandlordPersonal::count();
        $data['total_tenants'] = User::where('type', '3')->count();
        $data['total_active_sub'] = UserSubscription::where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->distinct('user_id')->count('user_id');
        $data['total_payment'] = UserPayments::sum('amount');

        $data['total_landlord_active'] = LandlordPersonal::where('status', '1')->count();
        $data['total_landlord_inactive'] = LandlordPersonal::where('status', '0')->count();
        $data['total_landlord_available'] = LandlordPersonal::where('enquiry_status', '1')->count();
        $data['total_landlord_blocked'] = LandlordPersonal::where('enquiry_status', '2')->count();
        $data['total_landlord_booked'] = LandlordPersonal::where('enquiry_status', '3')->count();

        $data['total_tenant_active'] = User::where('type', '3')->where('status', '1')->count();
        $data['total_tenant_inactive'] = User::where('type', '3')->where('status', '0')->count();
        $data['total_request_waiting'] = TenantEnquiryHeader::whereIn('status', ['9'])->count();
        $data['total_request_inprocess'] = TenantEnquiryHeader::whereIn('status', ['1', '2', '3', '4', '5', '7'])->count();
        $data['total_request_approved'] = TenantEnquiryHeader::whereIn('status', ['6'])->count();

        $data['total_assigned_properties'] = LandlordPersonal::whereIn('id', function ($query) {
            $query->select('landlord_id')
                ->from('property_matches');
        })->count();

        $data['total_unassigned_properties'] = LandlordPersonal::whereNotIn('id', function ($query) {
            $query->select('landlord_id')
                ->from('property_matches');
        })->count();

        return view('admin/dashboard')->with($data);
    }

    public function subscription(Request $request)
    {
        $data['page'] = 'Subscriptions';
        $data['plans'] = Pricing_plan::get();
        return view('admin/subscriptions')->with($data);
    }

    public function adminUser(Request $request)
    {
        $data['page'] = 'Admin Users';
        return view('admin/admin_users')->with($data);
    }

    public function landlord(Request $request)
    {
        $data['page'] = 'Landlord';
        return view('admin/landlord')->with($data);
    }

    public function tenant(Request $request)
    {
        $data['page'] = 'Tenant';
        return view('admin/tenant')->with($data);
    }

    public function apiSettings(Request $request)
    {
        $data['page'] = 'API Settings';
        $data['apiSettings'] = ApiSettings::first();
        return view('admin/api_settings')->with($data);
    }

    public function userPayments(Request $request)
    {
        $data['page'] = 'User Payments';
        return view('admin/user_payments')->with($data);
    }

    public function userSubscriptions(Request $request)
    {
        $data['page'] = 'User Subscriptions';
        return view('admin/user_subscriptions')->with($data);
    }

    public function contactUs(Request $request)
    {
        $data['page'] = 'Contact Us';
        return view('admin/contact_us')->with($data);
    }

    public function my_account()
    {
        $data['page'] = 'My Account';
        return view('admin/my_account')->with($data);
    }

    public function propertyMatches()
    {
        $data['page'] = 'Property Matches';
        return view('admin/user_property_matches')->with($data);
    }

    public function enquiry_requests()
    {
        $data['page'] = 'Enquiry Requests';
        return view('admin/enquiry_requests')->with($data);
    }

    public function commercial_enquiry()
    {
        $data['page'] = 'Commercial Enquiry';
        return view('admin/commercial_enquiry')->with($data);
    }



    // public function enquiryProcess(){
    //     $data['page'] = 'Enquiry Process';
    //     return view('admin/enquiry_process')->with($data);
    // }





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
        if (!isset($plan->id)) {
            $plan = new Pricing_plan();
            $plan->id = $request->plan_id;
        }

        $plan->title = $request->package_title;
        $plan->initial_price = $request->initial_price;
        $plan->monthly_price = $request->monthly_price;
        $plan->number_of_matches = $request->number_matches;

        if (isset($request->tenant_directly_contact) && $request->tenant_directly_contact == 'on') {
            $plan->directly_contact_flag = 1;
        } else {
            $plan->directly_contact_flag = 0;
        }

        if (isset($request->process_application) && $request->process_application == 'on') {
            $plan->process_application_flag = 1;
        } else {
            $plan->process_application_flag = 0;
        }

        if (isset($request->necessary_document) && $request->necessary_document == 'on') {
            $plan->necessary_doc_flag = 1;
        } else {
            $plan->necessary_doc_flag = 0;
        }
        if (isset($request->freeTrial) && $request->freeTrial == 'on') {
            $plan->free_trial = 1;
        } else {
            $plan->free_trial = 0;
        }

        $plan->created_at = date('Y-m-d H:i:s');
        // Save the changes
        $plan->save();

        //Handle Registeration Payment
        return response()->json(['status' => 200, 'message' => "Plan updated successfully!"]);
    }

    public function get_admin_users_list(Request $request)
    {
        $data['admin_list'] = User::where('type', '2')->get();
        $data['inactive_users'] = User::where('type', '2')->where('status', 0)->count();
        $data['active_users'] = User::where('type', '2')->where('status', 1)->count();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function add_user(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:50',
            'middle_name' => 'max:50',
            'last_name' => 'max:50',
            'email' => 'required|email|max:50|unique:users',
            'phone_number' => 'required|numeric|digits_between:7,18',
            'menu_control' => 'required',
            'profile' => 'nullable|mimes:jpeg,jpg,png,jfif,avif'
        ], [
            'menu_control.required' => 'Choose atleast one menu control.'
        ]);

        $savedFilePaths = '';
        $req_file = 'profile';
        $path = '/uploads/user/profile';

        if ($request->hasFile($req_file)) { 
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0777, true);
            }

            $uploadedFile = $request->file($req_file); 
            $file_extension = $uploadedFile->getClientOriginalExtension(); 
            $date_append = Str::random(32);
            $uploadedFile->move(public_path($path), $date_append . '.' . $file_extension); 

            $savedFilePaths = '/uploads/user/profile/' . $date_append . '.' . $file_extension; 
        }

        //Log::info('File saved path: ' . $savedFilePaths); // More informative log


        $user = new User;
        $user->type = '2';
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->status = 0;
        $user->profile_picture = $savedFilePaths;
        $user->created_by = Auth::user()->id;
        $password = Str::random(10);
        $user->password = bcrypt($password); //Hash::make();
        $user->save();

        $menu_controls = isset($request->menu_control) ? $request->menu_control : [];
        if (count($menu_controls) > 0) {
            foreach ($menu_controls as $value) {
                $MenuControl = new MenuControl();
                $MenuControl->user_id =  $user->id;
                $MenuControl->menu_id =  $value;
                $MenuControl->created_by =  Auth::user()->id;
                $MenuControl->save();
            }
        }

        $Notification = new Notifications();
        $Notification->module_code =  'SUB-ADMIN REGISTER';
        $Notification->from_user_id =  Auth::user()->id;
        $Notification->to_user_id =  $user->id;
        $Notification->subject =  "Welcome to LEASE MATCH!";
        $Notification->message =  "We're excited to have you on board.";
        $Notification->read_flag =  '0';
        $Notification->created_by =  Auth::user()->id;
        $Notification->save();

        $mailData['name'] = $user->first_name . " " . $user->last_name;
        $mailData['email'] = $user->email;
        $mailData['password'] = $password;
        $body = view('emails.admin_user_created', $mailData);
        $userEmailsSend[] = $user->email; //'hamza@5dsolutions.ae';//
        // to username, to email, from username, subject, body html
        sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'Admin User Created', $body);
        return response()->json(['status' => 200, 'message' => "Admin user created successfully"]);
    }

    public function delete_user(Request $request)
    {
        $user_id = $request->del_id;
        $user = User::where('id', $user_id)->where('type', '2')->first();

        if (!$user) {
            return response()->json(['status' => 402, 'message' => "User Not found"]);
        } else {
            $user->delete();

            $mailData['name'] = $user->first_name . " " . $user->last_name;
            $mailData['email'] = $user->email;
            $mailData['phone_number'] = $user->phone_number;
            $body = view('emails.admin_user_deleted', $mailData);
            $userEmailsSend[] = env('MAIL_ADMIN');
            // to username, to email, from username, subject, body html
            sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'Admin User Deleted', $body);

            return response()->json(['status' => 200, 'message' => "User Deleted Successfully"]);
        }
    }

    public function change_status(Request $request)
    {
        $user_id = $request->id;
        $user = User::where('id', $user_id)->first();
        if ($user->status == 0) {
            $user->status = 1;
            $user->updated_by = Auth::user()->id;
            $user->save();

            $Notification = new Notifications();
            $Notification->module_code =  'SUB-ADMIN ACTIVATION';
            $Notification->from_user_id =  Auth::user()->id;
            $Notification->to_user_id =  $user->id;
            $Notification->subject =  "Activate Sub-Admin";
            $Notification->message =  "Your account will now active, you can login your account";
            $Notification->read_flag =  '0';
            $Notification->created_by =  Auth::user()->id;
            $Notification->save();

            $mailData['name'] = $user->first_name . " " . $user->last_name;
            $mailData['email'] = $user->email;
            $mailData['phone_number'] = $user->phone_number;
            $body = view('emails.admin_user_active', $mailData);
            $userEmailsSend[] = $user->email; //'hamza@5dsolutions.ae';//
            // to username, to email, from username, subject, body html
            sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'Admin User Activated', $body);

            return response()->json(['status' => 200, 'message' => "Status Updated Successfully"]);
        } else {
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
        if (!$user) {
            return response()->json(['status' => 402, 'message' => "User Not found"]);
        } else {
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
            'phone_number_edit' => 'required|numeric|digits_between:7,18',
            'menu_control' => 'required',
        ], [
            'menu_control.required' => 'Choose atleast one menu control.'
        ]);

        $savedFilePaths = '';
        $req_file = 'profile';
        $path = '/uploads/user/profile';

        if ($request->hasFile($req_file)) { 
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0777, true);
            }

            $uploadedFile = $request->file($req_file); 
            $file_extension = $uploadedFile->getClientOriginalExtension(); 
            $date_append = Str::random(32);
            $uploadedFile->move(public_path($path), $date_append . '.' . $file_extension); 

            $savedFilePaths = '/uploads/user/profile/' . $date_append . '.' . $file_extension; 
        }

        $user = User::where('id', $request->user_id)->first();
        $user->first_name = $request->first_name_edit;
        $user->middle_name = $request->middle_name_edit;
        $user->last_name = $request->last_name_edit;
        // $user->email = $request->email;
        $user->profile_picture = $savedFilePaths;
        $user->phone_number = $request->phone_number_edit;
        $user->updated_by = Auth::user()->id;
        $user->save();

        $menu_controls = isset($request->menu_control) ? $request->menu_control : [];
        MenuControl::where('user_id', $user->id)->delete();
        if (count($menu_controls) > 0) {
            foreach ($menu_controls as $value) {
                $MenuControl = new MenuControl();
                $MenuControl->user_id =  $user->id;
                $MenuControl->menu_id =  $value;
                $MenuControl->updated_by =  Auth::user()->id;
                $MenuControl->save();
            }
        }

        return response()->json(['status' => 200, 'message' => "User Updated Successfully"]);
    }

    public function get_landlord_data(Request $request)
    {
        $data['landlord_list'] = LandlordPersonal::with(['propertyDetail', 'rentalDetail'])->get();
        $data['total'] = LandlordPersonal::count();
        $data['total_inactive'] = LandlordPersonal::where('status', '0')->count();
        $data['total_active'] = LandlordPersonal::where('status', '1')->count();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function search_landlord_listing(Request $request)
    {
        $fullname = $request->search_fullname;
        $company_name = $request->search_companyName;
        $prop_type = $request->search_propType;
        $num_bedrooms = $request->search_numBedrooms;
        $rental_type = $request->search_rentalType;
        $renewal_option = $request->search_renewalOption;
        $status = $request->search_status;
        // check atleast one filter check
        if (
            is_null($fullname) && is_null($company_name) && is_null($prop_type) && is_null($num_bedrooms) &&
            is_null($rental_type) && is_null($renewal_option) && is_null($status)
        ) {
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        // // make query for get listing
        $query = LandlordPersonal::with(['propertyDetail', 'rentalDetail']);

        if (!is_null($fullname)) {
            $query->where('full_name', 'like', '%' . $fullname . '%');
        }

        if (!is_null($company_name)) {
            $query->where('company_name', 'like', '%' . $company_name . '%');
        }
        if (!is_null($status)) {
            $query->where('status', $status);
        }

        if (!is_null($num_bedrooms)) {
            $query->whereHas('rentalDetail', function ($subQuery) use ($num_bedrooms) {
                $subQuery->where('number_of_bedrooms', $num_bedrooms);
            });
        }

        if (!is_null($prop_type)) {
            $query->whereHas('propertyDetail', function ($subQuery) use ($prop_type) {
                $subQuery->where('property_type', 'like', '%' . $prop_type . '%');
            });
        }

        if (!is_null($rental_type)) {
            $query->whereHas('rentalDetail', function ($subQuery) use ($rental_type) {
                $subQuery->where('rental_type', $rental_type);
            });
        }

        if (!is_null($renewal_option)) {
            $query->whereHas('rentalDetail', function ($subQuery) use ($renewal_option) {
                $subQuery->where('renwal_option', $renewal_option);
            });
        }

        // Execute the query and get the results
        $data['landlord_list'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }
    public function change_status_landlord(Request $request)
    {
        $landlord_id = $request->id;
        $landlord = LandlordPersonal::where('id', $landlord_id)->with(['propertyDetail'])->first();

        if ($landlord->status == 0) {
            $landlord->status = 1;
        } else {
            $landlord->status = 0;
        }

        $landlord->updated_by = Auth::user()->id;
        $landlord->save();

        if ($landlord->status == 1) { // if user is active then send mail

            $mailData['name'] = $landlord->full_name;
            $mailData['email'] = $landlord->email;
            $mailData['phone_number'] = $landlord->phone_number;
            $mailData['property_type'] = $landlord->propertyDetail->property_type;

            $body = view('emails.landlord_active', $mailData);
            $userEmailsSend[] = $landlord->email; //'hamza@5dsolutions.ae';//
            // to username, to email, from username, subject, body html
            sendMail($landlord->full_name, $userEmailsSend, 'LEASE MATCH', 'Landlord Activated', $body);
        }

        return response()->json(['status' => 200, 'message' => "Status Updated Successfully!"]);
    }

    public function get_specific_landlord(Request $request)
    {
        $landlord_id = $request->id;
        $data['details'] = LandlordPersonal::where('id', $landlord_id)
            ->with([
                'propertyDetail',
                'rentalDetail',
                'tenantDetail',
                'additionalDetail',
                'propertyImages'
            ])
            ->first();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function delete_landlord(Request $request)
    {
        $landlord_id = $request->id;
        $checkInProperyMatches = PropertyMatches::where('landlord_id', $landlord_id)->first();
        if ($checkInProperyMatches) {
            return response()->json(['status' => 402, 'message' => 'Cannot delete this landlord as it is linked with property match.']);
        }

        $landlord = LandlordPersonal::where('id', $landlord_id)->with(['propertyDetail'])->first();
        $images = LandlordPropertyImages::where('landlord_id', $landlord_id)->get();

        LandlordPersonal::where('id', $landlord_id)->delete();
        LandlordProperty::where('landlord_id', $landlord_id)->delete();
        LandlordRental::where('landlord_id', $landlord_id)->delete();
        LandlordTenant::where('landlord_id', $landlord_id)->delete();
        LandlordAdditional::where('landlord_id', $landlord_id)->delete();
        LandlordPropertyImages::where('landlord_id', $landlord_id)->delete();

        if ($images != null) {
            foreach ($images as $image) {
                deleteImage(str_replace('/public', "", $image->path));
            }
        }

        $mailData['name'] = $landlord->full_name;
        $mailData['email'] = $landlord->email;
        $mailData['phone_number'] = $landlord->phone_number;
        $mailData['property_type'] = $landlord->propertyDetail->property_type;

        $body = view('emails.landlord_deleted', $mailData);
        $userEmailsSend[] = env('MAIL_ADMIN');
        // to username, to email, from username, subject, body html
        sendMail($landlord->full_name, $userEmailsSend, 'LEASE MATCH', 'Landlord Deleted', $body);

        return response()->json(['status' => 200, 'message' => "Deleted Successfully!"]);
    }

    public function get_tenant_data(Request $request)
    {
        $data['tenant_list'] = User::where('type', 3)->with(['personalInfo'])->get();
        $data['total'] = User::where('type', 3)->count();
        $data['total_inactive'] = User::where('type', 3)->where('status', '0')->count();
        $data['total_active'] = User::where('type', 3)->where('status', '1')->count();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function search_tenant_listing(Request $request)
    {
        $username = $request->search_username;
        $phone_number = $request->search_phonenumber;
        $num_bedrooms = $request->search_minBedrooms;
        $prop_type = $request->search_propType;
        $borough_location = $request->search_boroughLocation;
        $status = $request->search_status;

        // check atleast one filter check
        if (is_null($username) && is_null($phone_number) && is_null($num_bedrooms) && is_null($prop_type) && is_null($borough_location) && is_null($status)) {
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        // // make query for get listing
        $query = User::where('type', 3)->with(['personalInfo', 'residentialInfo']);

        if (!is_null($username)) {
            $query->where('first_name', 'like', '%' . $username . '%');
        }

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        if (!is_null($phone_number)) {
            $query->whereHas('personalInfo', function ($subQuery) use ($phone_number) {
                $subQuery->where('phone_number', 'like', '%' . $phone_number . '%');
            });
        }

        if (!is_null($prop_type)) {
            $query->whereHas('residentialInfo', function ($subQuery) use ($prop_type) {
                $subQuery->where('preferred_property_type', $prop_type);
            });
        }
        if (!is_null($num_bedrooms)) {
            $query->whereHas('residentialInfo', function ($subQuery) use ($num_bedrooms) {
                $subQuery->where('min_bedrooms_needed', $num_bedrooms);
            });
        }
        if (!is_null($borough_location)) {
            $query->whereHas('residentialInfo', function ($subQuery) use ($borough_location) {
                $subQuery->where('preferred_location', $borough_location);
            });
        }

        // Execute the query and get the results
        $data['tenant_list'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function change_status_tenant(Request $request)
    {
        $user_id = $request->id;
        $user = User::where('id', $user_id)->where('type', 3)->first();
        $userInfo = UserPersonalInfo::where('user_id', $user_id)->first();
        if ($user) {
            if ($user->status == 0) {
                $user->status = 1;
            } else {
                $user->status = 0;
            }

            $user->updated_by = Auth::user()->id;
            $user->save();

            if ($user->status == 1) { // if user is active then send mail

                $Notification = new Notifications();
                $Notification->module_code =  'TENANT ACTIVATION';
                $Notification->from_user_id =  Auth::user()->id;
                $Notification->to_user_id =  $user->id;
                $Notification->subject =  "Activate Tenant";
                $Notification->message =  "Your account will now active, you can login your account.";
                $Notification->read_flag =  '0';
                $Notification->created_by =  $user->id;
                $Notification->save();

                $mailData['name'] = $user->first_name . " " . $user->last_name;
                $mailData['email'] = $user->email;
                $mailData['phone_number'] = $userInfo->phone_number ?? $user->phone_number ?? 'N/A';
                $body = view('emails.tenant_active', $mailData);
                $userEmailsSend[] = $user->email; //'hamza@5dsolutions.ae';//
                // to username, to email, from username, subject, body html
                sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'User Activated', $body); // send_to_name, send_to_email, email_from_name, subject, body

            }
            return response()->json(['status' => 200, 'message' => "Status Updated Successfully!"]);
        } else {
            return response()->json(['status' => 402, 'message' => "Something went wrong!"]);
        }
    }

    public function delete_tenant(Request $request)
    {
        $user_id = $request->id;
        

        $checkInPropertyMatches = PropertyMatches::where('user_id', $user_id)->first();
        if ($checkInPropertyMatches) {
            return response()->json(['status' => 402, 'message' => 'Cannot delete this tenant as it is linked with property match.']);
        }
    
        $docs = UserDocuments::where('id', $user_id)->get();

        $user = User::where('id', $user_id)->where('type', 3)->first();

        User::where('id', $user_id)->where('type', 3)->delete();
        UserPersonalInfo::where('user_id', $user_id)->delete();
        ResidentialPreference::where('user_id', $user_id)->delete();
        FinancialInfo::where('user_id', $user_id)->delete();
        RentalAssistance::where('user_id', $user_id)->delete();
        LivingSituation::where('user_id', $user_id)->delete();
        HouseholdInfo::where('user_id', $user_id)->delete();
        PetInformation::where('user_id', $user_id)->delete();
        AccommodationRequirements::where('user_id', $user_id)->delete();
        AdditionalInfo::where('user_id', $user_id)->delete();
        LegalCompliance::where('user_id', $user_id)->delete();
        UserReferences::where('user_id', $user_id)->delete();
        AdditionalNotes::where('user_id', $user_id)->delete();
        UserDocuments::where('user_id', $user_id)->delete();

        if ($docs != null) {
            foreach ($docs as $doc) {
                deleteImage(str_replace('/public', "", $doc->doc_url));
            }
        }

        $mailData['name'] = $user->first_name . " " . $user->last_name;
        $mailData['email'] = $user->email;
        $mailData['phone_number'] = $user->phone_number;
        $body = view('emails.tenant_deleted', $mailData);
        $userEmailsSend[] = env('MAIL_ADMIN');
        // to username, to email, from username, subject, body html
        sendMail($user->first_name, $userEmailsSend, 'LEASE MATCH', 'User Deleted', $body); // send_to_name, send_to_email, email_from_name, subject, body

        return response()->json(['status' => 200, 'message' => "Deleted Successfully!"]);
    }

    public function get_specific_tenant(Request $request)
    {
        $tenant_id = $request->id;
        $data['details'] = User::where('id', $tenant_id)->where('type', 3)
            ->with([
                'personalInfo',
                'residentialInfo',
                'financialInfo',
                'rentalInfo',
                'livingInfo',
                'householdInfo',
                'petInfo',
                'accomodationInfo',
                'additionalInfo',
                'legalInfo',
                'references',
                'additionalNote',
                'userDocs'
            ])
            ->first();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function save_api_settings(Request $request)
    {
        $validatedData = $request->validate([
            'secret_key' => 'required|max:255',
            'publishable_key' => 'required|max:255',
        ]);

        $apiSettings = ApiSettings::first();
        if (!isset($apiSettings->id)) {
            $apiSettings = new ApiSettings();
        }

        $apiSettings->secret_key = $request->secret_key;
        $apiSettings->publishable_key = $request->publishable_key;
        $apiSettings->status = '1';
        if (isset($apiSettings->id)) {
            $apiSettings->updated_by = Auth::user()->id;
        } else {
            $apiSettings->created_by = Auth::user()->id;
        }
        // Save the changes
        $apiSettings->save();

        //Handle Registeration Payment
        return response()->json(['status' => 200, 'message' => "Settings added successfully!"]);
    }

    public function get_payment_data(Request $request)
    {
        $data['payment_user_list'] = User::where('type', 3)
            ->withCount(['userPayments'])
            ->with(['personalInfo'])
            ->having('user_payments_count', '>', 0) 
            ->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_payment_list_user(Request $request)
    {
        $user_id = $request->id;

        $data['detail'] = User::where('id', $user_id)->where('type', 3)->with(['userPayments', 'personalInfo', 'userPayments.plan'])->first();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_subscriptions_data(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $data['subscriptions_user_list'] = User::where('type', 3)
            
            ->withCount(['userSubscriptions' => function ($query) {
                $query->where('status', 'active');
            }])
            ->with(['personalInfo', 'activePlan.plan', 'activePlan' => function ($query) use ($currentDate) {
                $query->where('start_date', '<=', $currentDate)
                    ->where('end_date', '>=', $currentDate);
            }])
            ->having('user_subscriptions_count', '>', 0) 
            ->get();


        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_subscriptions_list_user(Request $request)
    {
        $user_id = $request->id;

        $data['detail'] = User::where('id', $user_id)->where('type', 3)->with(['userSubscriptions', 'personalInfo', 'userSubscriptions.plan'])->first();

        return response()->json(['status' => 200, 'data' => $data]);
    }


    public function get_contactus_page_data(Request $request)
    {
        $data['contactus_list'] = ContactUs::with(['replied_by'])->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_specific_contactus_detail(Request $request)
    {
        $contact_id = $request->id;

        $data['detail'] = ContactUs::where('id', $contact_id)->first();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function save_contact_reply(Request $request)
    {
        $validatedData = $request->validate([
            'contact_id' => 'required',
            'reply_message' => 'required',
        ]);

        $contact = ContactUs::find($request->contact_id);
        if (isset($contact->id)) {

            $contact->reply = $request->reply_message;
            $contact->replied_by = Auth::user()->id;
            // Save the changes
            $contact->save();

            $contact_detail = ContactUs::find($request->contact_id);
            $body = view('emails.contact_us_reply', $contact_detail);
            $userEmailsSend[] = $contact_detail->email; //'hamza@5dsolutions.ae';//
            // to username, to email, from username, subject, body html
            sendMail($contact_detail->name, $userEmailsSend, 'LEASE MATCH', 'Contact Us', $body); // send_to_name, send_to_email, email_from_name, subject, body

            return response()->json(['status' => 200, 'message' => "Plan updated successfully!"]);
        } else {
            return response()->json(['status' => 402, 'message' => "Something went wrong!"]);
        }
    }


    public function get_profile_data(Request $request)
    {
        $user_id = Auth::id();
        $data['details'] = User::where('id', $user_id)->whereIn('type', ['1', '2'])
            ->with(['personalInfo'])
            ->first();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function update_profile(Request $request)
    {

        $user_id = Auth::id();
        $user = User::find($user_id);
        $request->validate([
            'first_name' => 'required|max:50',
            'phone_number' => 'required|numeric|digits_between:7,18',
        ]);
        if ($request->password) {
            $request->validate([
                'first_name' => 'required|max:50',
                'phone_number' => 'required|numeric|digits_between:7,18',
                'old_password' => 'required',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                    'confirmed',
                ],
            ], [
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
            } else {
                return response()->json(['status' => 402, 'message' => "Old password is incorrect"]);
            }
        } else {
            $user->first_name = $request->first_name;
            $user->phone_number = $request->phone_number;
            $user->save();
            return response()->json(['status' => 200, 'message' => 'Profile Updated Successfully']);
        }
    }

    public function enquiry_page_data(Request $request)
    {

        // $data['listing'] = EnquiryProcess::with(['user','landlord','landlord.propertyDetail'])->get();

        // return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_matches_data(Request $request)
    {
        $data['user_list'] = User::where('type', 3)->where('status', 1)->withCount(['userMatches'])
            ->with(['personalInfo', 'activePlan.plan'])->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function required_documents()
    {
        $data['page'] = 'Required Documents';
        return view('admin/required_documents')->with($data);
    }

    public function required_documentsPageData()
    {
        $data['list'] = RequiredDocuments::all();
        $data['active'] = RequiredDocuments::where('status', 1)->count();
        $data['inactive'] = RequiredDocuments::where('status', 0)->count();
        $data['total'] = RequiredDocuments::count();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function add_new_required_document(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
        ]);
        $document = new RequiredDocuments;
        $document->name = $request->name;
        $document->description = $request->description;
        $document->status = '1';
        $document->created_by = Auth::id();
        $document->save();
        return response()->json(['status' => 200, 'message' => 'Document Added Successfully']);
    }

    public function changeRequiredDocumentStatus(Request $request)
    {
        $document_id  = $request->id;
        $document = RequiredDocuments::find($document_id);
        if ($document->status == 1  || $document->status == '1') {
            $document->status = 0;
        } else {
            $document->status = 1;
        }
        $document->save();
        return response()->json(['status' => 200, 'message' => 'Document Status Updated Successfully']);
    }

    public function deleteRequiredDocument(Request $request)
    {
        $document_id  = $request->id;
        $document = RequiredDocuments::find($document_id);
        if ($document) {
            $document->delete();
            return response()->json(['status' => 200, 'message' => 'Document Deleted Successfully']);
        } else {
            return response()->json(['status' => 402, 'message' => 'Document Not found']);
        }
    }

    public function getRequiredDocumentDetails(Request $request)
    {
        $document_id  = $request->id;
        $document = RequiredDocuments::find($document_id);
        if ($document) {
            return response()->json(['status' => 200, 'data' => $document]);
        } else {
            return response()->json(['status' => 402, 'message' => 'Document Not found']);
        }
    }

    public function updateRequiredDocument(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name_edit' => 'required|max:50',
                'description_edit' => 'required',
            ],
            [
                'name_edit.required' => 'Document name is required',
                'name_edit.max' => 'Document name can not be more than 50 charatcers',
                'description_edit.required' => 'Description is required'
            ]
        );
        $document_id  = $request->document_id_edit;
        $document = RequiredDocuments::find($document_id);
        if ($document) {
            $document->name = $request->name_edit;
            $document->description = $request->description_edit;
            $document->save();
            return response()->json(['status' => 200, 'message' => 'Document Updated Successfully']);
        } else {
            return response()->json(['status' => 402, 'message' => 'Document Not found']);
        }
    }

    

    public function get_matches_list_user(Request $request)
    {
        $user_id = $request->id;
        $data = [];
        // Fetch user details
        $user_detail = User::where('id', $user_id)
            ->where('type', 3)
            ->with(['personalInfo', 'residentialInfo', 'householdInfo', 'activePlan.plan'])
            ->first();

        // Check if user details exist
        if (!$user_detail) {
            $data = [];
            return response()->json(['status' => 404, 'message' => 'User not found.', 'data' => $data]);
        }

        // Set default values in case any field is missing
        $data['user_detail'] = $user_detail;
        $propertyAssignMatchLimit = isset($user_detail->activePlan->plan->number_of_matches)
            ? $user_detail->activePlan->plan->number_of_matches
            : 0;

        $preferredPropertyType = isset($user_detail->residentialInfo->preferred_property_type)
            ? $user_detail->residentialInfo->preferred_property_type
            : null;

        $prefferedHouseholdSize = isset($user_detail->householdInfo->household_size)
            ? $user_detail->householdInfo->household_size
            : null;

        $prefferedBedroomNeeded = isset($user_detail->residentialInfo->min_bedrooms_needed)
            ? $user_detail->residentialInfo->min_bedrooms_needed
            : null;

        $prefferedBathroomNeeded = isset($user_detail->residentialInfo->min_bathrooms_needed)
            ? $user_detail->residentialInfo->min_bathrooms_needed
            : null;

        // If any of the essential data is missing, return a warning message
        if (is_null($preferredPropertyType) || is_null($prefferedHouseholdSize) || is_null($prefferedBedroomNeeded) || is_null($prefferedBathroomNeeded)) {
            return response()->json(['status' => 404, 'message' => 'Incomplete user data for matching.', 'data' => $data]);
        }

        // Fetch assigned matches
        $data['assigned_match_listing'] = PropertyMatches::where('user_id', $user_id)
            ->with(['landlordPersonal', 'landlordPersonal.propertyDetail', 'landlordPersonal.rentalDetail'])
            ->get();

        // Fetch available landlord listings that match the preferences and are not already matched
        $data['landlord_listing'] = LandlordPersonal::where('status', '1')
            ->where('enquiry_status', '1')
            ->with(['propertyDetail', 'rentalDetail'])
            ->whereHas('propertyDetail', function ($query) use ($preferredPropertyType) {
                $query->where('property_type', $preferredPropertyType);
            })
            ->whereNotExists(function ($query) use ($user_id) {
                $query->select(DB::raw(1))
                    ->from('property_matches') // Reference to the PropertyMatches model's table
                    ->whereRaw('property_matches.landlord_id = landlord_personal.id') // Check landlord match
                    ->where('property_matches.user_id', $user_id); // Check if user is already matched
            })
            ->whereHas('rentalDetail', function ($query) use ($prefferedBedroomNeeded, $prefferedBathroomNeeded, $prefferedHouseholdSize) {
                $query->where('size_square_feet', '>=', $prefferedHouseholdSize)
                    ->where('number_of_bedrooms', '>=', $prefferedBedroomNeeded)
                    ->where('number_of_bathrooms', '>=', $prefferedBathroomNeeded);
            })
            ->limit(10)
            ->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }




    public function assign_landlord_user(Request $request)
    {

        $landlord_id = $request->id;
        $user_id = $request->user_id;

        $existMatch = PropertyMatches::where('user_id', $user_id)->where('landlord_id', $landlord_id)->first();

        if ($existMatch != null) {
            return response()->json(['status' => 402, 'message' => 'Already added in match list!']);
        }

        $propertyMatch = new PropertyMatches();
        $propertyMatch->user_id = $user_id;
        $propertyMatch->landlord_id = $landlord_id;
        $propertyMatch->date = Carbon::now()->format('Y-m-d');
        $propertyMatch->created_by = Auth::user()->id;
        $propertyMatch->save();

        $data['assigned_match_listing'] = PropertyMatches::where('user_id', $user_id)->with(['landlordPersonal', 'landlordPersonal.propertyDetail', 'landlordPersonal.rentalDetail'])->get();

        return response()->json(['status' => 200, 'message' => 'Added successfully!', 'data' => $data]);
    }

    

    public function search_landlord_assign_listing(Request $request)
    {
        $user_id = $request->user_id;
        $landlord_username = $request->landlord_username;
        $landlord_email = $request->landlord_email;
        $property_type = $request->property_type;
        $rental_type = $request->rental_type;

        if (is_null($landlord_username) && is_null($landlord_email) && is_null($property_type) && is_null($rental_type)) {
            return response()->json(['status' => 402, 'message' => 'Choose at least one filter first!']);
        }

        $query = LandlordPersonal::where('status', '1')
            ->where('enquiry_status', '1')
            ->with(['propertyDetail', 'rentalDetail']);

        if (!is_null($landlord_username)) {
            $query->where('full_name', 'like', '%' . $landlord_username . '%');
        }

        if (!is_null($landlord_email)) {
            $query->where('email', 'like', '%' . $landlord_email . '%');
        }

        if (!is_null($property_type)) {
            $query->whereHas('propertyDetail', function ($subQuery) use ($property_type) {
                $subQuery->where('property_type', $property_type);
            });
        }

        if (!is_null($rental_type)) {
            $query->whereHas('rentalDetail', function ($subQuery) use ($rental_type) {
                $subQuery->where('rental_type', $rental_type);
            });
        }

        // Use whereNotExists to exclude already matched landlords
        $query->whereNotExists(function ($subQuery) use ($user_id) {
            $subQuery->select(DB::raw(1))
                ->from('property_matches')
                ->whereRaw('property_matches.landlord_id = landlord_personal.id')
                ->where('property_matches.user_id', $user_id);
        });

        $data['landlord_listing'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function remove_assigned_property_user(Request $request)
    {

        $user_id = $request->user_id;
        $property_match_id = $request->property_match_id;
        $match_landlord_id = $request->match_landlord_id;

        $checkExist = TenantEnquiryHeader::where('user_id', $user_id)->where('landlord_id', $match_landlord_id)->first();
        // check atleast one filter check
        if (!is_null($checkExist)) {
            return response()->json(['status' => 402, 'message' => 'Unable to remove, request already in process!']);
        }

        $delete = PropertyMatches::where('id', $property_match_id)->delete();
        $data['assigned_match_listing'] = PropertyMatches::where('user_id', $user_id)->with(['landlordPersonal', 'landlordPersonal.propertyDetail', 'landlordPersonal.rentalDetail'])->get();

        return response()->json(['status' => 200, 'message' => 'Removed successfully!', 'data' => $data]);
    }

    public function get_enquiries_data(Request $request)
    {

        $data['enquiries'] = TenantEnquiryHeader::where('status', '!=', TenantEnquiryHeader::WAITING)->with(['user', 'enquiryRequests', 'landlord', 'landlord.propertyDetail', 'landlord.rentalDetail'])->get();
        $data['waiting_enquiries'] = TenantEnquiryHeader::where('status', '=', TenantEnquiryHeader::WAITING)->with(['user', 'enquiryRequests', 'landlord', 'landlord.propertyDetail', 'landlord.rentalDetail'])->get();

        return response()->json(['status' => 200, 'message' => '', 'data' => $data]);
    }

    public function search_enquiry_listing(Request $request)
    {

        $app_request = $request->search_appRequest;
        $prop_type = $request->search_propType;
        $date = $request->search_date;
        $status = $request->search_status;

        // check atleast one filter check
        if (is_null($app_request) && is_null($prop_type) && is_null($date) && is_null($status)) {
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        $query = TenantEnquiryHeader::where('status', '!=', TenantEnquiryHeader::WAITING)->with(['user', 'enquiryRequests', 'landlord', 'landlord.propertyDetail', 'landlord.rentalDetail']);

        if (!is_null($app_request)) {
            $query->whereHas('enquiryRequests', function ($subQuery) use ($app_request) {
                $subQuery->where('type', $app_request);
            });
        }

        if (!is_null($date)) {
            $query->where('date', $date);
        }

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        if (!is_null($prop_type)) {
            $query->whereHas('landlord.propertyDetail', function ($subQuery) use ($prop_type) {
                $subQuery->where('property_type', $prop_type);
            });
        }

        // Execute the query and get the results
        $data['enquiries'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_specific_enquiry(Request $request)
    {
        $enquiry_id = $request->id;
        $data['enquiry_detail'] = TenantEnquiryHeader::where('id', $enquiry_id)->with([
            'user',
            'user.personalInfo',
            'user.residentialInfo',
            'enquiryRequests',
            'landlord',
            'landlord.propertyDetail',
            'landlord.rentalDetail',
            'landlord.tenantDetail',
            'landlord.additionalDetail',
            'landlord.propertyImages'
        ])->first();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function change_enquiry_status_confirmed(Request $request)
    {

        $enquiry_id = $request->id;

        $enquiryDetail = TenantEnquiryHeader::where('id', $enquiry_id)->with(['enquiryRequests'])->first();

        $landlord_id = $enquiryDetail->landlord_id;

        $inprocessEnquiry = TenantEnquiryHeader::where('landlord_id', $landlord_id)->where('id', '!=', $enquiry_id)->whereNotIn('status', ['8', '9'])->first();

        if ($inprocessEnquiry == null) {
            $process_type = isset($enquiryDetail->enquiryRequests[0]->type) ? $enquiryDetail->enquiryRequests[0]->type : '1';

            TenantEnquiryHeader::where('id', $enquiry_id)->update([
                'status' => TenantEnquiryHeader::APPLICATION_CONFIRMED,
            ]);

            // add entry for enquiry lines
            $tenantEnquiryRequest = new TenantEnquiryRequests();
            $tenantEnquiryRequest->enquiry_id = $enquiry_id;
            $tenantEnquiryRequest->type = $process_type;
            $tenantEnquiryRequest->date = Carbon::now()->format('Y-m-d');
            $tenantEnquiryRequest->status = TenantEnquiryHeader::APPLICATION_CONFIRMED;
            $tenantEnquiryRequest->message = 'Application confirmed by admin';
            $tenantEnquiryRequest->created_by = Auth::user()->id;
            $tenantEnquiryRequest->submitted_by = Auth::user()->id;
            $tenantEnquiryRequest->save();

            $enquiryDetails = TenantEnquiryHeader::where('id', $enquiry_id)->with(['user', 'landlord', 'landlord.propertyDetail'])->first();

            $Notification = new Notifications();
            $Notification->module_code =  'ENQUIRY REQUEST';
            $Notification->from_user_id =   Auth::user()->id;
            $Notification->to_user_id =  $enquiryDetails->user->id;
            $Notification->subject =  "Enquiry Process Application Confirmed";
            $Notification->message =  "Your application request is confirmed by admin. Our team will contact you shortly with further details.";
            $Notification->read_flag =  '0';
            $Notification->created_by =  Auth::user()->id;
            $Notification->save();

            $mailData['name'] = $enquiryDetails->user->first_name;
            $mailData['username'] = $enquiryDetails->user->first_name;
            $mailData['user_email'] = $enquiryDetails->user->email;
            $mailData['enquiry_type'] = $process_type == '1' ? 'Application Request' : 'Document Upload';
            $mailData['property_type'] = $enquiryDetails->landlord->propertyDetail->property_type;
            $mailData['enquiry_message'] = $tenantEnquiryRequest->message;
            $mailData['enquiry_date'] = Carbon::now()->format('d-M-Y');
            $mailData['enquiry_status'] = TenantEnquiryHeader::STATUS_LABELS[$enquiryDetails->status];
            $mailData['subject'] = 'Enquiry Process Application Confirmed';
            $mailData['email_message'] = 'Your application request is confirmed by admin. Our team will contact you shortly with further details.';

            $body = view('emails.enquiry_email', $mailData);
            $userEmailsSend[] = $enquiryDetails->user->email; //'hamza@5dsolutions.ae';//
            // to username, to email, from username, subject, body html
            sendMail($enquiryDetails->user->first_name, $userEmailsSend, 'LEASE MATCH', 'Enquiry Notification', $body);

            return response()->json(['status' => 200, 'message' => 'Application confirmed successfully!']);
        } else {

            if ($inprocessEnquiry->status == '6') {
                return response()->json(['status' => 402, 'message' => 'Landlord is already booked by customer!']);
            } else {
                return response()->json(['status' => 402, 'message' => 'Landlord is already in process!']);
            }
        }
    }

    public function change_enquiry_status_req_doc(Request $request)
    {

        $validatedData = $request->validate([
            'enquiry_id' => 'required',
            'req_docs' => 'required',
        ], [
            'req_docs.required' => 'Choose atleast one required document.'
        ]);

        $enquiry_id = $request->enquiry_id;

        $enquiryDetail = TenantEnquiryHeader::where('id', $enquiry_id)->with(['enquiryRequests'])->first();

        $process_type = isset($enquiryDetail->enquiryRequests[0]->type) ? $enquiryDetail->enquiryRequests[0]->type : '1';

        TenantEnquiryHeader::where('id', $enquiry_id)->update([
            'status' => TenantEnquiryHeader::WAITING_FOR_DOC_UPLOAD,
        ]);

        // add entry for enquiry lines
        $tenantEnquiryRequest = new TenantEnquiryRequests();
        $tenantEnquiryRequest->enquiry_id = $enquiry_id;
        $tenantEnquiryRequest->type = $process_type;
        $tenantEnquiryRequest->date = Carbon::now()->format('Y-m-d');
        $tenantEnquiryRequest->status = TenantEnquiryHeader::WAITING_FOR_DOC_UPLOAD;
        $tenantEnquiryRequest->message = 'Request for documents by admin';
        $tenantEnquiryRequest->created_by = Auth::user()->id;
        $tenantEnquiryRequest->submitted_by = Auth::user()->id;
        $tenantEnquiryRequest->save();

        $req_docs = isset($request->req_docs) ? $request->req_docs : [];
        if (count($req_docs) > 0) {
            foreach ($req_docs as $value) {
                $EnquiryDocs = new TenantEnquiryDocument();
                $EnquiryDocs->enquiry_id =  $enquiry_id;
                $EnquiryDocs->enquiry_request_id =  $tenantEnquiryRequest->id;
                $EnquiryDocs->document_id =  $value;
                $EnquiryDocs->save();
            }
        }

        $enquiryDetails = TenantEnquiryHeader::where('id', $enquiry_id)->with(['user', 'landlord', 'landlord.propertyDetail'])->first();

        $Notification = new Notifications();
        $Notification->module_code =  'ENQUIRY REQUEST';
        $Notification->from_user_id =   Auth::user()->id;
        $Notification->to_user_id =  $enquiryDetails->user->id;
        $Notification->subject =  "Enquiry Process Application Request Document";
        $Notification->message =  "Your application request is in process kindly upload requested documents for further process.";
        $Notification->read_flag =  '0';
        $Notification->created_by =  Auth::user()->id;
        $Notification->save();

        $mailData['name'] = $enquiryDetails->user->first_name;
        $mailData['username'] = $enquiryDetails->user->first_name;
        $mailData['user_email'] = $enquiryDetails->user->email;
        $mailData['enquiry_type'] = $process_type == '1' ? 'Application Request' : 'Document Upload';
        $mailData['property_type'] = $enquiryDetails->landlord->propertyDetail->property_type;
        $mailData['enquiry_message'] = $tenantEnquiryRequest->message;
        $mailData['enquiry_date'] = Carbon::now()->format('d-M-Y');
        $mailData['enquiry_status'] = TenantEnquiryHeader::STATUS_LABELS[$enquiryDetails->status];
        $mailData['subject'] = 'Enquiry Process Application Request Document';
        $mailData['email_message'] = 'Your application request is in process kindly upload requested documents for further process.';

        $body = view('emails.enquiry_email', $mailData);
        $userEmailsSend[] = $enquiryDetails->user->email; //'hamza@5dsolutions.ae';//
        // to username, to email, from username, subject, body html
        sendMail($enquiryDetails->user->first_name, $userEmailsSend, 'LEASE MATCH', 'Enquiry Notification', $body);

        return response()->json(['status' => 200, 'message' => 'Application confirmed successfully!']);
    }

    public function view_enquiry_docs(Request $request)
    {

        $enquiry_id = $request->enquiry_id;

        $data['enquiry_docs'] = TenantEnquiryDocument::where('enquiry_id', $enquiry_id)->with('required_document')->get();

        return response()->json(['status' => 200, 'message' => '', 'data' => $data]);
    }

    public function change_enquiry_status(Request $request)
    {

        $enquiry_id = $request->enquiry_id;
        $status = $request->status;
        $docIds = explode(',', $request->docIds);

        $enquiryDetail = TenantEnquiryHeader::where('id', $enquiry_id)->with(['enquiryRequests'])->first();

        $process_type = isset($enquiryDetail->enquiryRequests[0]->type) ? $enquiryDetail->enquiryRequests[0]->type : '1';

        TenantEnquiryHeader::where('id', $enquiry_id)->update([
            'status' => $status,
        ]);

        // add entry for enquiry lines
        $tenantEnquiryRequest = new TenantEnquiryRequests();
        $tenantEnquiryRequest->enquiry_id = $enquiry_id;
        $tenantEnquiryRequest->type = $process_type;
        $tenantEnquiryRequest->date = Carbon::now()->format('Y-m-d');
        $tenantEnquiryRequest->status = $status;
        $tenantEnquiryRequest->message = TenantEnquiryHeader::STATUS_LABELS[$status] . ' by admin';
        $tenantEnquiryRequest->created_by = Auth::user()->id;
        $tenantEnquiryRequest->submitted_by = Auth::user()->id;
        $tenantEnquiryRequest->save();

        if ($status == '6') { // Approved
            LandlordPersonal::where('id', $enquiryDetail->landlord_id)->update([
                'enquiry_status' => '3', // Booked
            ]);
            TenantEnquiryDocument::where('enquiry_id', $enquiry_id)->update([
                'status' => '1', // Approved
            ]);
        }
        if ($status == '7') { // Returned
            TenantEnquiryDocument::where('enquiry_id', $enquiry_id)->whereIn('id', $docIds)->update([
                'status' => '2', // Returned
            ]);
            TenantEnquiryDocument::where('enquiry_id', $enquiry_id)->whereNotIn('id', $docIds)->update([
                'status' => '1', // Returned
            ]);
        }
        if ($status == '8') { // Cancel
            LandlordPersonal::where('id', $enquiryDetail->landlord_id)->update([
                'enquiry_status' => '1', // Available
            ]);
            TenantEnquiryDocument::where('enquiry_id', $enquiry_id)->update([
                'status' => '3', // Cancelled
            ]);
        }

        $enquiryDetails = TenantEnquiryHeader::where('id', $enquiry_id)->with(['user', 'landlord', 'landlord.propertyDetail'])->first();

        $Notification = new Notifications();
        $Notification->module_code =  'ENQUIRY REQUEST';
        $Notification->from_user_id =   Auth::user()->id;
        $Notification->to_user_id =  $enquiryDetails->user->id;
        if ($status == '6') { // Approved
            $Notification->subject = "Enquiry Process Application Approved";
            $Notification->message = "Your application request is approved by admin.";
        }
        if ($status == '7') { // Returned
            $Notification->subject = 'Enquiry Process Application Returned';
            $Notification->message = 'Your application request is returned by admin. Kindly reupload document and submit.';
        }
        if ($status == '8') { // Cancelled
            $Notification->subject = 'Enquiry Process Application Cancelled';
            $Notification->message = 'Your application request is cancelled by admin. if you have any query contact admin.';
        }
        $Notification->read_flag =  '0';
        $Notification->created_by =  Auth::user()->id;
        $Notification->save();

        $mailData['name'] = $enquiryDetails->user->first_name;
        $mailData['username'] = $enquiryDetails->user->first_name;
        $mailData['user_email'] = $enquiryDetails->user->email;
        $mailData['enquiry_type'] = $process_type == '1' ? 'Application Request' : 'Document Upload';
        $mailData['property_type'] = $enquiryDetails->landlord->propertyDetail->property_type;
        $mailData['enquiry_message'] = $tenantEnquiryRequest->message;
        $mailData['enquiry_date'] = Carbon::now()->format('d-M-Y');
        $mailData['enquiry_status'] = TenantEnquiryHeader::STATUS_LABELS[$enquiryDetails->status];

        if ($status == '6') { // Approved
            $mailData['subject'] = 'Enquiry Process Application Approved';
            $mailData['email_message'] = 'Your application request is approved by admin.';
        }
        if ($status == '7') { // Returned
            $mailData['subject'] = 'Enquiry Process Application Returned';
            $mailData['email_message'] = 'Your application request is returned by admin. Kindly reupload document and submit.';
        }
        if ($status == '8') { // Cancelled
            $mailData['subject'] = 'Enquiry Process Application Cancelled';
            $mailData['email_message'] = 'Your application request is cancelled by admin. if you have any query contact admin.';
        }

        $body = view('emails.enquiry_email', $mailData);
        $userEmailsSend[] = 'hamza@5dsolutions.ae'; //$enquiryDetails->user->email;//
        // to username, to email, from username, subject, body html
        sendMail($enquiryDetails->user->first_name, $userEmailsSend, 'LEASE MATCH', 'Enquiry Notification', $body);

        return response()->json(['status' => 200, 'message' => 'Application status updated successfully!']);
    }

    public function readAllNotifications(Request $request)
    {

        Notifications::where('to_user_id', Auth::user()->id)->update([
            'read_flag' => '1',
        ]);

        return response()->json(['status' => 200, 'message' => 'Read Notifications successfully']);
    }


    public function admin_account_profile(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user
        $savedFilePaths = '';
        $req_file = 'profile_picture';
        $path = 'uploads/user/profile'; // Remove leading slash for correct path

        // Validate the incoming request for file
        $request->validate([
            $req_file => 'nullable|file|mimes:jpeg,jpg,png,avif|max:2048' // Add validation rules
        ]);

        if ($request->hasFile($req_file)) {
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0777, true);
            }

            $uploadedFile = $request->file($req_file);
            $file_extension = $uploadedFile->getClientOriginalExtension();
            $date_append = Str::random(32);
            $uploadedFile->move(public_path($path), $date_append . '.' . $file_extension);

            $savedFilePaths = '/' . $path . '/' . $date_append . '.' . $file_extension; // Correct path for saved file
        }

        // Update the user's profile picture if a new one was uploaded
        if ($savedFilePaths) {
            $user->profile_picture = $savedFilePaths;
            $user->save(); // Save the updated user model
        }

        return response()->json(['status' => 200, 'message' => 'Profile updated successfully']);
    }

    public function markAsRead($id)
    {
        $notification = Notifications::find($id);
        if ($notification && $notification->to_user_id == Auth::id()) {
            $notification->read_flag = '1';
            $notification->save();

            return response()->json(['success' => true, 'status' => 200, 'message' => "Operation Successful"]);
        }

        return response()->json(['success' => false, 'status' => 403, 'message' => "Operation failed"], 403);
    }

    public function get_commercial_enquiries_data(Request $request)
    {

        $data['enquiries'] = Inquiry::get();

        return response()->json(['status' => 200, 'message' => '', 'data' => $data]);
    }

    public function get_commercial_enquiries_detail(Request $request)
    {
        $enquiry_id = $request->id;
        $data['enquiry_detail'] = Inquiry::where('id', $enquiry_id)->first();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function search_commercial_enquiry_listing(Request $request)
    {

        $full_name = $request->search_full_name;
        $business_name = $request->search_business_name;
        $job_title = $request->search_job_title;
        $email = $request->search_email;
        $phone_number = $request->search_phone_number;

        // check atleast one filter check
        if (is_null($full_name) && is_null($business_name) && is_null($job_title) && is_null($email) && is_null($phone_number)) {
            return response()->json(['status' => 402, 'message' => 'Choose atleast one filter first!']);
        }

        $query = Inquiry::query();

        if (!is_null($full_name)) {
            $query->where('full_name', 'like', '%' . $full_name . '%');
        }

        if (!is_null($business_name)) {
            $query->where('business_name', 'like', '%' . $business_name . '%');
        }

        if (!is_null($job_title)) {
            $query->where('job_title', 'like', '%' . $job_title . '%');
        }

        if (!is_null($email)) {
            $query->where('email', 'like', '%' . $email . '%');
        }

        if (!is_null($phone_number)) {
            $query->where('phone_number', 'like', '%' . $phone_number . '%');
        }

        // Execute the query and get the results
        $data['enquiries'] = $query->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }


    public function testimonialIndex(Request $request)
    {
        $data['testimonials'] = Testimonial::all();
        $data['page'] = 'Testimonials';
        return view('admin.testimonial.index', $data);
    }


    public function addTestimonial(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'address' => 'required',
            'rating' => 'required|numeric|between:1,5',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        $testimonial = new Testimonial();
        $name = $request->name;
        $title = $request->title;
        $description = $request->description;
        $address = $request->address;
        $rating = $request->rating;

        $testimonial->name = $name;
        $testimonial->title = $title;
        $testimonial->description = $description;
        $testimonial->address = $address;
        $testimonial->rating = $rating;
        if ($request->has('status')) {
            $testimonial->status = $request->status == "on" ? 1 : 0; // Update the status field in the model

        } else {
            $testimonial->status = 0; // Default status is 1 if no status is provided
        }
        $savedFilePaths = '';
        $req_file = 'profile';
        $path = '/uploads/user/profile';

        if ($request->hasFile($req_file)) { // Use $req_file instead of hardcoding 'profile'
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0777, true);
            }

            $uploadedFile = $request->file($req_file); // No need for double dollar sign
            $file_extension = $uploadedFile->getClientOriginalExtension(); // Use single dollar sign
            $date_append = Str::random(32);
            $uploadedFile->move(public_path($path), $date_append . '.' . $file_extension); // Use single dollar sign

            $savedFilePaths = '/uploads/user/profile/' . $date_append . '.' . $file_extension; // Correct path for saved file
            $testimonial->path = $savedFilePaths; // Update the profile field in the model
        }
        $testimonial->save();

        return response()->json(['status' => 200, 'message' => 'Testimonial added successfully', 'testimonial' => $testimonial]);
    }

    public function testimonialData(Request $request)
    {
        $id = $request->id;
        $testimonial = Testimonial::find($id);
        $testimonial->path = '/public'.$testimonial->path;
        return response()->json(['status' => 200, 'data' => $testimonial]);
    }

    public function getTestimonialList(Request $request)
    {
        $testimonial = Testimonial::all();
        $active = Testimonial::where('status', 1)->count();
        $inactive = Testimonial::where('status', 0)->count();
        return response()->json(['status' => 200, 'data' => $testimonial, 'active' => $active, 'inactive' => $inactive]);
    }


    public function updateTestimonial(Request $request)
    {
        $request->validate([
            'name_edit' => 'required',
            'title_edit' => 'required',
            'description_edit' => 'required',
            'address_edit' => 'required',
            'rating_edit' => 'required|numeric|between:1,5',
            'profile_edit' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'edit_id' => 'required'
        ]);
        $testimonial = Testimonial::where('id', $request->edit_id)->first();
        $name = $request->name_edit;
        $title = $request->title_edit;
        $description = $request->description_edit;
        $address = $request->address_edit;
        $rating = $request->rating_edit;

        $testimonial->name = $name;
        $testimonial->title = $title;
        $testimonial->description = $description;
        $testimonial->address = $address;
        $testimonial->rating = $rating;
        if ($request->has('status_edit')) {
            $testimonial->status = $request->status_edit == "on" ? 1 : 0;
        } else {
            $testimonial->status = 0;
        }
        $savedFilePaths = '';

        $req_file = 'profile_edit';
        $path = '/uploads/user/profile';

        if ($request->hasFile($req_file)) { 
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0777, true);
            }

            $uploadedFile = $request->file($req_file); 
            $file_extension = $uploadedFile->getClientOriginalExtension(); 
            $date_append = Str::random(32);
            $uploadedFile->move(public_path($path), $date_append . '.' . $file_extension); 
            $savedFilePaths = '/uploads/user/profile/' . $date_append . '.' . $file_extension; 
            $testimonial->path = $savedFilePaths; 
        }
        $testimonial->save();
        return response()->json(['status' => 200, 'message' => 'Testimonial updated successfully', 'testimonial' => $testimonial]);
    }


    public function deleteTestimonial(Request $request)
    {
        $id = $request->del_id;
        $testimonial = Testimonial::find($id);
        $testimonial->delete();
        return response()->json(['status' => 200, 'message' => 'Testimonial deleted successfully']);
    }


    public function testimonialStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $testimonial = Testimonial::find($id);
        $testimonial->status = $testimonial->status == 1 ? 0 : 1;
        $testimonial->save();
        return response()->json(['status' => 200, 'message' => 'Testimonial status updated successfully']);
    }
}
