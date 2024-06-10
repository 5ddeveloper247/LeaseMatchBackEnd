<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Api\UserPersonalInfo;
use App\Models\Api\ResidentialPreference;
use App\Models\Api\FinancialInfo;
use App\Models\Api\RentalAssistance;
use App\Models\Api\LivingSituation;
use App\Models\Api\HouseholdInfo;
use App\Models\Api\PetInformation;
use App\Models\Api\AccommodationRequirements;
use App\Models\Api\AdditionalInfo;
use App\Models\Api\LegalCompliance;
use App\Models\Api\UserReferences;
use App\Models\Api\AdditionalNotes;
use App\Models\Api\UserDocuments;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'otp',
    //     'otp_created_at',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function menuControls()
    {
        return $this->hasMany(MenuControl::class, 'user_id');
    }

    public function personalInfo()
    {
    	return $this->hasOne(UserPersonalInfo::class, 'user_id');
    }

    public function residentialInfo()
    {
    	return $this->hasOne(ResidentialPreference::class, 'user_id');
    }

    public function financialInfo()
    {
    	return $this->hasOne(FinancialInfo::class, 'user_id');
    }

    public function rentalInfo()
    {
    	return $this->hasOne(RentalAssistance::class, 'user_id');
    }

    public function livingInfo()
    {
    	return $this->hasOne(LivingSituation::class, 'user_id');
    }

    public function householdInfo()
    {
    	return $this->hasOne(HouseholdInfo::class, 'user_id');
    }

    public function petInfo()
    {
    	return $this->hasOne(PetInformation::class, 'user_id');
    }

    public function accomodationInfo()
    {
    	return $this->hasOne(AccommodationRequirements::class, 'user_id');
    }

    public function additionalInfo()
    {
    	return $this->hasOne(AdditionalInfo::class, 'user_id');
    }

    public function legalInfo()
    {
    	return $this->hasOne(LegalCompliance::class, 'user_id');
    }

    public function references()
    {
    	return $this->hasOne(UserReferences::class, 'user_id');
    }

    public function additionalNote()
    {
    	return $this->hasOne(AdditionalNotes::class, 'user_id');
    }

    public function userDocs()
    {
    	return $this->hasMany(UserDocuments::class, 'user_id');
    }

    public function userPayments()
    {
    	return $this->hasMany(UserPayments::class, 'user_id');
    }

    public function userSubscriptions()
    {
    	return $this->hasMany(UserSubscription::class, 'user_id');
    }
    
}
