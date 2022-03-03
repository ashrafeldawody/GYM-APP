<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function gyms()
    {
        return $this->hasMany(Gym::class);
    }


    public function purchases() {
        return $this->hasManyThrough(Purchase::class,Gym::class)->with('manager','gym','user','trainingPackage')->get();
    }

}
