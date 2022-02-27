<?php

namespace Database\Seeders;

use App\Models\TrainingPackage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RolesSeeder::class,
            AdminSeeder::class,
            CityManagerSeeder::class,
            GymManagerSeeder::class,
            ClientSeeder::class,
            CoachSeeder::class,
            TrainingSessionSeeder::class,
            PurchaseSeeder::class,
        ]);

    }
}
