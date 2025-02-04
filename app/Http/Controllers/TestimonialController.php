<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    //
    public function siteTestimonials(Request $request)
    {
        $testimonials = Testimonial::where('status', 1)->get();
        return response()->json([
            'testimonials' => $testimonials,
            'status' => 200
        ]);
    }
}
