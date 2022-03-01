<?php

namespace Database\Seeders;

use App\Models\TrainingSession;
use Database\Factories\TrainingSessionCoachFactory;
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
        TrainingSession::factory(20)->create();
    }
}
