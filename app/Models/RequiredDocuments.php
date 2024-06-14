<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequiredDocuments extends Model
{
    use HasFactory;
    protected $table= 'required_documents';
    protected $fillable= [
        'name','description','status','created_by','updated_by'
    ];
}
