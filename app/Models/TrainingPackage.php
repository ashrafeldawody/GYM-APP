<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPackage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function admin(){
        return $this->belongsTo(Manager::class,'admin_id');
    }
    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
}
