<?php

namespace App\Models;

use Carbon\Carbon;
use Cog\Laravel\Ban\Traits\Bannable;
use Cog\Contracts\Ban\Bannable as BannableContract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Manager extends Authenticatable implements BannableContract
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles, Bannable;
    protected $hidden = ['password','email_verified_at','banned_at','remember_token','created_at','updated_at'];
    protected $guarded = [];
    protected $appends = ['avatar'];

    public function getAvatarAttribute($avatar)
    {
        return URL::to('/') . '/' . $avatar ?: 'avatar.png';
    }

    public function coaches() {
        return $this->hasManyThrough(Coach::class, TrainingSessionCoach::class);
    }
    public function trainingPackages(){
        return $this->belongsToMany(TrainingPackage::class);
    }
    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
    public function city() {
        return $this->hasOne(City::class);
    }
    public function gyms() {
        return $this->hasManyThrough(Gym::class, City::class);
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

    public function setRole($role) {
        $this->syncRoles($role);
    }
}
