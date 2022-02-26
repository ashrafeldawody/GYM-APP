<?php

namespace Database\Seeders;

use App\Models\TrainingPackage;
use Illuminate\Database\Seeder;

class TrainingPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrainingPackage::factory(1)->create();
    }
}
