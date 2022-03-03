<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }

    public function trainingSession(){
        return $this->hasMany(TrainingSession::class);
    }
}
