<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class City extends Model
{
    use HasRelationships;
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }
    public function gyms()
    {
        return $this->hasMany(Gym::class)->orderBy('name');
    }
    public function gymManagers() {
//        return $this->hasManyThrough(Manager::class, Gym::class);
        return $this->hasManyDeep(Manager::class, [Gym::class, GymManager::class]);
    }

    public function purchases() {
        return $this->hasManyThrough(Purchase::class,Gym::class)->with('user','trainingPackage','gym','gym.city');
    }
    public function attendances() {
        return $this->hasManyDeep(Attendance::class,[Gym::class,TrainingSession::class])->with('user','trainingSession','trainingSession.gym','trainingSession.gym.city');
    }
    public function sessions() {
        return $this->hasManyThrough(TrainingSession::class, Gym::class);
    }
}
