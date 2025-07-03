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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
<<<<<<< HEAD
            ProcurementSeeder::class,
            LogisticsSeeder::class,
=======
            RoleSeeder::class,
            LogisticsSeeder::class,
            ProcurementSeeder::class,
>>>>>>> 8a6b044cd805dbf3a9cac9ff39fc956a4293c0b9
        ]);
    }
}
