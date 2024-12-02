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
use App\Models\Api\LandlordPersonal;
use App\Models\Api\LandlordProperty;
use App\Models\Api\LandlordRental;
use App\Models\Api\LandlordTenant;
use App\Models\Api\LandlordAdditional;
use App\Models\Api\LandlordPropertyImages;
use Illuminate\Validation\Rule;

class LandlordController extends Controller
{

    public function storeLandlord(Request $request)
    {
        // Sanitize numeric fields
        $numericFields = [
            'phone_number',
            'number_of_units',
            'year_built',
            'major_renovation',
            'size_square_feet',
            'number_of_bedrooms',
            'number_of_bathrooms',
            'monthly_rent',
            'security_deposit',
            'lease_duration'
        ];

        foreach ($numericFields as $field) {
            if ($request->has($field)) {
                $request->merge([$field => preg_replace('/\D/', '', $request->input($field))]);
            }
        }

        // Define the validation rules
        $validator = Validator::make($request->all(), [
            // Step 1 Fields
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|unique:landlord_personal,email',
            'phone_number' => 'required|numeric|digits_between:7,18',
            'company_name' => 'required|max:100',

            // Step 2 Fields
            'street_address' => 'required|max:255',
            'appartment_number' => 'required|max:100',
            'neighbourhood' => 'required|max:100',
            'property_type' => 'required|max:100',
            'number_of_units' => 'required|numeric|digits_between:1,10',
            'year_built' => 'required|numeric|digits:4|min:1000|max:' . date('Y'),
            'major_renovation' => $request->filled('major_renovation') ? 'numeric|digits:4|min:1000|max:' . date('Y') : '',

            // Step 3 Fields
            'size_square_feet' => 'required|numeric|digits_between:1,10',
            'number_of_bedrooms' => 'required|numeric|digits_between:1,10',
            'number_of_bathrooms' => 'required|numeric|digits_between:1,10',
            'rental_type' => 'required|string|max:100',
            'monthly_rent' => 'required|numeric|digits_between:1,10',
            'security_deposit' => 'required|numeric|digits_between:1,10',
            'lease_duration' => 'required|numeric|digits_between:1,10',
            'renwal_option' => 'required|string|max:100',
            'list_of_amenities' => 'required|string|max:255',
            'special_feature' => 'required|max:255',

            // Step 4 Fields
            'tenant_characteristics' => 'required|max:255',
            'credit_score' => 'required|max:100',
            'income_requirements' => 'required|max:100',
            'rental_history' => 'required|max:100',

            // Step 5 Fields (File upload)
            'special_note' => 'required',
            'property_photos' => 'required',
            'property_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:10024',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Handle form submission logic here
            // Example: save the landlord data into the database

            return response()->json([
                'success' => true,
                'message' => 'Landlord data stored successfully.'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error storing landlord data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Oops! Something went wrong.',
                'error' => $e
            ], 500);
        }
    }


    public function validateForm(Request $request)
    {
        if ($request->input('step') == '1') {
            // Preprocess the phone number field to remove spaces
            $input = $request->all();

            if (isset($input['phone_number'])) {
                // Remove all spaces from the phone_number
                $input['phone_number'] = preg_replace('/\D/', '', $input['phone_number']);
            }

            // Define validation rules
            $validator = Validator::make($input, [
                'full_name' => 'required|string|max:100',
                'email' => [
                    'required',
                    'email',
                    'max:100',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    Rule::unique('landlord_personal', 'email'), // Ensure email is unique in the landlord_personals table
                ],
                'phone_number' => 'required|numeric|digits_between:7,18', // Validate the sanitized phone number
                'company_name' => 'required|max:100',
            ]);
        }

        if ($request->input('step') == '2') {
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'street_address' => 'required|max:255',
                'appartment_number' => 'required|max:100',
                'neighbourhood' => 'required|max:100',
                'property_type' => 'required|max:100',
                'number_of_units' => 'required|numeric|digits_between:1,10',
                'year_built' => 'required|numeric|digits:4|min:1000|max:' . date('Y'), // Ensure year_built is exactly 4 digits and no earlier than 1000
                'major_renovation' => $request->filled('major_renovation') ? 'numeric|digits:4|min:1000|max:' . date('Y') : '', // If filled, it must be a 4-digit year
            ]);
        }
        if ($request->input('step') == '3') {
            // Preprocess fields to remove spaces
            $input = $request->all();

            $fieldsToClean = ['size_square_feet', 'number_of_bedrooms', 'number_of_bathrooms', 'monthly_rent', 'security_deposit', 'lease_duration'];

            foreach ($fieldsToClean as $field) {
                if (isset($input[$field])) {
                    // Remove all spaces and ensure the value is clean
                    $input[$field] = preg_replace('/\D/', '', $input[$field]);

                    // Ensure the cleaned value is a valid numeric (integer)
                    if (!is_numeric($input[$field])) {
                        // Set the value to null or trigger an error
                        $input[$field] = null; // You can set this to null or handle it differently
                    }
                }
            }

            // Define validation rules
            $validator = Validator::make($input, [
                'size_square_feet' => 'required|numeric|digits_between:1,10', // Use numeric instead of integer for better validation
                'number_of_bedrooms' => 'required|numeric|digits_between:1,10',
                'number_of_bathrooms' => 'required|numeric|digits_between:1,10',
                'rental_type' => 'required|string|max:100',
                'monthly_rent' => 'required|numeric|digits_between:1,10',
                'security_deposit' => 'required|numeric|digits_between:1,10',
                'lease_duration' => 'required|numeric|digits_between:1,10',
                'renwal_option' => 'required|string|max:100',
                'list_of_amenities' => 'required|string|max:255',
                'special_feature' => 'required|max:255',
            ]);
        }



        if ($request->input('step') == '4') {
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'tenant_characteristics' => 'required|max:255',
                'credit_score' => 'required|max:100',
                'income_requirements' => 'required|max:100',
                'rental_history' => 'required|max:100',
            ]);
        }

        if ($request->input('step') == '5') {
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'special_note' => 'required',
                'property_photos' => 'required',
                'property_photos.*' => 'image|mimes:jpeg,png,jpg|max:10024',
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
                'error' => $e
            ], 500);
        }
    }
}
