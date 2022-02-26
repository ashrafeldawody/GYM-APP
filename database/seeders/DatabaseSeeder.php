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
            ClientSeeder::class,
            CitySeeder::class,
            GymSeeder::class,
            CoachSeeder::class,
            TrainingPackageSeeder::class,
            TrainingSessionSeeder::class,
            PurchaseSeeder::class,
        ]);

    }
}
