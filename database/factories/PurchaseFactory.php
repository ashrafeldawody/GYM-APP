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
        $trainingPackage = TrainingPackage::all()->random();
        return [
            'user_id' => User::all()->random()->id,
            'training_package_id' => $trainingPackage->id,
            'manager_id' => Manager::all()->random()->id,
            'gym_id' => Gym::all()->random()->id,
            'amount_paid' => $trainingPackage->price,
            'sessions_number' => $trainingPackage->sessions_number,
            'is_paid' => 1,
            'created_at'=>$this->faker->dateTimeBetween("-1 year", now()),
        ];
    }
}
