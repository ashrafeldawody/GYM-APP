<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingPackageFactory extends Factory
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
            'session_count' => $this->faker->numberBetween(5,100),
            'price' => $this->faker->numberBetween(200000,1000000),
            'created_by' => 1

        ];
    }
}
