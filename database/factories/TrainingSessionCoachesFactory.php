<?php

namespace Database\Factories;

use App\Models\Coach;
use App\Models\GymManager;
use App\Models\TrainingSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingSessionCoachesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'training_session_id' => TrainingSession::all()->random()->id,
            'coach_id' => Coach::all()->random()->id,
            'gym_manager_id' => GymManager::all()->random()->id,
        ];
    }
}
