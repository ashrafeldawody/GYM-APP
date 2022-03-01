<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Manager extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    protected $guarded = [];


    public function coaches() {
        return $this->hasMany(Coach::class);
    }


}
