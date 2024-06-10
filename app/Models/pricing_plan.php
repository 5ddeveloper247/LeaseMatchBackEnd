<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing_plan extends Model
{
    use HasFactory;

    protected $table = 'pricing_plans';

    public function transactions(): HasMany
    {
        return $this->hasMany(UserPayments::class, 'plan_id');
    }
}
