<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\GymManager;
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
//        for ($i = 0;$i< 10;$i++){
//            $gym = Gym::factory()->create();
//            $user = User::factory()->create([
//                'gym_id' => $gym->id
//            ]);
//            $user->assignRole('gym_manager');
//        }
        for ($i = 0; $i < 10; $i++) {
            $gymManager = GymManager::factory()->create();
            $gymManager->assignRole('gym_manager');
        }

    }
}
