<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitiesSeeder extends Seeder
{
    public function run()
    {
        $facilities = [
            'Library', 'Laboratory', 'Sports Hall', 'Canteen', 'Auditorium',
            'Computer Room', 'Music Room', 'Art Room', 'Science Lab', 'Medical Room'
        ];

        $schools = DB::table('target_schools')->get();

        foreach ($schools as $school) {
            foreach ($facilities as $facility) {
                DB::table('facilities')->insert([
                    'target_school_id' => $school->id,
                    'facility_name' => $facility,
                    'facility_description' => $facility . ' description',
                ]);
            }
        }
    }
}
