<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateAdminRole extends Command
{
    protected $signature = 'update:admin-role';
    protected $description = 'Update the admin user role to Admin for admin@terravin.com';

    public function handle()
    {
        $user = User::where('email', 'admin@terravin.com')->first();
        if ($user) {
            $user->role = 'Admin';
            $user->save();
            $this->info('Admin user role updated to Admin: ' . $user->email);
        } else {
            $this->error('Admin user not found.');
        }
    }
} 