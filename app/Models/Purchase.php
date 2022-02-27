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


}
