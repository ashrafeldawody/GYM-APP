<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopePaid($query)
    {
        return $query->where('published', true);
    }

    protected static function booted()
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->where('paid', 1);
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class)->select('id','name','email');
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function gym() {
        return $this->belongsTo(Gym::class);
    }
}
