<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Gym;
use App\Models\TrainingPackage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GymManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => User::all()->random()->id,
            'gym_id' => Gym::all()->random()->id,
        ];
    }
}
