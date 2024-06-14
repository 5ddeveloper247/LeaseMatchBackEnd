<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryDocument extends Model
{
    use HasFactory;

    protected $table = 'enquiry_document';

    public function enquiryHeader()
    {
        return $this->belongsTo(EnquiryHeader::class, 'enquiry_id');
    }

    public function enquiryDetail()
    {
        return $this->belongsTo(EnquiryDetail::class, 'enquiry_detail_id');
    }
}
