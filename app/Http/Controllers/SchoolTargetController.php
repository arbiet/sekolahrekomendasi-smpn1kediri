<?php

namespace App\Http\Controllers;

use App\Models\SchoolTarget;
use App\Models\Academic;
use App\Models\Facility;
use App\Models\Extracurricular;
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
            'passing_rate' => 'nullable|numeric|min:0|max:100',
            'average_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $schoolTarget = SchoolTarget::create($request->all());

        if ($request->filled('passing_rate') || $request->filled('average_score')) {
            Academic::create([
                'school_target_id' => $schoolTarget->id,
                'passing_rate' => $request->input('passing_rate'),
                'average_score' => $request->input('average_score'),
            ]);
        }

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
            'passing_rate' => 'nullable|numeric|min:0|max:100',
            'average_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $schoolTarget->update($request->all());

        if ($request->filled('passing_rate') || $request->filled('average_score')) {
            $academic = $schoolTarget->academics->first();
            if ($academic) {
                $academic->update([
                    'passing_rate' => $request->input('passing_rate'),
                    'average_score' => $request->input('average_score'),
                ]);
            } else {
                Academic::create([
                    'school_target_id' => $schoolTarget->id,
                    'passing_rate' => $request->input('passing_rate'),
                    'average_score' => $request->input('average_score'),
                ]);
            }
        }

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

    public function attachFacilities(SchoolTarget $schoolTarget, Request $request)
    {
        $search = $request->input('search');
        $facilities = $schoolTarget->facilities()
            ->where('facility_name', 'like', '%' . $search . '%')
            ->orWhere('facility_description', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('itstaff.schooltargets.attach_facilities', compact('schoolTarget', 'facilities'));
    }

    public function storeFacility(SchoolTarget $schoolTarget, Request $request)
    {
        $request->validate([
            'facility_name' => 'required',
            'facility_description' => 'required',
        ]);

        $schoolTarget->facilities()->create($request->all());
        Alert::success('Success', 'Facility attached successfully.');

        return redirect()->route('schooltargets.facilities.attach', $schoolTarget->id);
    }

    public function attachExtracurriculars(SchoolTarget $schoolTarget, Request $request)
    {
        $search = $request->input('search');
        $extracurriculars = $schoolTarget->extracurriculars()
            ->where('activity_name', 'like', '%' . $search . '%')
            ->orWhere('activity_description', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('itstaff.schooltargets.attach_extracurriculars', compact('schoolTarget', 'extracurriculars'));
    }

    public function storeExtracurricular(SchoolTarget $schoolTarget, Request $request)
    {
        $request->validate([
            'activity_name' => 'required',
            'activity_description' => 'required',
        ]);

        $schoolTarget->extracurriculars()->create($request->all());
        Alert::success('Success', 'Extracurricular attached successfully.');

        return redirect()->route('schooltargets.extracurriculars.attach', $schoolTarget->id);
    }
}
