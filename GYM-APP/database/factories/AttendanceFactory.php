<?php

namespace Database\Factories;

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
            'training_session_id' => 1,
            'client_id' => 1,
            'attendance_time' => time(),
            'attendance_date' => date(),

        ];
    }
}
