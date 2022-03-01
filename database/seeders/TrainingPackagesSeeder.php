<?php

namespace Database\Seeders;

use App\Models\TrainingPackage;
use App\Models\User;
use Illuminate\Database\Seeder;

class TrainingPackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrainingPackage::factory(10)->hasUser(User::all()->random()->id)->create();
    }
}
