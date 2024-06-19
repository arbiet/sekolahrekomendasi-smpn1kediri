<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentAchievement;
use App\Models\StudentSchoolChoice;
use App\Models\StudentAddress;
use App\Models\Criteria;

class SchoolDecisionController extends Controller
{
    public function calculateSAW(Request $request)
    {
        $criteria = Criteria::all();
        $studentAchievements = StudentAchievement::all();
        $studentSchoolChoices = StudentSchoolChoice::all();
        $studentAddresses = StudentAddress::all();

        // Inisialisasi hasil perhitungan
        $results = [];

        // Normalisasi data
        foreach ($studentAchievements as $achievement) {
            $normalized = [];
            foreach ($criteria as $criterion) {
                switch ($criterion->name) {
                    case 'C1':
                        $value = $achievement->average_score;
                        $max = StudentAchievement::max('average_score');
                        break;
                    case 'C2':
                        $value = $achievement->lowest_score;
                        $max = StudentAchievement::max('lowest_score');
                        break;
                    case 'C3':
                        $value = $achievement->academic_route ? 1 : 0;
                        $max = 1;
                        break;
                    case 'C4':
                        $value = $achievement->non_academic_route ? 1 : 0;
                        $max = 1;
                        break;
                    case 'C5':
                        $address = $studentAddresses->firstWhere('student_id', $achievement->student_id);
                        $value = $address->distance;
                        $max = StudentAddress::max('distance');
                        break;
                    default:
                        $value = 0;
                        $max = 1;
                        break;
                }
                $normalized[$criterion->name] = $value / $max;
            }
            $results[$achievement->student_id] = $normalized;
        }

        // Menghitung nilai akhir
        foreach ($results as $student_id => $normalized) {
            $finalScore = 0;
            foreach ($criteria as $criterion) {
                $finalScore += $normalized[$criterion->name] * $criterion->weight;
            }
            $results[$student_id]['final_score'] = $finalScore;
        }

        // Mengurutkan hasil berdasarkan nilai akhir
        usort($results, function($a, $b) {
            return $b['final_score'] <=> $a['final_score'];
        });

        // Mengembalikan hasil dalam bentuk JSON atau ke view
        return response()->json($results);
    }
}
