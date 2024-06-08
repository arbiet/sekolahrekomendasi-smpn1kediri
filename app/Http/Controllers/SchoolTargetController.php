<?php

namespace App\Http\Controllers;

use App\Models\TargetSchool;
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
        $schools = TargetSchool::with(['facilities', 'extracurriculars'])
            ->when($search, function ($query, $search) {
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

        $targetSchool = TargetSchool::create($request->all());

        if ($request->filled('passing_rate') || $request->filled('average_score')) {
            Academic::create([
                'school_target_id' => $targetSchool->id,
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
    public function edit(TargetSchool $targetSchool)
    {
        return view('itstaff.schooltargets.edit', compact('targetSchool'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, TargetSchool $targetSchool)
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

        $targetSchool->update($request->all());

        if ($request->filled('passing_rate') || $request->filled('average_score')) {
            $academic = $targetSchool->academics->first();
            if ($academic) {
                $academic->update([
                    'passing_rate' => $request->input('passing_rate'),
                    'average_score' => $request->input('average_score'),
                ]);
            } else {
                Academic::create([
                    'school_target_id' => $targetSchool->id,
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
    public function destroy(TargetSchool $targetSchool)
    {
        $targetSchool->delete();

        Alert::success('Success', 'School deleted successfully');

        return redirect()->route('schooltargets.index');
    }

    /**
     * Display the specified school.
     */
    public function show(TargetSchool $targetSchool)
    {
        return view('itstaff.schooltargets.show', compact('targetSchool'));
    }

    public function attachFacilities(TargetSchool $targetSchool, Request $request)
    {
        $search = $request->input('search');
        $facilities = $targetSchool->facilities()
            ->when($search, function ($query, $search) {
                return $query->where('facility_name', 'like', '%' . $search . '%')
                             ->orWhere('facility_description', 'like', '%' . $search . '%');
            })
            ->paginate(10);
    
        return view('itstaff.schooltargets.attach_facilities', compact('targetSchool', 'facilities'));
    }
    

    public function storeFacility(TargetSchool $targetSchool, Request $request)
    {
        $request->validate([
            'facility_name' => 'required',
            'facility_description' => 'required',
        ]);

        $targetSchool->facilities()->create($request->all());
        Alert::success('Success', 'Facility attached successfully.');

        return redirect()->route('schooltargets.facilities.attach', $targetSchool->id);
    }

    public function attachExtracurriculars(TargetSchool $targetSchool, Request $request)
    {
        $search = $request->input('search');
        $extracurriculars = $targetSchool->extracurriculars()
            ->when($search, function ($query, $search) {
                return $query->where('activity_name', 'like', '%' . $search . '%')
                             ->orWhere('activity_description', 'like', '%' . $search . '%');
            })
            ->paginate(10);
    
        return view('itstaff.schooltargets.attach_extracurriculars', compact('targetSchool', 'extracurriculars'));
    }
    
    public function storeExtracurricular(TargetSchool $targetSchool, Request $request)
    {
        $request->validate([
            'activity_name' => 'required',
            'activity_description' => 'required',
        ]);

        $targetSchool->extracurriculars()->create($request->all());
        Alert::success('Success', 'Extracurricular attached successfully.');

        return redirect()->route('schooltargets.extracurriculars.attach', $targetSchool->id);
    }
}
