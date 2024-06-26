<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\School;
use App\Models\StudentAddress;
use App\Models\StudentAchievement;
use App\Models\StudentFinalScore;
use App\Models\StudentSchoolChoice;
use App\Models\StudentGraduatedSchool;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class StudentController extends Controller
{

    public function chooseSchools()
    {
        $studentId = Auth::user()->student->id;
        $schools = School::all();
        $student = Student::with(['address', 'achievements', 'finalScore', 'schoolChoice'])->findOrFail($studentId);
        return view('student.choose_schools', compact('schools', 'student'));
    }
    
    public function storeChoice(Request $request)
    {
        $request->validate([
            'first_choice' => 'required|string|max:255',
            'second_choice' => 'nullable|string|max:255',
            'third_choice' => 'nullable|string|max:255',
        ]);
    
        $student = Auth::user()->student;
        $student->schoolChoice()->updateOrCreate(
            ['student_id' => $student->id],
            $request->only('first_choice', 'second_choice', 'third_choice')
        );
    
        return redirect()->route('student.dashboard.index')->with('success', 'School choices updated successfully');
    }
    

    public function studentindex()
    {
        $studentId = Auth::user()->student->id;
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

        // Use dd() to display the results before returning the view
        // dd(compact('student', 'probabilities'));
        
        return view('student.dashboard', compact('student', 'probabilities'));
    }


    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');
        $currentYear = now()->year;
    
        $students = Student::with('address', 'achievements', 'finalScore', 'schoolChoice', 'graduatedSchool')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->when($statusFilter, function ($query, $statusFilter) {
                return $query->where('status', $statusFilter);
            })
            ->paginate(10);
    
        return view('itstaff.students.index', compact('students', 'search', 'statusFilter', 'currentYear'));
    }
    

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('itstaff.students.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'required|string|max:10',
            'batch_year' => 'required|integer',
            'class' => 'required|string|max:10',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'nisn' => 'required|string|max:20',
            'phone_number' => 'required|string|max:20',
            'status' => 'required|string|max:10',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'usertype' => 'student', // Mengasumsikan usertype adalah 'student'
        ]);

        // Buat data siswa baru yang terhubung dengan user
        Student::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'gender' => $request->gender,
            'batch_year' => $request->batch_year,
            'class' => $request->class,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'nisn' => $request->nisn,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        // Tampilkan pesan sukses
        Alert::success('Success', 'Student created successfully');

        // Redirect ke halaman index siswa
        return redirect()->route('students.index');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        return view('itstaff.students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
            'gender' => 'required|string|max:10',
            'batch_year' => 'required|integer',
            'class' => 'required|string|max:10',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'nisn' => 'required|string|max:20',
            'phone_number' => 'required|string|max:20',
            'status' => 'required|string|max:10',
        ]);

        $student->update($request->all());

        Alert::success('Success', 'Student updated successfully');

        return redirect()->route('students.index');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        Alert::success('Success', 'Student deleted successfully');

        return redirect()->route('students.index');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load('address', 'achievements', 'finalScore', 'schoolChoice', 'graduatedSchool');
        return view('itstaff.students.show', compact('student'));
    }

    public function addChoice(Student $student)
    {
        return view('itstaff.students.add_choice', compact('student'));
    }

    public function addGraduatedSchool(Student $student)
    {
        return view('itstaff.students.add_graduated_school', compact('student'));
    }

    public function editAddress(Student $student)
    {
        $address = $student->address;
        return view('itstaff.students.edit_address', compact('student', 'address'));
    }

    public function editAchievements(Student $student)
    {
        $achievements = $student->achievements;
        return view('itstaff.students.edit_achievements', compact('student', 'achievements'));
    }

    public function editFinalScores(Student $student)
    {
        $finalScore = $student->finalScore ?? new StudentFinalScore(); // Mengambil objek tunggal atau inisialisasi dengan objek kosong
        return view('itstaff.students.edit_final_scores', compact('student', 'finalScore'));
    }

    public function editSchoolChoice(Student $student)
    {
        $schoolChoice = $student->schoolChoice;
        $schools = School::all(); // Assuming you have a School model to fetch school names
        return view('itstaff.students.edit_school_choices', compact('student', 'schoolChoice', 'schools'));
    }
    

    public function editGraduatedSchool(Student $student)
    {
        $graduatedSchool = $student->graduatedSchool;
        return view('itstaff.students.edit_graduated_school', compact('student', 'graduatedSchool'));
    }

    public function updateAddress(Request $request, Student $student)
    {
        $request->validate([
            'street' => 'required|string|max:255',
            'subdistrict' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'location_type' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $student->address()->updateOrCreate(
            ['student_id' => $student->id],
            $request->only([
                'street',
                'subdistrict',
                'district',
                'city',
                'province',
                'postal_code',
                'location_type',
                'latitude',
                'longitude'
            ])
        );

        Alert::success('Success', 'Address updated successfully');
        return redirect()->route('students.show', $student->id);
    }


    public function updateAchievements(Request $request, Student $student)
    {
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'achievement_type_') !== false) {
                $id = explode('_', $key)[2];
                StudentAchievement::where('id', $id)->update([
                    'achievement_type' => $value,
                    'activity_name' => $request->input('activity_name_' . $id),
                    'level' => $request->input('level_' . $id),
                    'achievement' => $request->input('achievement_' . $id),
                    'achievement_year' => $request->input('achievement_year_' . $id),
                ]);
            }
        }

        Alert::success('Success', 'Achievements updated successfully');
        return redirect()->route('students.show', $student->id);
    }

    public function updateFinalScores(Request $request, Student $student)
    {
        $data = $request->validate([
            'mathematics' => 'required|numeric|min:0|max:100',
            'science' => 'required|numeric|min:0|max:100',
            'english' => 'required|numeric|min:0|max:100',
            'indonesian' => 'required|numeric|min:0|max:100',
            'civics' => 'required|numeric|min:0|max:100',
            'religion' => 'required|numeric|min:0|max:100',
            'physical_education' => 'required|numeric|min:0|max:100',
            'arts_and_crafts' => 'required|numeric|min:0|max:100',
            'local_content' => 'required|numeric|min:0|max:100',
        ]);
    
        $student->finalScore()->updateOrCreate(['student_id' => $student->id], $data);
    
        Alert::success('Success', 'Final scores updated successfully');
        return redirect()->route('students.show', $student->id);
    }

    public function updateSchoolChoice(Request $request, Student $student)
    {
        $data = $request->validate([
            'first_choice' => 'required|string|max:255',
            'second_choice' => 'nullable|string|max:255',
            'third_choice' => 'nullable|string|max:255',
        ]);
    
        $student->schoolChoice()->updateOrCreate(
            ['student_id' => $student->id],
            $data
        );
    
        Alert::success('Success', 'School choice updated successfully');
        return redirect()->route('students.show', $student->id);
    }

    public function updateGraduatedSchool(Request $request, Student $student)
    {
        $request->validate([
            'selected_school' => 'required|string|max:255',
            'accepted_school' => 'required|string|max:255',
        ]);

        $student->graduatedSchool()->updateOrCreate(
            ['student_id' => $student->id],
            $request->only('selected_school', 'accepted_school')
        );

        Alert::success('Success', 'Graduated school information updated successfully');
        return redirect()->route('students.show', $student->id);
    }

    public function getSchoolData($schoolId)
    {
        $school = School::with(['facilities', 'extracurriculars', 'graduatedStudents', 'performanceRatings'])
            ->findOrFail($schoolId);

        return response()->json($school);
    }

}
