<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\GymManager;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class GymManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GymManager::factory(500)->create();
    }
}
