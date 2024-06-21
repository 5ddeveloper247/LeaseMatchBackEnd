<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $table = 'user_subscription';

    public function transaction()
    {
    	return $this->hasOne(UserPayments::class, 'user_subscription_id');
    }

    public function plan()
    {
        return $this->belongsTo(Pricing_plan::class, 'plan_id');
    }
    
}
