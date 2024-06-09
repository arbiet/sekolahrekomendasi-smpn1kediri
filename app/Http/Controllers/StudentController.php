<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $students = Student::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->when($statusFilter, function ($query, $statusFilter) {
                return $query->where('status', $statusFilter);
            })
            ->paginate(10);

        return view('itstaff.students.index', compact('students', 'search', 'statusFilter'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'usertype' => 'student', // assuming usertype is required and should be 'student'
        ]);

        Alert::success('Success', 'Student created successfully');

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
}
