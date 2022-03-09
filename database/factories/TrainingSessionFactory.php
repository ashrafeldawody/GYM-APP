<?php

namespace Database\Factories;

use App\Models\Gym;
use App\Models\Manager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = Carbon::createFromTimeStamp($this->faker->dateTimeBetween('-1 week', '+1 week')->getTimestamp());

        return [
            'name' => $this->faker->unique()->name(),
            'starts_at' => $startDate->toDateTimeString(),
            'finishes_at' => $startDate->addHours( $this->faker->numberBetween( 1, 4 ) ),
        ];
    }
}
