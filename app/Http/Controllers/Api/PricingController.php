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
use App\Models\Pricing_plan;


class PricingController extends Controller
{
    
    public function getAllPricings(Request $request)
    {
        try {
            // Fixed: Added -> between Pricing_plan and get()
            $data['pricings'] = Pricing_plan::get();
            
            return response()->json([
                'success' => true,
                'message' => 'Pricing plans retrieved successfully',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            // Log the actual error with better context
            Log::error('Error fetching pricing plans: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    
}
