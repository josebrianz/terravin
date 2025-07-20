<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin-user';
    protected $description = 'Create or update the admin user (admin@terravin.com, name brian, password Admin@123)';

    public function handle()
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@terravin.com'],
            [
                'name' => 'brian',
                'password' => bcrypt('Admin@123'),
                'role' => 'Admin',
            ]
        );
        $this->info('Admin user created or updated: ' . $user->email);
    }
}
