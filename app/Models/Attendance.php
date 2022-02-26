<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function trainingSession(){
        return $this->belongsTo(TrainingSession::class);
    }
}
