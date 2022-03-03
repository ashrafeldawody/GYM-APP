<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name'=>'coaches,sessions,purchases,attendance,users']);
        Permission::create(['name'=>'gym_managers,gyms,show_gym_data']);
    }
}
