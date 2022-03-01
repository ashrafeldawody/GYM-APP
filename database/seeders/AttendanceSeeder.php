<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use App\Models\TrainingSession;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 100; $i++) {
            $userId = User::all()->random()->id;
            $trainingSessionId = TrainingSession::all()->random()->id;
            $attendance = Attendance::where('user_id', $userId)->where('training_session_id', $trainingSessionId)->get();
            if ($attendance->count() == 0) {
                Attendance::create([
                    'user_id' => $userId,
                    'training_session_id' => $trainingSessionId,
                    'attendance_datetime' => now(),
                ]);
            }
        }
    }
}
