<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Gym;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gym::factory(12)->create();
    }
}
