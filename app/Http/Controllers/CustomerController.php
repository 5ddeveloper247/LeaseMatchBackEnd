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
use App\Models\TenantEnquiryHeader;
use App\Models\TenantEnquiryDocument;
use App\Models\TenantEnquiryRequests;
use App\Models\Notifications;
use Illuminate\Support\Facades\Validator;

// landlord models
use App\Models\Api\LandlordPersonal;
use App\Models\Api\LandlordProperty;
use App\Models\Api\LandlordRental;
use App\Models\Api\LandlordTenant;
use App\Models\Api\LandlordAdditional;
use App\Models\Api\LandlordPropertyImages;

use App\Models\PropertyMatches;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
                return redirect()->intended('/customer/myMatches');//dashboard
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
        if(checkUserSubscription() == true){
            $currentDate = Carbon::now()->format('Y-m-d');
        
            $data['page'] = 'Matches';
            $user_id = Auth::user()->id;

            $currentPlan = UserSubscription::where('user_id', $user_id)->where('start_date', '<=', $currentDate)
                                                        ->where('end_date', '>=', $currentDate)
                                                        ->with('plan')->orderBy('created_at', 'desc')->first();

            if(isset($currentPlan->id)){
                $data['properties'] = PropertyMatches::where('user_id', $user_id)
                                                        ->whereHas('landlordPersonal', function ($query){
                                                            $query->where('status', '1');
                                                        })
                                                        ->with(['landlordPersonal',
                                                                'landlordPersonal.propertyDetail',
                                                                'landlordPersonal.rentalDetail',
                                                                'landlordPersonal.tenantDetail',
                                                                'landlordPersonal.additionalDetail',
                                                                'landlordPersonal.propertyImages',
                                                                'tenantEnquiryHeader'
                                                            ])->get();
            }else{
                $data['properties'] = array();
            }
            
            return view('customer/my_matches')->with($data);
            
        }else{
            return redirect()->route('customer.mySubscription');
        }
    }

    public function property_detail(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        
        $data['page'] = 'Matches';
        $currentPlan = UserSubscription::where('user_id', Auth::user()->id)->where('start_date', '<=', $currentDate)
                                ->where('end_date', '>=', $currentDate)
                                ->with('plan')->orderBy('created_at', 'desc')->first();

        $data['property_detail'] = LandlordPersonal::where('id', $request->landlord_id)
                                                    ->where('status', '1')
                                                    ->with(['propertyDetail','rentalDetail','tenantDetail',
                                                        'additionalDetail','propertyImages'])
                                                    ->first();
        
        $data['curr_plan'] = isset($currentPlan->plan) ? $currentPlan->plan : '';
        
        $enquiry_detail = TenantEnquiryHeader::where('user_id', Auth::user()->id)->where('landlord_id', $request->landlord_id)->first();
        $data['enquiry_detail'] = $enquiry_detail;

        if(isset($enquiry_detail->id) && ($enquiry_detail->status == '4' || $enquiry_detail->status == '7')){
            $data['upload_documents'] = TenantEnquiryDocument::where('enquiry_id', $enquiry_detail->id)->with('required_document')->get();
        }
        
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
            $user->otp = $otp;
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
        if($user->otp == null){
            return response()->json(['status' => 402, 'message' => "Invalid request"]);
        }
        if($otp == $user->otp){
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
            'first_name' => 'required|max:50',
            'phone_number' => 'numeric|digits_between:7,18'
        ]);
        if($request->password){
             $request->validate([
            'first_name' => 'required|max:50',
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
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'date_of_birth' => 'required|date_format:Y-m-d|before:today',
            'email' => 'required|email|max:100',
            'phone_number_personal' => 'required|numeric|digits_between:7,18',
        ]);
        
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
        
        $enquirycheck = TenantEnquiryHeader::where('user_id', Auth::user()->id)->where('landlord_id', $request->landlord_id)->first();
        
        if(isset($enquirycheck->id)){
            return response()->json(['status' => 402, 'message' => 'Request already in process!']);
        }
        
        // create enquiry header entry
        $enquiry = new TenantEnquiryHeader();
        $enquiry->user_id = Auth::user()->id;
        $enquiry->landlord_id = $request->landlord_id;
        $enquiry->date = Carbon::now()->format('Y-m-d');
        $checkIfExist = TenantEnquiryHeader::where('landlord_id',$request->landlord_id)->count();
        
        if($checkIfExist > 0){
            $enquiry->status = TenantEnquiryHeader::WAITING;
        } else {
            $enquiry->status = TenantEnquiryHeader::APPLICATION_REQUESTED;
        }
        
        $enquiry->created_by = Auth::user()->id;
        $enquiry->save();
        
        // add entry for enquiry lines
        $tenantEnquiryRequest = new TenantEnquiryRequests();
        $tenantEnquiryRequest->enquiry_id = $enquiry->id;
        $tenantEnquiryRequest->type = $request->process_type;
        $tenantEnquiryRequest->date = Carbon::now()->format('Y-m-d');
        $tenantEnquiryRequest->status = $enquiry->status;
        $tenantEnquiryRequest->message = $request->process_message;
        $tenantEnquiryRequest->created_by = Auth::user()->id;
        $tenantEnquiryRequest->submitted_by = Auth::user()->id;
        $tenantEnquiryRequest->save();
        
        LandlordPersonal::where('id', $request->landlord_id)->update([
            'enquiry_status' => '2', // blocked
        ]);


        $Notification = new Notifications();
        $Notification->module_code =  'ENQUIRY REQUEST';
        $Notification->from_user_id =   Auth::user()->id;
        $Notification->to_user_id =  '1';// for admin notification
        $Notification->subject =  "Tenant Enquiry Request";
        $Notification->message =  "Thank you for submitting the application request. The application has been received and is currently under review. Our team will contact you shortly with further details.";
        $Notification->read_flag =  '0';
        $Notification->created_by =  Auth::user()->id;
        $Notification->save();

        $enquiryDetails = TenantEnquiryHeader::where('id', $enquiry->id)->with(['user', 'landlord','landlord.propertyDetail'])->first();

        $mailData['name'] = $enquiryDetails->user->first_name;
        $mailData['username'] = $enquiryDetails->user->first_name;
        $mailData['user_email'] = $enquiryDetails->user->email;
        $mailData['enquiry_type'] = $request->process_type == '1' ? 'Application Request' : 'Document Upload';
        $mailData['property_type'] = $enquiryDetails->landlord->propertyDetail->property_type;
        $mailData['enquiry_message'] = $tenantEnquiryRequest->message;
        $mailData['enquiry_date'] = Carbon::now()->format('d-M-Y');
        $mailData['enquiry_status'] = TenantEnquiryHeader::STATUS_LABELS[$enquiryDetails->status];
        $mailData['subject'] = 'Enquiry Process Application Submitted';
        $mailData['email_message'] = 'Thank you for submitting your application request. We have received your application and it is currently under review. Our team will contact you shortly with further details.';
        
        $body = view('emails.enquiry_email', $mailData);
        $userEmailsSend[] = $enquiryDetails->user->email;//'hamza@5dsolutions.ae';//
        // to username, to email, from username, subject, body html
        sendMail($enquiryDetails->user->first_name, $userEmailsSend, 'LEASE MATCH', 'Enquiry Notification', $body);
        
        $mailData['name'] = "Admin";
        $mailData['email_message'] = 'I have submitted my application. Please let me know if any further information or actions are required on my part.';
        
        $body = view('emails.enquiry_email', $mailData);
        $userEmailsSend[] = env('MAIL_ADMIN');
        // to username, to email, from username, subject, body html
        sendMail($enquiryDetails->user->first_name, $userEmailsSend, 'LEASE MATCH', 'Enquiry Notification Admin', $body);
        

        return response()->json(['status' => 200, 'message' => 'Your request is submited successfully, we will respond you soon, Thanks']);
        
    }
    
    public function uploadTenantEnquiryDocuments(Request $request){
        
        $request->validate([
            'upload_document' => 'array|required',
            'upload_document.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);
        
        $enquiry_id = $request->enquiry_id;
        $ids = $request->req_doc_ids;
        $docs = $request->upload_document;
        
        foreach($ids as $i =>$id){
            $record = TenantEnquiryDocument::find($id);
            $path = '/uploads/tenant_enquiry_documents/'.$id;
            if($record->path != null){
                deleteImage(str_replace(url('/public'), '', $record->path));
            }
            $uploadedFile = $request->file('upload_document')[$i];
            $savedFile = saveSingleImage($uploadedFile, $path);            
            $record->doc_name = $uploadedFile->getClientOriginalName();
            $record->path = url('/public') . $savedFile;
            $record->save();
        }

        $enquiryDetail = TenantEnquiryHeader::where('id', $enquiry_id)->with(['enquiryRequests'])->first();

        $process_type = isset($enquiryDetail->enquiryRequests[0]->type) ? $enquiryDetail->enquiryRequests[0]->type : '1';
        
        TenantEnquiryHeader::where('id', $enquiry_id)->update([
            'status' => TenantEnquiryHeader::DOCUMENT_UPLOADED,
        ]);

        // add entry for enquiry lines
        $tenantEnquiryRequest = new TenantEnquiryRequests();
        $tenantEnquiryRequest->enquiry_id = $enquiry_id;
        $tenantEnquiryRequest->type = $process_type;
        $tenantEnquiryRequest->date = Carbon::now()->format('Y-m-d');
        $tenantEnquiryRequest->status = TenantEnquiryHeader::DOCUMENT_UPLOADED;
        $tenantEnquiryRequest->message = 'Documents uploaded by customer';
        $tenantEnquiryRequest->created_by = Auth::user()->id;
        $tenantEnquiryRequest->submitted_by = Auth::user()->id;
        $tenantEnquiryRequest->save();

        $Notification = new Notifications();
        $Notification->module_code =  'ENQUIRY REQUEST';
        $Notification->from_user_id =   Auth::user()->id;
        $Notification->to_user_id =  '1';// for admin notification
        $Notification->subject =  "Tenant Document Upload";
        $Notification->message =  "The requested documents for the enquiry have been submitted. Please review them and let me know if any further information or actions are required.";
        $Notification->read_flag =  '0';
        $Notification->created_by =  Auth::user()->id;
        $Notification->save();
        
        $enquiryDetails = TenantEnquiryHeader::where('id', $enquiry_id)->with(['user', 'landlord','landlord.propertyDetail'])->first();

        $mailData['name'] = 'Admin';
        $mailData['username'] = $enquiryDetails->user->first_name;
        $mailData['user_email'] = $enquiryDetails->user->email;
        $mailData['enquiry_type'] = $process_type == '1' ? 'Application Request' : 'Document Upload';
        $mailData['property_type'] = $enquiryDetails->landlord->propertyDetail->property_type;
        $mailData['enquiry_message'] = $tenantEnquiryRequest->message;
        $mailData['enquiry_date'] = Carbon::now()->format('d-M-Y');
        $mailData['enquiry_status'] = TenantEnquiryHeader::STATUS_LABELS[$enquiryDetails->status];
        $mailData['subject'] = 'Enquiry Process Application Documents Upload';
        $mailData['email_message'] = 'I have submitted my requested documents against enquiry. Please let me know if any further information or actions are required.';
        
        $body = view('emails.enquiry_email', $mailData);
        $userEmailsSend[] = env('MAIL_ADMIN');
        // to username, to email, from username, subject, body html
        sendMail($enquiryDetails->user->first_name, $userEmailsSend, 'LEASE MATCH', 'Enquiry Notification', $body);

        return response()->json(['status' => 200, 'message' => 'Document submitted successfully']);
    }

    public function readAllNotifications(Request $request){
        
        Notifications::where('to_user_id', Auth::user()->id)->update([
            'read_flag' => '1',
        ]);

        return response()->json(['status' => 200, 'message' => 'Read Notifications successfully']);
    }

}
