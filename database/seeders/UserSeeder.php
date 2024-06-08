<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'usertype' => 'admin',
            'password' => Hash::make('password')
        ]);

        // Create IT staff user
        User::create([
            'name' => 'IT Staff User',
            'email' => 'itstaff@example.com',
            'usertype' => 'itstaff',
            'password' => Hash::make('password')
        ]);

        // Create 200 student users
        User::factory()->count(200)->create();
    }
}
