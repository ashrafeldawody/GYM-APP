<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GymManagersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gym_id' => 1,
            'manager_id' => 1
        ];
    }
}
