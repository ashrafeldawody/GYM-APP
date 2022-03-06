<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [
        'name',
        'email',
        'gender',
        'password',
        'birth_date',
        'avatar',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
    public function packages() {
        return $this->belongsToMany(TrainingPackage::class, 'purchases');
    }

    public function trainingSessions(){
        return $this->belongsToMany(TrainingSession::class, 'attendances');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
