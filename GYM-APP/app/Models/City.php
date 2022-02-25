<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public function manager(){
        return $this->hasOne(User::class, 'id', 'manager_id');
    }
}
