<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    public function trainingPackage(){
        return $this->belongsTo(TrainingPackage::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function manager(){
        return $this->belongsTo(User::class,'manager_id');
    }
    public function gym(){
        return $this->belongsTo(Gym::class);
    }
}
