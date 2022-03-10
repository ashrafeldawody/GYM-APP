<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Gym;
use App\Models\GymsManagers;
use App\Models\TrainingPackage;
use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = Manager::factory()->create([
            'name' => 'System Administrator',
            'password' => Hash::make('123456'),
            'email' => 'admin@admin.com',
        ]);
        $manager->assignRole('admin');
        for($i = 0;$i<10;$i++){
            TrainingPackage::factory()->create([
                'admin_id' => $manager->id
            ]);
        }
    }
}
