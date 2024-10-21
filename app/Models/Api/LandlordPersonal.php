<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyMatches;

class LandlordPersonal extends Model
{
    use HasFactory;

    protected $table = 'landlord_personal';

    public function propertyDetail()
    {
        return $this->hasOne(LandlordProperty::class, 'landlord_id');
    }

    public function rentalDetail()
    {
        return $this->hasOne(LandlordRental::class, 'landlord_id');
    }

    public function tenantDetail()
    {
        return $this->hasOne(LandlordTenant::class, 'landlord_id');
    }

    public function additionalDetail()
    {
        return $this->hasOne(LandlordAdditional::class, 'landlord_id');
    }

    public function propertyImages()
    {
        return $this->hasMany(LandlordPropertyImages::class, 'landlord_id');
    }

    public function propertyMatches()
    {
        return $this->hasMany(PropertyMatches::class, 'landlord_id');
    }
}
