<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    protected $guarded = [];


//    public function gym(){
//        return $this->belongsTo(Gym::class);
//    }

    public function city(){
        return $this->hasOne(City::class,'manager_id');
    }

    public function trainingPackages(){
        return $this->hasMany(TrainingPackage::class);
    }
}
