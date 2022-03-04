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
        for($i = 1; $i <= 12; $i++) {
            for ($j = 1; $j <= 12; $j++) {
                TrainingSession::factory()->create([
                    'gym_id' => $i,
                ]);
            }
        }
    }
}
