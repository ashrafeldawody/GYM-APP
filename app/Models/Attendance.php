<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email');
    }

    public function trainingSession()
    {
        return $this->belongsTo(TrainingSession::class);
    }

    public static function countByGender($gender)
    {
        if (auth()->user()->hasRole('admin')) {
            return Attendance::whereHas('user', function ($query) use ($gender) {
                return $query->where('gender', $gender);
            })->count();
        }

        if (auth()->user()->hasRole('gym_manager')) {
            $mySessionIDs = auth()->user()->gym->attendances->pluck('training_session_id')->toArray();
        } else {
            $mySessionIDs = auth()->user()->city->attendances->pluck('training_session_id')->toArray();;
        }

        return Attendance::whereIn('training_session_id',$mySessionIDs)->whereHas('user', function ($query) use ($gender) {
            return $query->where('gender', $gender);
        })->count();
    }
}
