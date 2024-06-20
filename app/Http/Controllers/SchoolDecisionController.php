<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Criteria;
use App\Models\Student;

class SchoolDecisionController extends Controller
{
    public function calculateSAW()
    {
        // Fetch data from the database
        $schools = School::all();
        $criteria = Criteria::all();
        $students = Student::all();

        // Initialize arrays to hold criteria values
        $C1 = [];
        $C2 = [];
        $C3 = [];
        $C4 = [];
        $C5 = [];

        // Initialize array to hold performance ratings and preference values
        $performanceRatings = [];
        $preferenceValues = [];

        // Calculate criteria values and performance ratings
        foreach ($schools as $school) {
            $C1[] = $this->calculateC1($school);
            $C2[] = $this->calculateC2($school);
            $C3[] = $this->calculateC3($school);
            $C4[] = $this->calculateC4($school);
            $C5[] = $this->calculateC5($school);

            $performanceRatings[] = $school->getPerformanceRatings();
        }

        // Calculate preference values (Vi) and sort schools by Vi
        foreach ($performanceRatings as $index => $ratings) {
            $Vi = round(array_sum($ratings), 2);
            $schools[$index]->preference_value = $Vi;
            $preferenceValues[] = $Vi;
        }

        // Sort schools by preference_value in descending order
        $schoolsSorted = $schools->sortByDesc('preference_value')->values();

        // Combine results (for now, we'll just pass them to the view)
        return view('itstaff.saw.calculate-saw', compact('schools', 'C1', 'C2', 'C3', 'C4', 'C5', 'performanceRatings', 'preferenceValues', 'schoolsSorted', 'students'));
    }

    private function calculateC1($school)
    {
        return round($school->average_school_score, 2);
    }

    private function calculateC2($school)
    {
        return round($school->lowest_accepted_score, 2);
    }

    private function calculateC3($school)
    {
        return round($school->academic_path_percentage, 2);
    }

    private function calculateC4($school)
    {
        return round($school->non_academic_path_percentage, 2);
    }

    private function calculateC5($school)
    {
        return round($school->average_distance, 2);
    }

    public function getStudentDetails($id)
    {
        $student = Student::with(['address', 'achievements', 'finalScore', 'schoolChoice', 'graduatedSchool'])->findOrFail($id);
        return response()->json($student);
    }

    public function checkProbability(Request $request)
    {
        $studentId = $request->input('student');
        $student = Student::with(['address', 'achievements', 'finalScore', 'schoolChoice'])->findOrFail($studentId);
    
        // Initialize weights
        $weights = [
            'C1' => 0.45,
            'C2' => 0.25,
            'C3' => 0.15,
            'C4' => 0.10,
            'C5' => 0.05
        ];
    
        // Initialize probabilities for each school choice
        $probabilities = [
            'first_choice' => 0,
            'second_choice' => 0,
            'third_choice' => 0
        ];
    
       // Get student's average score
        $scores = [
            $student->finalScore->mathematics,
            $student->finalScore->science,
            $student->finalScore->english,
            $student->finalScore->indonesian,
            $student->finalScore->civics,
            $student->finalScore->religion,
            $student->finalScore->physical_education,
            $student->finalScore->arts_and_crafts,
            $student->finalScore->local_content,
        ];

        $totalScore = array_sum($scores);
        $numberOfSubjects = count($scores);
        $averageScore = $totalScore / $numberOfSubjects;

        // Get sorted schools by preference value
        $schoolsSorted = School::orderByDesc('preference_value')->get();
    
        foreach (['first_choice', 'second_choice', 'third_choice'] as $choice) {
            $schoolName = $student->schoolChoice->$choice;
            $school = School::where('name', $schoolName)->first();
    
            if ($school) {
                $C1 = $averageScore > $school->average_school_score ? 1 : 0;
                $C2 = $averageScore > $school->lowest_accepted_score ? 1 : 0;
                $C3 = $student->achievements->count() > 0 ? 1 : 0;
                $C4 = $student->achievements->count() == 0 ? 1 : 0;
                $C5 = $student->address->distance_to_school <= $school->average_distance ? 1 : 0;
    
                $baseProbability = ($C1 * $weights['C1']) + ($C2 * $weights['C2']) + ($C3 * $weights['C3']) + ($C4 * $weights['C4']) + ($C5 * $weights['C5']);
    
                // Adjust probability based on school ranking
                $rank = $schoolsSorted->search(function ($sortedSchool) use ($school) {
                    return $sortedSchool->id == $school->id;
                });
    
                $rankAdjustment = 0.10 - ($rank * 0.02);
                $probabilities[$choice] = max(0, $baseProbability + $rankAdjustment);
            }
        }
    
        return response()->json($probabilities);
    }
    

    public function indexProbability()
    {
        $students = Student::with(['schoolChoice'])->where('status', 'active')->paginate(10);
    
        foreach ($students as $student) {
            $response = $this->checkProbability(new Request(['student' => $student->id]));
            $student->probabilities = json_decode($response->getContent(), true);
        }
    
        return view('itstaff.saw.check-probability', compact('students'));
    }
    


}
