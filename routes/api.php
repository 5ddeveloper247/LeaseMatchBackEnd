<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LandlordController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\PricingController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\TestimonialController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('5d/v1')->group(function () {
    Route::post('landlord/store', [LandlordController::class, 'storeLandlord'])->name('lanlord.storeLandlord');
    Route::post('landlord/validate', [LandlordController::class, 'validateForm'])->name('lanlord.validateForm');

    Route::post('registration/store', [RegistrationController::class, 'storeRegistration'])->name('registration.storeRegistration');
    Route::post('registration/validate', [RegistrationController::class, 'validateForm'])->name('registration.validateForm');
    Route::get('pricing/getAllPricingList', [PricingController::class, 'getAllPricings'])->name('pricing.getAllPricingList');
    Route::post('contact/send', [ContactController::class, 'storeContactUs'])->name('contact.send');
    Route::post('inquiry/validate', [InquiryController::class, 'inquiryValidate'])->name('lanlord.commercialValidate');
    Route::post('inquiry/store', [InquiryController::class, 'inquiryStore'])->name('lanlord.inquiryStore');
    Route::get('siteTestimonials', [TestimonialController::class, 'siteTestimonials'])->name('siteTestimonials');
});
