<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\GymManager;
use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GymManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 12; $i++) {
            for ($j = 1; $j <= 4; $j++) {
                // 1- General
                $gymManager = Manager::factory()->create([
                    'name' => "Gym Manager $i $j",
                    'password' => Hash::make('123456'),
                    'email' => "manager$i@gym$j.com",
                ]);
                // 2- to assign role to gym manager we have to create GymManage Object
                $gymManager->assignRole('gym_manager');
                GymManager::create([
                    'manager_id' => $gymManager->id,
                    'gym_id' => $i,
                ]);
            }
        }
    }
}
