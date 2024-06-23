<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'api']);

        Permission::create(['name' => 'submit website', 'guard_name' => 'api']);
        Permission::create(['name' => 'vote website', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete website', 'guard_name' => 'api']);

        $adminRole->givePermissionTo('submit website', 'vote website', 'delete website');
        $userRole->givePermissionTo('submit website', 'vote website');
    }
}

