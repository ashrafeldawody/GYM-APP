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
        for ($i = 1; $i < 4; $i++) {
            $cityManager = Manager::factory()->create([
                'name' => "City Manager $i",
                'password' => Hash::make('123456'),
                'email' => "manager$i@city$i.com",
            ]);
            $cityManager->assignRole('city_manager');
            City::factory()->create([
                'name' => "City $i",
                'manager_id' => $cityManager->id,
            ]);
        }
    }
}
