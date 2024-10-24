<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    //

    public function inquiryValidate(Request $request)
    {
        // Validate commercial inquiry data
        if ($request->step == 1) {
            $request->validate([
                'businessName' => 'required|string|max:255',
                'industrySector' => 'required|string|max:255',
                'year' => 'required|integer|digits:4|max:' . date('Y'), // Updated validation rule
                'companyWebsite' => 'nullable|string|max:255',
            ]);
        }

        if ($request->step == 2) {
            $request->validate([
                'full_name' => 'required|string|max:255',
                'jobTitle' => 'required|string|max:255',
                'phone_number' => 'required|numeric|digits_between:7,18',
                'email' => 'required|email|max:100|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ]);
        }

        if ($request->step == 3) {
            $request->validate([
                'typeOfSpace' => 'required'
            ]);
        }

        if ($request->step == 4) {
            $request->validate([
                'prefferedLeaseTerm' => 'required'
            ]);
        }

        return response()->json(['success' => true, 'status' => 200], 200);
    }

    public function inquiryStore(Request $request)
    {
        // Validate the incoming request data
        $this->inquiryValidate($request); // Assuming you have the inquiryValidate method in the same controller
        // Create a new inquiry record using the validated data
        Inquiry::create([
            'business_name' => $request->businessName,
            'industry_sector' => $request->industrySector,
            'year' => $request->year,
            'company_website' => $request->companyWebsite,
            'full_name' => $request->full_name,
            'job_title' => $request->jobTitle,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'type_of_space' => $request->typeOfSpace == "Other" ? $request->otherTypeOfSpace : $request->typeOfSpace,
            'preferred_lease_term' => $request->prefferedLeaseTerm,
        ]);

        return response()->json(['success' => true, 'status' => 200, 'message' => 'Inquiry created successfully'], 200);
    }
}
