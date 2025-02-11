<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCardProcess extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'card_number',
        'expiry',
        'cvv',
        'zip',
        'status',
        'created_at',
        'updated_at'
    ];
}
