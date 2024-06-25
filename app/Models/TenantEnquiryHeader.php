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

class TenantEnquiryHeader extends Model
{
    use HasFactory;

    protected $table = 'tenant_enquiry_header';

    public function landlord()
    {
        return $this->belongsTo(LandlordPersonal::class, 'landlord_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enquiryRequests()
    {
    	return $this->hasMany(TenantEnquiryRequests::class, 'enquiry_id');
    }

    public function enquiryDocs()
    {
    	return $this->hasMany(TenantEnquiryDocument::class, 'enquiry_id');
    }

    const APPLICATION_REQUESTED = 1;
    const APPLICATION_CONFIRMED = 2;
    const WAITING_FOR_DOC_CONFIRM = 3;
    const WAITING_FOR_DOC_UPLOAD = 4;
    const DOCUMENT_UPLOADED = 5;
    const APPLICATION_APPROVED = 6;
    const APPLICATION_RETURN = 7;
    const APPLICATION_CANCEL = 8;
    const WAITING = 9;

    const STATUS_LABELS = [
        self::APPLICATION_REQUESTED => 'Application requested',
        self::APPLICATION_CONFIRMED => 'Application confirmed',
        self::WAITING_FOR_DOC_CONFIRM => 'Waiting for doc confirm',
        self::WAITING_FOR_DOC_UPLOAD => 'Waiting for doc upload',
        self::DOCUMENT_UPLOADED => 'Document Uploaded',
        self::APPLICATION_APPROVED => 'Approved',
        self::APPLICATION_RETURN => 'Returned',
        self::APPLICATION_CANCEL => 'Cancelled',
        self::WAITING => 'Waiting',
    ];

    // Accessor to get status text
    public function getStatusTextAttribute()
    {
        return self::STATUS_LABELS[$this->status] ?? 'Unknown';
    }

    // Ensure the status_text attribute is included in JSON responses
    protected $appends = ['status_text'];
}
