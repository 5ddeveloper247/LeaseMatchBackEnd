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

class LandlordController extends Controller
{

    public function storeLandlord(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone_number' => 'required|numeric|digits_between:1,15',
            'company_name' => 'required|max:100',

            'street_address' => 'required|max:255',
            'appartment_number' => 'required|max:100',
            'neighbourhood' => 'required|max:100',
            'property_type' => 'required|max:100',
            'number_of_units' => 'required|numeric|digits_between:1,10',
            'year_built' => 'required|numeric|digits_between:1,10',
            'major_renovation' => 'required|numeric|digits_between:1,10',
        
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
        
            'tenant_characteristics' => 'required|max:255',
            'credit_score' => 'required|max:100',
            'income_requirements' => 'required|max:100',
            'rental_history' => 'required|max:100',
        
            'special_note' => 'required|max:255',
            'property_photos' => 'required',
            'property_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
       
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            // If validation passes, handle the incoming request data and save it accordingly
            $personal = new LandlordPersonal();
            $personal->full_name = $request->input('full_name');
            $personal->email = $request->input('email');
            $personal->phone_number = $request->input('phone_number');
            $personal->company_name = $request->input('company_name');
            $personal->status = 0; // 0 inactive , 1 active
            $personal->save();

            $property = new LandlordProperty();
            $property->landlord_id = $personal->id;
            $property->street_address = $request->input('street_address');
            $property->appartment_number = $request->input('appartment_number');
            $property->neighbourhood = $request->input('neighbourhood');
            $property->property_type = $request->input('property_type');
            $property->number_of_units = $request->input('number_of_units');
            $property->year_built = $request->input('year_built');
            $property->major_renovation = $request->input('major_renovation');
            $property->save();

            $rental = new LandlordRental();
            $rental->landlord_id = $personal->id;
            $rental->size_square_feet = $request->input('size_square_feet');
            $rental->number_of_bedrooms = $request->input('number_of_bedrooms');
            $rental->number_of_bathrooms = $request->input('number_of_bathrooms');
            $rental->rental_type = $request->input('rental_type');
            $rental->monthly_rent = $request->input('monthly_rent');
            $rental->security_deposit = $request->input('security_deposit');
            $rental->lease_duration = $request->input('lease_duration');
            $rental->renwal_option = $request->input('renwal_option');
            $rental->list_of_amenities = $request->input('list_of_amenities');
            $rental->special_feature = $request->input('special_feature');
            $rental->save();

            $tenant = new LandlordTenant();
            $tenant->landlord_id = $personal->id;
            $tenant->tenant_characteristics = $request->input('tenant_characteristics');
            $tenant->credit_score = $request->input('credit_score');
            $tenant->income_requirements = $request->input('income_requirements');
            $tenant->rental_history = $request->input('rental_history');
            $tenant->save();
            
            $additional = new LandlordAdditional();
            $additional->landlord_id = $personal->id;
            $additional->special_note = $request->input('special_note');
            $additional->save();

            $req_file = 'property_photos';
            $path = '/uploads/property_photos';

            if ($request->hasFile($req_file)) {

                if (!File::isDirectory(public_path($path))) {
                    File::makeDirectory(public_path($path), 0777, true);
                }
                
                $uploadedFiles = $request->file($req_file);

                foreach ($uploadedFiles as $file) {
                    $file_extension = $file->getClientOriginalExtension();
                    $date_append = Str::random(32);
                    $file->move(public_path($path), $date_append . '.' . $file_extension);
    
                    $savedFilePaths = $path . '/' . $date_append . '.' . $file_extension;

                    $propertyImages = new LandlordPropertyImages();
                    $propertyImages->landlord_id = $personal->id;
                    $propertyImages->file_name = $file->getClientOriginalName();
                    $propertyImages->path = $savedFilePaths;
                    $propertyImages->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Added successfully'
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

    public function validateForm(Request $request)
    {

        
        if($request->input('step') == '1'){
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'phone_number' => 'required|numeric|digits_between:1,15',
                'company_name' => 'required|max:100',
            ]);
        }
        if($request->input('step') == '2'){
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'street_address' => 'required|max:255',
                'appartment_number' => 'required|max:100',
                'neighbourhood' => 'required|max:100',
                'property_type' => 'required|max:100',
                'number_of_units' => 'required|numeric|digits_between:1,10',
                'year_built' => 'required|numeric|digits_between:1,10',
                'major_renovation' => 'required|numeric|digits_between:1,10',
            ]);
        }
        if($request->input('step') == '3'){
            // Define validation rules
            $validator = Validator::make($request->all(), [
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
            ]);
        }

        if($request->input('step') == '4'){
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'tenant_characteristics' => 'required|max:255',
                'credit_score' => 'required|max:100',
                'income_requirements' => 'required|max:100',
                'rental_history' => 'required|max:100',
            ]);
        }

        if($request->input('step') == '5'){
            // Define validation rules
            $validator = Validator::make($request->all(), [
                'special_note' => 'required|max:255',
                'property_photos' => 'required',
                'property_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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


