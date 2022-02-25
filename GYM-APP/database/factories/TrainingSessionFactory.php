<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name(),
            'starts_at' => $this->faker->dateTimeThisMonth(),
            'finishes_at' => $this->faker->dateTimeThisMonth(),
            'gym_id' => 1,
            'created_by' => 1
        ];
    }
}
