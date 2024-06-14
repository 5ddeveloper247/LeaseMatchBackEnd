<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// landlord models
use App\Models\Api\LandlordPersonal;
use App\Models\Api\LandlordProperty;
use App\Models\Api\LandlordRental;
use App\Models\Api\LandlordTenant;
use App\Models\Api\LandlordAdditional;
use App\Models\Api\LandlordPropertyImages;

class EnquiryHeader extends Model
{
    use HasFactory;

    protected $table = 'enquiry_header';

    public function landlord()
    {
        return $this->belongsTo(LandlordPersonal::class, 'landlord_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enquiryDetails()
    {
    	return $this->hasMany(EnquiryDetail::class, 'enquiry_id');
    }

    public function enquiryDocs()
    {
    	return $this->hasMany(EnquiryDocument::class, 'enquiry_id');
    }
}
