<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\StudentSchoolChoice;
use App\Models\StudentGraduatedSchool;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
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

        $students = Student::with('address')
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
    public function edit(User $student)
    {
        return view('itstaff.students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, User $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
        ]);

        $student->update($request->all());

        Alert::success('Success', 'Student updated successfully');

        return redirect()->route('students.index');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(User $student)
    {
        $student->delete();

        Alert::success('Success', 'Student deleted successfully');

        return redirect()->route('students.index');
    }

    /**
     * Display the specified student.
     */
    public function show(User $student)
    {
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
}
