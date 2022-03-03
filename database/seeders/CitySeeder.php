<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 0; $i < 20; $i++) {
            $manager = Manager::factory()->create();
            $manager->assignRole('city_manager');
            City::factory()->create([
                'manager_id' => $manager->id,
            ]);

        }
    }
}
