<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);

        $gymManagerRole = Role::create(['name' => 'gym_manager']);
        $gymManagerRole->givePermissionTo('coaches,sessions,purchases,attendance,users');

        $cityManagerRole = Role::create(['name' => 'city_manager']);
        $cityManagerRole->givePermissionTo('coaches,sessions,purchases,attendance,users', 'gym_managers,gyms,show_gym_data');
    }
}
