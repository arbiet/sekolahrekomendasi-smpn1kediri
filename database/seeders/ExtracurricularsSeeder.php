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

        $schools = DB::table('schools')->get(); // Mengubah target_schools menjadi schools

        foreach ($schools as $school) {
            foreach ($extracurriculars as $activity) {
                DB::table('extracurriculars')->insert([
                    'school_id' => $school->id, // Mengubah target_school_id menjadi school_id
                    'activity_name' => $activity,
                    'activity_description' => $activity . ' description',
                ]);
            }
        }
    }
}
