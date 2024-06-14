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
use App\Models\ApiSettings;
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

    public function my_account(){
        $data['page'] = 'My Account';
        return view('admin/my_account')->with($data);
    }

    public function propertyMatches(){
        $data['page'] = 'Property Matches';
        return view('admin/user_property_matches')->with($data);
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

    public function get_admin_users_list(Request $request)
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
            $userEmailsSend[] = $user->email;//'hamza@5dsolutions.ae';//
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

    public function get_landlord_data(Request $request)
    {
        $data['landlord_list'] = LandlordPersonal::with(['propertyDetail'])->get();
        $data['total'] = LandlordPersonal::count();
        $data['total_inactive'] = LandlordPersonal::where('status', '0')->count();
        $data['total_active'] = LandlordPersonal::where('status', '1')->count();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function change_status_landlord(Request $request)
    {
        $landlord_id = $request->id;
        $landlord = LandlordPersonal::where('id',$landlord_id)->first();
        
        if($landlord->status == 0){
            $landlord->status = 1;
        } else {
            $landlord->status = 0;
        }
        
        $landlord->updated_by = Auth::user()->id;
        $landlord->save();

        return response()->json(['status' => 200, 'message' => "Status Updated Successfully!"]);
    }

    public function get_specific_landlord(Request $request)
    {
        $landlord_id = $request->id;
        $data['details'] = LandlordPersonal::where('id', $landlord_id)
                                        ->with(['propertyDetail','rentalDetail','tenantDetail',
                                                'additionalDetail','propertyImages'])
                                        ->first();
        
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function delete_landlord(Request $request){
        $landlord_id = $request->id;
        $images = LandlordPropertyImages::where('landlord_id', $landlord_id)->get();

        LandlordPersonal::where('id', $landlord_id)->delete();
        LandlordProperty::where('landlord_id', $landlord_id)->delete();
        LandlordRental::where('landlord_id', $landlord_id)->delete();
        LandlordTenant::where('landlord_id', $landlord_id)->delete();
        LandlordAdditional::where('landlord_id', $landlord_id)->delete();
        LandlordPropertyImages::where('landlord_id', $landlord_id)->delete();
        
        if($images != null){
            foreach($images as $image){
                deleteImage(str_replace('/public',"",$image->path));
            }
        }
        
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

    public function change_status_tenant(Request $request)
    {
        $user_id = $request->id;
        $user = User::where('id',$user_id)->where('type', 3)->first();
        if($user){
            if($user->status == 0){
                $user->status = 1;
            } else {
                $user->status = 0;
            }

            $user->updated_by = Auth::user()->id;
            $user->save();

            return response()->json(['status' => 200, 'message' => "Status Updated Successfully!"]);
        
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong!"]);
        }
    }

    public function delete_tenant(Request $request){
        $user_id = $request->id;
        $docs = UserDocuments::where('id',$user_id)->get();

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
        
        if($docs != null){
            foreach($docs as $doc){
                deleteImage(str_replace('/public',"",$doc->doc_url));
            }
        }
        
        return response()->json(['status' => 200, 'message' => "Deleted Successfully!"]);
    }

    public function get_specific_tenant(Request $request)
    {
        $tenant_id = $request->id;
        $data['details'] = User::where('id', $tenant_id)->where('type', 3)
                                        ->with(['personalInfo','residentialInfo','financialInfo',
                                                'rentalInfo','livingInfo','householdInfo',
                                                'petInfo','accomodationInfo','additionalInfo',
                                                'legalInfo','references','additionalNote','userDocs'])
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
        if(!isset($apiSettings->id)){
            $apiSettings = new ApiSettings();
        }
        
        $apiSettings->secret_key = $request->secret_key;
        $apiSettings->publishable_key = $request->publishable_key;
        $apiSettings->status = '1';
        if(isset($apiSettings->id)){
            $apiSettings->updated_by = Auth::user()->id;
        }else{
            $apiSettings->created_by = Auth::user()->id;
        }
        // Save the changes
        $apiSettings->save();

        //Handle Registeration Payment
        return response()->json(['status' => 200, 'message' => "Settings added successfully!"]);
    }

    public function get_payment_data(Request $request)
    {
        $data['payment_user_list'] = User::where('type', 3)->withCount(['userPayments'])->with(['personalInfo'])->get();
        
        return response()->json(['status' => 200, 'data' => $data]);
    }
    
    public function get_payment_list_user(Request $request)
    {
        $user_id = $request->id;

        $data['detail'] = User::where('id', $user_id)->where('type', 3)->with(['userPayments','personalInfo','userPayments.plan'])->first();
        
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_subscriptions_data(Request $request)
    {
        $data['subscriptions_user_list'] = User::where('type', 3)->withCount(['userSubscriptions'])->with(['personalInfo'])->get();
        
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_subscriptions_list_user(Request $request)
    {
        $user_id = $request->id;

        $data['detail'] = User::where('id', $user_id)->where('type', 3)->with(['userSubscriptions','personalInfo','userSubscriptions.plan'])->first();
        
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
        if(isset($contact->id)){
            
            $contact->reply = $request->reply_message;
            $contact->replied_by = Auth::user()->id;
            // Save the changes
            $contact->save();

            $contact_detail = ContactUs::find($request->contact_id);
            $body = view('emails.contact_us_reply', $contact_detail);
            $userEmailsSend[] = $contact_detail->email;//'hamza@5dsolutions.ae';//
            // to username, to email, from username, subject, body html
            sendMail($contact_detail->name, $userEmailsSend, 'LEASE MATCH', 'Contact Us', $body); // send_to_name, send_to_email, email_from_name, subject, body
            

            return response()->json(['status' => 200, 'message' => "Plan updated successfully!"]);
        }else{
            return response()->json(['status' => 402, 'message' => "Something went wrong!"]);
        }
    }


    public function get_profile_data(Request $request){
        $user_id = Auth::id();
        $data['details'] = User::where('id', $user_id)->whereIn('type', ['1','2'])
        ->with(['personalInfo'])
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
            ],[
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

    public function enquiry_page_data(Request $request){

        // $data['listing'] = EnquiryProcess::with(['user','landlord','landlord.propertyDetail'])->get();
        
        // return response()->json(['status' => 200, 'data' => $data]);
    }

    public function get_matches_data(Request $request)
    {
        $data['user_list'] = User::where('type', 3)->with(['personalInfo'])->get();
        
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function required_documents(){
        $data['page'] = 'Required Documents';
        return view('admin/required_documents')->with($data);
    }
    public function required_documentsPageData(){
        $data['list'] = RequiredDocuments::all();
        $data['active'] = RequiredDocuments::where('status',1)->count();
        $data['inactive'] = RequiredDocuments::where('status',0)->count();
        $data['total'] = RequiredDocuments::count();
        return response()->json(['status' => 200, 'data' => $data]);

    }

    public function add_new_required_document(Request $request){
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
    public function changeRequiredDocumentStatus(Request $request){
        $document_id  = $request->id;
        $document = RequiredDocuments::find($document_id);
        if($document->status == 1  || $document->status == '1'){
            $document->status = 0;
        }
       else{
            $document->status = 1;
        }
        $document->save();
        return response()->json(['status' => 200, 'message' => 'Document Status Updated Successfully']);
    }

    public function deleteRequiredDocument(Request $request){
        $document_id  = $request->id;
        $document = RequiredDocuments::find($document_id);
        if($document){
            $document->delete();
            return response()->json(['status' => 200, 'message' => 'Document Deleted Successfully']);
        }
        else{
            return response()->json(['status' => 402, 'message' => 'Document Not found']);
        }
    }
    public function getRequiredDocumentDetails(Request $request){
        $document_id  = $request->id;
        $document = RequiredDocuments::find($document_id);
        if($document){
            return response()->json(['status' => 200, 'data' => $document]);
        }
        else{
            return response()->json(['status' => 402, 'message' => 'Document Not found']);
        }
    }
    public function updateRequiredDocument(Request $request){
        $validatedData = $request->validate([
            'name_edit' => 'required|max:50',
            'description_edit' => 'required',
            ],
            [
                'name_edit.required' => 'Document name is required',
                'name_edit.max' => 'Document name can not be more than 50 charatcers',
                'description_edit.required' => 'Description is required'
            ]);
        $document_id  = $request->document_id_edit;
        $document = RequiredDocuments::find($document_id);
        if($document){
            $document->name = $request->name_edit;
            $document->description = $request->description_edit;
            $document->save();
            return response()->json(['status' => 200, 'message' => 'Document Updated Successfully']);
        }
        else{
            return response()->json(['status' => 402, 'message' => 'Document Not found']);
        }
    }
}
