<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSessionCoach extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function coach(){
        return $this->belongsTo(Coach::class);
    }

    public function trainingSession(){
        return $this->belongsTo(TrainingSession::class);
    }

    public function manager(){
        return $this->belongsTo(Manager::class);
    }
}
