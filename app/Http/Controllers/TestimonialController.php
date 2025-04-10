<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    //
    public function siteTestimonials(Request $request)
{
    $base_url = url('/'); 

    $testimonials = Testimonial::where('status', 1)->get();
    // Use map to add base_url to the path for each testimonial
    $testimonials = $testimonials->map(function ($testimonial) use ($base_url) {
        // Prepend base_url to the path
        $testimonial->path = $base_url . '/public'.$testimonial->path;
        return $testimonial;
    });

    return response()->json([
        'base_url' => $base_url, 
        'testimonials' => $testimonials,
        'status' => 200
    ]);
}

}
