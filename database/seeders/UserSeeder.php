<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $adminRole = Role::where('name', 'admin')->where('guard_name', 'api')->first();

        if ($adminRole) {
            $admin->assignRole($adminRole);
        } else {
            $this->command->error('Role `admin` does not exist for guard `api`');
        }

        $users = User::factory(10)->create();

        $userRole = Role::where('name', 'user')->where('guard_name', 'api')->first();

        foreach ($users as $user) {
            if ($userRole) {
                $user->assignRole($userRole);
            } else {
                $this->command->error('Role `user` does not exist for guard `api`');
            }
        }
    }
}
