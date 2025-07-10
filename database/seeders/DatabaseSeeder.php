<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'jmurungi2004@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('Jerry@2004'),
                'role' => 'Admin',
            ]
        );

        $this->call([
            RoleSeeder::class,
            LogisticsSeeder::class,
            ProcurementSeeder::class,
            WineSeeder::class,
        ]);
    }
}
