<?php

namespace Database\Seeders;

use App\Models\Coach;
use App\Models\GymManager;
use App\Models\TrainingSession;
use Illuminate\Database\Seeder;

class TrainingSessionCoachesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrainingSession::factory(10)->hasCoaches(Coach::all()->random()->id)->hasGymManager(GymManager::all()->random()->id)->hasTrainingSession(TrainingSession::all()->random()->id)->create();
    }
}
