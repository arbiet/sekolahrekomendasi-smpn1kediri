<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(SchoolsSeeder::class); 
        $this->call(FacilitiesSeeder::class);
        $this->call(ExtracurricularsSeeder::class);
        $this->call(StudentSeeder::class);
    }
}
