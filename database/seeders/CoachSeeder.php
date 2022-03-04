<?php

namespace Database\Seeders;

use App\Models\Coach;
use App\Models\TrainingSession;
use Illuminate\Database\Seeder;

class CoachSeeder extends Seeder
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
                Coach::factory()->create([
                    'gym_id' => $i,
                ]);
            }
        }
    }
}
