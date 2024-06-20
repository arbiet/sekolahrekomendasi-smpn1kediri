<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Academic;
use App\Models\Facility;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SchoolController extends Controller
{
    public function showJson($id)
    {
        $school = School::with(['facilities', 'extracurriculars', 'graduatedStudents'])->findOrFail($id);
        
        $school->performance_ratings = $school->getPerformanceRatings();

        return response()->json($school);
    }
    /**
     * Display a listing of the schools.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $schools = School::with(['facilities', 'extracurriculars'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                            ->orWhere('city', 'like', "%$search%");
            })
            ->paginate(10);

        return view('itstaff.schools.index', compact('schools', 'search'));
    }


    /**
     * Show the form for creating a new school.
     */
    public function create()
    {
        return view('itstaff.schools.create');
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
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'passing_rate' => 'nullable|numeric|min:0|max:100',
            'average_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $school = School::create($request->all());

        if ($request->filled('passing_rate') || $request->filled('average_score')) {
            Academic::create([
                'school_target_id' => $school->id,
                'passing_rate' => $request->input('passing_rate'),
                'average_score' => $request->input('average_score'),
            ]);
        }

        Alert::success('Success', 'School created successfully');

        return redirect()->route('schools.index');
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit(School $school)
    {
        return view('itstaff.schools.edit', compact('school'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'accreditation' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'passing_rate' => 'nullable|numeric|min:0|max:100',
            'average_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $school->update($request->all());

        if ($request->filled('passing_rate') || $request->filled('average_score')) {
            $academic = $school->academics->first();
            if ($academic) {
                $academic->update([
                    'passing_rate' => $request->input('passing_rate'),
                    'average_score' => $request->input('average_score'),
                ]);
            } else {
                Academic::create([
                    'school_target_id' => $school->id,
                    'passing_rate' => $request->input('passing_rate'),
                    'average_score' => $request->input('average_score'),
                ]);
            }
        }

        Alert::success('Success', 'School updated successfully');

        return redirect()->route('schools.index');
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy(School $school)
    {
        $school->delete();

        Alert::success('Success', 'School deleted successfully');

        return redirect()->route('schools.index');
    }

    /**
     * Display the specified school.
     */
    public function show(School $school)
    {
        return view('itstaff.schools.show', compact('school'));
    }

    public function attachFacilities(School $school, Request $request)
    {
        $search = $request->input('search');
        $facilities = $school->facilities()
            ->when($search, function ($query, $search) {
                return $query->where('facility_name', 'like', '%' . $search . '%')
                             ->orWhere('facility_description', 'like', '%' . $search . '%');
            })
            ->paginate(10);
    
        return view('itstaff.schools.attach_facilities', compact('school', 'facilities'));
    }
    

    public function storeFacility(School $school, Request $request)
    {
        $request->validate([
            'facility_name' => 'required',
            'facility_description' => 'required',
        ]);

        $school->facilities()->create($request->all());
        Alert::success('Success', 'Facility attached successfully.');

        return redirect()->route('schools.facilities.attach', $school->id);
    }

    public function attachExtracurriculars(School $school, Request $request)
    {
        $search = $request->input('search');
        $extracurriculars = $school->extracurriculars()
            ->when($search, function ($query, $search) {
                return $query->where('activity_name', 'like', '%' . $search . '%')
                             ->orWhere('activity_description', 'like', '%' . $search . '%');
            })
            ->paginate(10);
    
        return view('itstaff.schools.attach_extracurriculars', compact('school', 'extracurriculars'));
    }
    
    public function storeExtracurricular(School $school, Request $request)
    {
        $request->validate([
            'activity_name' => 'required',
            'activity_description' => 'required',
        ]);

        $school->extracurriculars()->create($request->all());
        Alert::success('Success', 'Extracurricular attached successfully.');

        return redirect()->route('schools.extracurriculars.attach', $school->id);
    }
}
