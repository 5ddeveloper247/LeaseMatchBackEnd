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
use App\Models\Api\ContactUs;


class ContactController extends Controller
{

    public function storeContactUs(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // Contact Us
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[\w\.-]+@[\w\.-]+\.[a-z]{2,}$/i' // Regex to ensure @ and valid domain extensions
            ],
            'subject' => 'required|max:255',
            'phone_number' => 'required|numeric|digits_between:7,18',
            'message' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        try {

            $ContactUs = new ContactUs();
            $ContactUs->name = $request->input('name');
            $ContactUs->email = $request->input('email');
            $ContactUs->subject = $request->input('subject');
            $ContactUs->phone = $request->input('phone_number');
            $ContactUs->message = $request->input('message');
            $ContactUs->date = date('Y-m-d');
            $ContactUs->save();

            return response()->json([
                'success' => true,
                'message' => 'Your message send, we will respond you soon, Thanks.'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing user info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }
}
