<?php

namespace Database\Factories;

use App\Models\User;
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
            'sessions_number' => $this->faker->numberBetween(5,100),
            'price' => $this->faker->numberBetween(100,500)*100,
            'admin_id' => User::all()->random()->id,
        ];
    }
}
