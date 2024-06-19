<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteria = [
            ['code' => 'C1', 'name_id' => 'Nilai rata rata sekolah', 'name_en' => 'Average school score', 'weight' => 0.45],
            ['code' => 'C2', 'name_id' => 'Nilai terendah yang diterima di sekolah yang dipilih', 'name_en' => 'Lowest score accepted in chosen school', 'weight' => 0.25],
            ['code' => 'C3', 'name_id' => 'Jalur Akademik', 'name_en' => 'Academic path', 'weight' => 0.15],
            ['code' => 'C4', 'name_id' => 'Jalur Non Akademik', 'name_en' => 'Non-academic path', 'weight' => 0.10],
            ['code' => 'C5', 'name_id' => 'Jarak Rumah', 'name_en' => 'Distance from home', 'weight' => 0.05],
        ];

        foreach ($criteria as $criterion) {
            Criteria::create($criterion);
        }
    }
}
