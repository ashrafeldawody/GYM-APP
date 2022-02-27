<?php

namespace Database\Seeders;

use App\Models\TrainingSession;
use Database\Factories\TrainingSessionCoachesFactory;
use Illuminate\Database\Seeder;

class TrainingSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrainingSession::factory(10)->hasCoaches(5)->hasAttendance(1)->create();
    }
}
