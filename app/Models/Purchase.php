<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function trainingPackage(){
        return $this->belongsTo(TrainingPackage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
    public function gym() {
        return $this->belongsTo(Gym::class);
    }
}
