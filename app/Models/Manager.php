<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Manager extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    protected $hidden = ['password','email_verified_at','is_banned','remember_token','created_at','updated_at'];
    protected $guarded = [];

    public function coaches() {
        return $this->hasManyThrough(Coach::class, TrainingSessionCoach::class);
    }
    public function trainingPackages(){
        return $this->hasMany(TrainingPackage::class);
    }
    public function city() {
        return $this->hasOne(City::class);
    }
    public function gym() {
        return $this->hasOneThrough(Gym::class,GymManager::class,'manager_id','id','id','gym_id');
    }
    public function revenue($days){
        if ($this->hasRole('gym_manager'))
            return $this->gym->purchases->where('created_at', '>', Carbon::now()->subDays($days))->sum('trainingPackage.price');
        else if ($this->hasRole('city_manager'))
            return $this->city->purchases->where('created_at', '>', Carbon::now()->subDays($days))->sum('trainingPackage.price');
        else
            return Purchase::where('created_at', '>', Carbon::now()->subDays($days))->get()->sum('trainingPackage.price');
    }


    public function demoteGymManager() {
        // 1- delete the gymManager record
        // 2- remove role
    }
    public function promote($newRole) {
        // if promote to gymManager
        //
    }
}
