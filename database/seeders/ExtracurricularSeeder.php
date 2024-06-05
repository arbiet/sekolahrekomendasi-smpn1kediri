<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExtracurricularsSeeder extends Seeder
{
    public function run()
    {
        $extracurriculars = [
            'Basketball', 'Soccer', 'Volleyball', 'Music Club', 'Dance Club',
            'Drama Club', 'Science Club', 'Math Club', 'Debate Club', 'Photography Club'
        ];

        $schools = DB::table('target_schools')->get();

        foreach ($schools as $school) {
            foreach ($extracurriculars as $activity) {
                DB::table('extracurriculars')->insert([
                    'target_school_id' => $school->id,
                    'activity_name' => $activity,
                    'activity_description' => $activity . ' description',
                ]);
            }
        }
    }
}
