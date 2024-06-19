<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentFinalScore;
use App\Models\School;
use App\Models\StudentAchievement;
use App\Models\StudentGraduatedSchool;
use App\Models\StudentSchoolChoice;

class ITStaffController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $averageScores = StudentFinalScore::selectRaw('
            AVG(mathematics) as avg_math,
            AVG(science) as avg_science,
            AVG(english) as avg_english,
            AVG(indonesian) as avg_indonesian,
            AVG(civics) as avg_civics,
            AVG(religion) as avg_religion,
            AVG(physical_education) as avg_pe,
            AVG(arts_and_crafts) as avg_arts,
            AVG(local_content) as avg_local
        ')->first();
        
        $schools = School::all();
        
        // Get the 5 latest student achievements
        $studentAchievements = StudentAchievement::orderBy('achievement_year', 'desc')
            ->orderBy('achievement_type')
            ->limit(5)
            ->get()
            ->groupBy('achievement_year');
        
        
        return view('itstaff.dashboard', compact(
            'totalStudents', 'averageScores', 'schools',
            'studentAchievements'
        ));
    }
}
