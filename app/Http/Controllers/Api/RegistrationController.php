<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Notifications;
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
use App\Rules\PreviousDate;

class RegistrationController extends Controller
{

    public function storeRegistration(Request $request)
    {
        $input = $request->all();

        // Sanitize all numeric fields
        $numericFields = [
            'phone_number', // Step 1
            'min_bedrooms_needed',
            'min_bathrooms_needed', // Step 2
            'rental_budget', // Step 3
            'number_of_pets', // Step 7
            'max_rent_to_pay', // Step 9
        ];

        foreach ($numericFields as $field) {
            if (isset($input[$field])) {
                // Remove all non-numeric characters
                $input[$field] = preg_replace('/\D/', '', $input[$field]);
            }
        }

        // Replace the sanitized input back into the request for validation
        $request->merge($input);

        // Define validation rules
        $validator = Validator::make($request->all(), [
            //personal Information
            'name' => 'required|max:100',
            'date_of_birth' => 'required|date_format:Y-m-d|before:today',
            'email' => 'required|email|max:100',
            'phone_number' => 'required|numeric|digits_between:7,18',

            // Residential Preference
            'preferred_location' => 'required|max:100',
            'preferred_property_type' => 'required|max:100',
            'min_bedrooms_needed' => 'required|numeric|digits_between:1,10',
            'min_bathrooms_needed' => 'required|numeric|digits_between:1,10',

            // Financial Information
            'annual_income' => 'required|max:100',
            'employment_status' => 'required|max:100',
            'employer_name' => 'nullable|max:100',
            'income_type' => 'required|max:100',
            'rental_budget' => 'required|numeric|digits_between:1,10',

            // Rental Assistance
            'rental_voucher' => 'required|max:10',
            'voucher_type' => 'required_if:rental_voucher,Yes|max:100',
            'certification_detail' => 'nullable|max:255',
            // 'certification_detail' => 'required_if:rental_voucher,Yes|max:255',
            // 'certification_expiry' => 'required|date_format:Y-m-d',

            // Current/Previous Living Situation
            'current_address' => 'required|max:255',
            'moving_reason' => 'nullable|max:255',
            'prev_landlord_contact' => 'nullable|max:100',
            'lease_violation' => 'max:255',

            // Household Info
            'household_size' => 'required|max:100',
            'number_of_adults' => 'required|string',
            'number_of_child' => 'required|string',

            // Pet Information
            'has_pets' => 'required|max:10',
            'pet_type' => 'required_if:has_pets,Yes|max:100',
            'number_of_pets' => 'required_if:has_pets,Yes', //|digits_between:1,10
            'pet_size' => 'required_if:has_pets,Yes|max:100',

            // Accommodation Requirements
            // Accommodation Requirements
            'disability' => 'required|max:10',
            'disability_type' => 'required_if:disability,Yes|max:100',
            'special_accomodation' => 'required_if:disability,Yes|max:255',

            // Additional Requirements
            'max_rent_to_pay' => 'required|numeric|digits_between:1,10',
            'preffered_move_in_date' => 'date_format:Y-m-d',
            'lease_length_preference' => 'required|max:100',

            // Legal & Compliance
            'criminal_record' => 'required|max:10',
            'legal_right' => 'required|max:100',

            // References
            'reference_name' => 'nullable|string|max:100',
            'reference_relationship' => 'nullable|string|max:100',
            'contact_information' => 'nullable|string|max:255',

            // Additional Notes
            'general_note' => 'nullable|max:255',
            'work_with_broker' => 'required|max:10',

            // 'documents' => 'required',
            'user_name' => 'required|max:100',
            'user_email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
            ],
        ], [
            'password.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $password = $request->input('password');
            // If validation passes, handle the incoming request data and save it accordingly
            $User = new User();
            $User->type = '3';
            $User->first_name = $request->input('user_name');
            $User->email = $request->input('user_email');
            $User->password = bcrypt($password);
            $User->status = '0';
            $User->save();

            //personal Information
            $UserPersonal = new UserPersonalInfo();
            $UserPersonal->user_id = $User->id;
            $UserPersonal->name = $request->input('name');
            $UserPersonal->date_of_birth = $request->input('date_of_birth');
            $UserPersonal->email = $request->input('email');
            $UserPersonal->phone_number = $request->input('phone_number');
            $UserPersonal->save();

            // Residential Preference
            $UserResidential = new ResidentialPreference();
            $UserResidential->user_id = $User->id;
            $UserResidential->preferred_location = $request->input('preferred_location');
            $UserResidential->preferred_property_type = $request->input('preferred_property_type');
            $UserResidential->min_bedrooms_needed = $request->input('min_bedrooms_needed');
            $UserResidential->min_bathrooms_needed = $request->input('min_bathrooms_needed');
            $UserResidential->save();

            // Financial Information
            $UserFinancialInfo = new FinancialInfo();
            $UserFinancialInfo->user_id = $User->id;
            $UserFinancialInfo->annual_income = $request->input('annual_income');
            $UserFinancialInfo->employment_status = $request->input('employment_status');
            $UserFinancialInfo->employer_name = $request->input('employer_name');
            $UserFinancialInfo->income_type = $request->input('income_type');
            $UserFinancialInfo->rental_budget = $request->input('rental_budget');
            $UserFinancialInfo->save();

            // Rental Assistance
            $UserRentalAssistance = new RentalAssistance();
            $UserRentalAssistance->user_id = $User->id;
            $UserRentalAssistance->rental_voucher = $request->input('rental_voucher');
            $UserRentalAssistance->voucher_type = $request->input('voucher_type');
            $UserRentalAssistance->certification_detail = $request->input('certification_detail');
            $UserRentalAssistance->certification_expiry = $request->input('certification_expiry');
            $UserRentalAssistance->save();

            // Current/Previous Living Situation
            $UserLivingSituation = new LivingSituation();
            $UserLivingSituation->user_id = $User->id;
            $UserLivingSituation->current_address = $request->input('current_address');
            $UserLivingSituation->moving_reason = $request->input('moving_reason');
            $UserLivingSituation->prev_landlord_contact = $request->input('prev_landlord_contact');
            $UserLivingSituation->lease_violation = $request->input('lease_violation');
            $UserLivingSituation->save();

            // Household Info
            $UserHouseholdInfo = new HouseholdInfo();
            $UserHouseholdInfo->user_id = $User->id;
            // Sanitize the inputs by removing everything except numbers, then cast them to integers
            $UserHouseholdInfo->household_size = (int) preg_replace('/\D/', '', $request->input('household_size'));
            $UserHouseholdInfo->number_of_adults = (int) preg_replace('/\D/', '', $request->input('number_of_adults'));
            $UserHouseholdInfo->number_of_children = (int) preg_replace('/\D/', '', $request->input('number_of_child'));

            $UserHouseholdInfo->save();

            // Pet Information
            $UserPetInformation = new PetInformation();
            $UserPetInformation->user_id = $User->id;
            $UserPetInformation->has_pets = $request->input('has_pets');
            $UserPetInformation->pet_type = $request->input('pet_type');
            $UserPetInformation->number_of_pets = $request->input('number_of_pets');
            $UserPetInformation->pet_size = $request->input('pet_size');
            $UserPetInformation->save();

            // Accommodation Requirements
            $UserAccomodation = new AccommodationRequirements();
            $UserAccomodation->user_id = $User->id;
            $UserAccomodation->disability = $request->input('disability');
            $UserAccomodation->disability_type = $request->input('disability_type');
            $UserAccomodation->special_accomodation = $request->input('special_accomodation');
            $UserAccomodation->save();

            // Additional Requirements
            $UserAdditionalInfo = new AdditionalInfo();
            $UserAdditionalInfo->user_id = $User->id;
            $UserAdditionalInfo->max_rent_to_pay = $request->input('max_rent_to_pay');
            $UserAdditionalInfo->preffered_move_in_date = $request->input('preffered_move_in_date');
            $UserAdditionalInfo->lease_length_preference = $request->input('lease_length_preference');
            $UserAdditionalInfo->save();

            // Legal & Compliance
            $UserLegalCompliance = new LegalCompliance();
            $UserLegalCompliance->user_id = $User->id;
            $UserLegalCompliance->criminal_record = $request->input('criminal_record');
            $UserLegalCompliance->legal_right = $request->input('legal_right');
            $UserLegalCompliance->save();

            // References
            $UserReferences = new UserReferences();
            $UserReferences->user_id = $User->id;
            $UserReferences->reference_name = $request->input('reference_name');
            $UserReferences->reference_relationship = $request->input('reference_relationship');
            $UserReferences->contact_information = $request->input('contact_information');
            $UserReferences->save();

            // Additional Notes
            $UserAdditionalNotes = new AdditionalNotes();
            $UserAdditionalNotes->user_id = $User->id;
            $UserAdditionalNotes->general_note = $request->input('general_note');
            $UserAdditionalNotes->work_with_broker = $request->input('work_with_broker');
            $UserAdditionalNotes->save();

            $req_file = 'documents';
            $path = '/uploads/user_documents';

            if ($request->hasFile($req_file)) {

                if (!File::isDirectory(public_path($path))) {
                    File::makeDirectory(public_path($path), 0777, true);
                }

                $uploadedFiles = $request->file($req_file);

                foreach ($uploadedFiles as $file) {
                    $file_extension = $file->getClientOriginalExtension();
                    $date_append = Str::random(32);
                    $file->move(public_path($path), $date_append . '.' . $file_extension);

                    $savedFilePaths = '/public' . $path . '/' . $date_append . '.' . $file_extension;

                    $UserDocuments = new UserDocuments();
                    $UserDocuments->user_id = $User->id;
                    $UserDocuments->doc_name = $file->getClientOriginalName();
                    $UserDocuments->doc_url = $savedFilePaths;
                    $UserDocuments->save();
                }
            }

            $Notification = new Notifications();
            $Notification->module_code =  'TENANT REGISTRATION';
            $Notification->from_user_id =  $User->id;
            $Notification->to_user_id =  '1'; // for admin notification
            $Notification->subject =  "Tenant Registration";
            $Notification->message =  "Tenant is successfully registered to you portal, kindly review tenant details.";
            $Notification->read_flag =  '0';
            $Notification->created_by =  $User->id;
            $Notification->save();

            $mailData['name'] = $User->first_name;
            $mailData['email'] = $User->email;
            $mailData['password'] = $password;
            $body = view('emails.tenant_created', $mailData);
            $userEmailsSend[] = $User->email; //'hamza@5dsolutions.ae';//
            // to username, to email, from username, subject, body html
            sendMail($User->first_name, $userEmailsSend, 'LEASE MATCH', 'User Created', $body); // send_to_name, send_to_email, email_from_name, subject, body

            return response()->json([
                'success' => true,
                'message' => 'User created successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing user info: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
                'error' => $e
            ], 500);
        }
    }


    public function validateForm(Request $request)
    {
        // Get all input data
        $input = $request->all();
        // Sanitize all numeric fields
        $numericFields = [
            'phone_number', // Step 1
            'min_bedrooms_needed',
            'min_bathrooms_needed', // Step 2
            'rental_budget', // Step 3
            'number_of_pets', // Step 7
            'max_rent_to_pay', // Step 9
            'household_size',
            'number_of_adults',
            'number_of_children'

        ];

        foreach ($numericFields as $field) {
            if (isset($input[$field])) {
                // Remove all non-numeric characters
                $input[$field] = preg_replace('/\D/', '', $input[$field]);
            }
        }

        // Replace the sanitized input back into the request for validation
        $request->merge($input);

        if ($request->input('step') == '1') {
            $validator = Validator::make($request->all(), [
                //personal Information
                'name' => 'required|string|max:100',
                'date_of_birth' => 'required|date_format:Y-m-d|before:today',
                'email' => 'required|email|unique:users,email|max:100|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'phone_number' => 'required|numeric|digits_between:7,18',
            ]);
        }

        if ($request->input('step') == '2') {
            $validator = Validator::make($request->all(), [
                // Residential Preference
                'preferred_location' => 'required|string|max:100',
                'preferred_property_type' => 'required|string|max:100',
                'min_bedrooms_needed' => 'required|numeric|digits_between:1,10',
                'min_bathrooms_needed' => 'required|numeric|digits_between:1,10',
            ]);
        }

        if ($request->input('step') == '3') {
            $validator = Validator::make($request->all(), [
                // Financial Information
                'annual_income' => 'required|string|max:100',
                'employment_status' => 'required|string|max:100',
                'employer_name' => 'nullable|string|max:100',
                'income_type' => 'required|string|max:100',
                'rental_budget' => 'required|numeric|digits_between:1,10',
            ]);
        }

        if ($request->input('step') == '4') {
            if ($request->rental_voucher == 'Yes') {
                $validator = Validator::make($request->all(), [
                    // Rental Assistance
                    'rental_voucher' => 'required|max:10',
                    'voucher_type' => 'required|max:100',
                    'certification_detail' => 'nullable|max:255',
                    'certification_expiry' => 'required|date_format:Y-m-d|after:today',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    // Rental Assistance
                    'rental_voucher' => 'required|max:10',
                    'voucher_type' => 'max:100',
                    'certification_detail' => 'nullable|max:255',
                    // 'certification_expiry' => 'after:today',
                ]);
            }
        }

        if ($request->input('step') == '5') {
            $validator = Validator::make($request->all(), [
                // Current/Previous Living Situation
                'current_address' => 'required|max:255',
                'moving_reason' => 'nullable|max:255',
                'prev_landlord_contact' => 'nullable|max:100',
                'lease_violation' => 'max:255',
            ]);
        }

        if ($request->input('step') == '6') {
            $validator = Validator::make($request->all(), [
                // Household Info
                'household_size' => 'required|numeric|max:100',
                'number_of_adults' => 'required|numeric|string',
                'number_of_child' => 'required|numeric|string',
            ]);
        }

        if ($request->input('step') == '7') {
            $validator = Validator::make($request->all(), [
                // Pet Information
                'has_pets' => 'required|max:10',
                'pet_type' => 'required_if:has_pets,Yes|max:100',
                'number_of_pets' => 'required_if:has_pets,Yes', //|digits_between:1,10
                'pet_size' => 'required_if:has_pets,Yes|max:100',
            ]);
        }

        if ($request->input('step') == '8') {
            $validator = Validator::make($request->all(), [
                // Accommodation Requirements
                'disability' => 'required|max:10',
                'disability_type' => 'required_if:disability,Yes|max:100',
                'special_accomodation' => 'required_if:disability,Yes|max:255',
            ]);
        }

        if ($request->input('step') == '9') {
            $validator = Validator::make($request->all(), [
                // Additional Requirements
                'max_rent_to_pay' => 'required|numeric|digits_between:1,10',
                'preffered_move_in_date' => 'date_format:Y-m-d|after_or_equal:today',
                'lease_length_preference' => 'required|string|max:100',
            ]);
        }

        if ($request->input('step') == '10') {
            $validator = Validator::make($request->all(), [
                // Legal & Compliance
                'criminal_record' => 'required|string|max:10',
                'legal_right' => 'required|string|max:100',
            ]);
        }

        if ($request->input('step') == '11') {
            $validator = Validator::make($request->all(), [
                // References
                'reference_name' => 'nullable|string|max:100',
                'reference_relationship' => 'nullable|string|max:100',
                'contact_information' => 'nullable|string|max:255',
            ]);
        }

        if ($request->input('step') == '12') {
            $validator = Validator::make($request->all(), [
                // Additional Notes
                'general_note' => 'nullable|string|max:255',
                'work_with_broker' => 'required|string|max:10',
                'documents' => 'nullable',
                'documents.*' => 'image|mimes:jpeg,png,jpg|max:10024',
            ]);
        }

        if ($request->input('step') == '13') {
            $validator = Validator::make($request->all(), [
                // User Information
                'user_name' => 'required|string|max:100',
                'user_email' => 'required|email|unique:users,email|max:100|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'password_confirmation' => 'required',
                'password' => [
                    'required',
                    'string',
                    'min:8', // Minimum length of 8 characters
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                    'confirmed',
                ],
            ], [
                'password.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ]);
        }

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            return response()->json([
                'success' => true,
                'message' => 'validated successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing contact: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }
}
