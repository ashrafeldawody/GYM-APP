<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\TrainingSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'training_session_id' => TrainingSession::factory(),
            'client_id' => Client::factory(),
            'datetime' => now(),
        ];
    }
}
