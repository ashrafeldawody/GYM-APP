<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;

class GymFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->streetName(),
            'cover_image' => $this->faker->imageUrl(),
            'city_id' => City::all()->random()->id,
            'creator_id' => Manager::role(['admin', 'city_manager'])->get()->random()->id,
        ];
    }
}
