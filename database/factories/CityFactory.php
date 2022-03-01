<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = Manager::all()->random();
        $user->assignRole('city_manager');
        return [
            'name' => $this->faker->unique()->city(),
            'manager_id' => $user->id,
        ];
    }
}
