<?php

namespace Database\Factories;

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
            'training_package_id' => 1,
            'manager_id' => 1,
            'client_id' => 1,
            'gym_id'=>1
        ];
    }
}
