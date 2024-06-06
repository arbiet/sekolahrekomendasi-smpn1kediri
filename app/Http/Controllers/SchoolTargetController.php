<?php

namespace App\Http\Controllers;

use App\Models\SchoolTarget;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SchoolTargetController extends Controller
{
    /**
     * Display a listing of the schools.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $schools = SchoolTarget::when($search, function ($query, $search) {
                            return $query->where('name', 'like', "%$search%")
                                         ->orWhere('city', 'like', "%$search%");
                        })
                        ->paginate(10);
        return view('itstaff.schooltargets.index', compact('schools', 'search'));
    }

    /**
     * Show the form for creating a new school.
     */
    public function create()
    {
        return view('itstaff.schooltargets.create');
    }

    /**
     * Store a newly created school in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'accreditation' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',
        ]);

        SchoolTarget::create($request->all());

        Alert::success('Success', 'School created successfully');

        return redirect()->route('schooltargets.index');
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit(SchoolTarget $schoolTarget)
    {
        return view('itstaff.schooltargets.edit', compact('schoolTarget'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, SchoolTarget $schoolTarget)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'accreditation' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',
        ]);

        $schoolTarget->update($request->all());

        Alert::success('Success', 'School updated successfully');

        return redirect()->route('schooltargets.index');
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy(SchoolTarget $schoolTarget)
    {
        $schoolTarget->delete();

        Alert::success('Success', 'School deleted successfully');

        return redirect()->route('schooltargets.index');
    }

    /**
     * Display the specified school.
     */
    public function show(SchoolTarget $schoolTarget)
    {
        return view('itstaff.schooltargets.show', compact('schoolTarget'));
    }
}
