<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPackage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public function created_by(){
        return $this->belongsTo(User::class,'created_by');
    }
}
