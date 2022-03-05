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
            PermissionSeeder::class,
            RolesSeeder::class,
            AdminSeeder::class,
            CitySeeder::class,
            GymSeeder::class,
            GeneralManagerSeeder::class,
            GymManagerSeeder::class,
            CoachSeeder::class,
            UserSeeder::class,
            TrainingSessionSeeder::class,
            PurchaseSeeder::class,
            TrainingSessionCoachesSeeder::class,
            AttendanceSeeder::class,
        ]);

    }
}
