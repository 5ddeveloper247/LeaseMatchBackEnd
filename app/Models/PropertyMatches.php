<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\LandlordPersonal;
use App\Models\Api\LandlordProperty;
use App\Models\Api\LandlordRental;
use App\Models\Api\LandlordTenant;
use App\Models\Api\LandlordAdditional;
use App\Models\Api\LandlordPropertyImages;

class PropertyMatches extends Model
{
    use HasFactory;

    protected $table = 'property_matches';

    public function landlordPersonal()
    {
        return $this->belongsTo(LandlordPersonal::class, 'landlord_id');
    }
}
