<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [
        'name', 
        'email', 
        'gender', 
        'password',
        'birth_date',
        //to be added
        //'profile_img',
    ];   

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }

    public function trainingSession(){
        return $this->hasMany(TrainingSession::class);
    }
}
