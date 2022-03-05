<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class GeneralManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Manager::factory(80)->create();
    }
}
