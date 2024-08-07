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
        self::APPLICATION_CANCEL => 'Canceled',
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
