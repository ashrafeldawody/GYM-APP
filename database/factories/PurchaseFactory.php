<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Gym;
use App\Models\TrainingPackage;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'training_package_id' => TrainingPackage::all()->random()->id,
            'manager_id' => Manager::all()->random()->id,
            'gym_id' => Gym::all()->random()->id,
        ];
    }
}
