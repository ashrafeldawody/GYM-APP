<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Gym;
use App\Models\TrainingPackage;
use App\Models\User;
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
            'training_package_id' => TrainingPackage::all()->random()->id,
            'client_id' => Client::all()->random()->id,
        ];
    }
}
