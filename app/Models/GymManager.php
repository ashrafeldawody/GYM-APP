<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class GymManager extends Model
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;
    protected  $guarded = [];
    public $timestamps = false;

    public function manager() {
        return $this->belongsTo(Manager::class, 'id');
    }

    public function gym() {
        return $this->belongsTo(Gym::class);
    }
}
