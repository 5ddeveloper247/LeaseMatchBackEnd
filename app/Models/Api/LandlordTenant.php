<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandlordTenant extends Model
{
    use HasFactory;

    protected $table = 'landlord_tenant';
}
