<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function managers(){
        return $this->belongsToMany(Manager::class, GymManager::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function trainingSessions() {
        return $this->hasMany(TrainingSession::class);
    }

    public function coaches() {
        return $this->hasMany(Coach::class);
    }

    public function trainingPackages(){
        return $this->hasMany(TrainingPackage::class);
    }
    public function purchases() {
        return $this->hasMany(Purchase::class)->with('user','trainingPackage');
    }
    public function attendances() {
        return $this->hasManyThrough(Attendance::class,TrainingSession::class)->with('user','trainingSession');
    }
    public function creator() {
        return $this->belongsTo(Manager::class, 'creator_id');
    }
}
