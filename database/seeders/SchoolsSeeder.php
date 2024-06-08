<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolsSeeder extends Seeder
{
    public function run()
    {
        $schools = [
            ['name' => 'SMA Negeri 1 Kota Kediri', 'address' => 'Jl. Veteran No.1', 'city' => 'Kediri', 'accreditation' => 'A', 'website' => 'http://sman1kediri.sch.id'],
            ['name' => 'SMA Negeri 2 Kota Kediri', 'address' => 'Jl. Diponegoro No.2', 'city' => 'Kediri', 'accreditation' => 'A', 'website' => 'http://sman2kediri.sch.id'],
            ['name' => 'SMA Negeri 3 Kota Kediri', 'address' => 'Jl. Pahlawan Kusuma Bangsa No.3', 'city' => 'Kediri', 'accreditation' => 'A', 'website' => 'http://sman3kediri.sch.id'],
            ['name' => 'SMA Negeri 4 Kota Kediri', 'address' => 'Jl. Imam Bonjol No.4', 'city' => 'Kediri', 'accreditation' => 'A', 'website' => 'http://sman4kediri.sch.id'],
            ['name' => 'SMA Negeri 5 Kota Kediri', 'address' => 'Jl. Hayam Wuruk No.5', 'city' => 'Kediri', 'accreditation' => 'A', 'website' => 'http://sman5kediri.sch.id'],
            ['name' => 'SMA Negeri 6 Kota Kediri', 'address' => 'Jl. Kiai Mojo No.6', 'city' => 'Kediri', 'accreditation' => 'A', 'website' => 'http://sman6kediri.sch.id'],
            ['name' => 'SMA Negeri 7 Kota Kediri', 'address' => 'Jl. Dhoho No.7', 'city' => 'Kediri', 'accreditation' => 'A', 'website' => 'http://sman7kediri.sch.id'],
            ['name' => 'SMA Negeri 8 Kota Kediri', 'address' => 'Jl. Patimura No.8', 'city' => 'Kediri', 'accreditation' => 'A', 'website' => 'http://sman8kediri.sch.id'],
        ];

        DB::table('schools')->insert($schools);
    }
}
