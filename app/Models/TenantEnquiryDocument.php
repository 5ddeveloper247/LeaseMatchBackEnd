<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantEnquiryDocument extends Model
{
    use HasFactory;
    protected $table = 'tenant_enquiry_documents';
    protected $fillable = [
        'enquiry_id','document_id','enquiry_request_id','path','created_by','updated_by'
    ];

    public function required_document()
    {
    	return $this->belongsTo(RequiredDocuments::class, 'document_id');
    }
}
