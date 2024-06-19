<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\StudentAddress;
use App\Models\StudentAchievement;
use App\Models\StudentFinalScore;
use App\Models\StudentSchoolChoice;
use App\Models\StudentGraduatedSchool;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
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
        return view('itstaff.students.edit_school_choices', compact('student', 'schoolChoice'));
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


}
