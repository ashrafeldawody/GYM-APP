<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function gym(){
        return $this->belongsTo(Gym::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'attendances');
    }

    public function coaches(){
        return $this->belongsToMany(Coach::class,'training_session_coaches');
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

}
