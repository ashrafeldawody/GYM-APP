<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;
    public function trainingSessions(){
        return $this->belongsToMany(TrainingSession::class,'training_session_coaches');
    }
    public function gym(){
        return $this->belongsTo(Gym::class);
    }
}
