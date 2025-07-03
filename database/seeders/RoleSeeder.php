<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::getAvailableRoles();

        foreach ($roles as $roleName => $roleData) {
            Role::updateOrCreate(
                ['name' => $roleName],
                [
                    'description' => $roleData['description'],
                    'permissions' => $roleData['permissions']
                ]
            );
        }
    }
} 