<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;


    protected $fillable = [
        'business_name',
        'industry_sector',
        'year',
        'company_website',
        'full_name',
        'job_title',
        'phone_number',
        'email',
        'type_of_space',
        'preferred_lease_term',
    ];
}
