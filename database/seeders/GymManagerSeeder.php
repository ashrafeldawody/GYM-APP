<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class GymManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0;$i< 10;$i++){
            $user = User::factory()->hasGyms(1)->create();
            $user->assignRole('gym_manager');
        }

    }
}
