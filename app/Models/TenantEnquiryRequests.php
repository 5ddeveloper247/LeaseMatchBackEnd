<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantEnquiryRequests extends Model
{
    use HasFactory;
    protected $table = 'tenant_enquiry_requests';
    protected $fillable = [
        'enquiry_id','type','message','status','submitted_by','created_by','updated_by','date'
    ];
}
