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

        User::firstOrCreate(
            ['email' => 'admin@rosacare.sy'],
            [
                'name' => 'Admin RosaCare',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            SettingSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            WelcomeSeeder::class,
            WelcomeDetailSeeder::class,
        ]);
    }
}
