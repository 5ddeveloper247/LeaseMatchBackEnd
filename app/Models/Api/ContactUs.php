<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = 'contact_us';

    public function replied_by()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}
