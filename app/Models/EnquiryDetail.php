<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryDetail extends Model
{
    use HasFactory;

    protected $table = 'enquiry_detail';


    public function enquiryHeader()
    {
        return $this->belongsTo(EnquiryHeader::class, 'enquiry_id');
    }

    public function enquiryDetailDocs()
    {
    	return $this->hasMany(EnquiryDocument::class, 'enquiry_detail_id');
    }
}
