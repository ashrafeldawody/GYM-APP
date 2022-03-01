<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;

class CityManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0;$i < 10;$i++) {
            $cityId = City::all()->random()->id;
            $user = User::factory()->hasCity($cityId)->create();
            $user->assignRole('city_manager');
        }
    }
}
