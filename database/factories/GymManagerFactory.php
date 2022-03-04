<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Gym;
use App\Models\TrainingPackage;
use App\Models\Manager;
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

        $manager = Manager::factory()->create();
        $manager->assignRole('gym_manager');
        return [
            'manager_id' => $manager->id,
            'gym_id' => Gym::all()->random()->id,
        ];
    }
}
