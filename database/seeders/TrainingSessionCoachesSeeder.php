<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Coach;
use App\Models\GymsManagers;
use App\Models\Manager;
use App\Models\TrainingSession;
use App\Models\TrainingSessionCoach;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TrainingSessionCoachesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 144; $i++) {
            $trainingSessionId = TrainingSession::all()->random()->id;
            $coachId = Coach::all()->random()->id;
            $session = TrainingSessionCoach::where('training_session_id', $trainingSessionId)->where('coach_id', $coachId)->get();
            if ($session->count() == 0) {
                TrainingSessionCoach::create([
                    'training_session_id' => $trainingSessionId,
                    'coach_id' => $coachId,
                    'manager_id' =>  Manager::role('gym_manager')->get()->random()->id,
                ]);
            }
        }
    }
}
