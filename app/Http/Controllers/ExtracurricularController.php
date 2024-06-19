<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use App\Models\School;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ExtracurricularController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $extracurriculars = Extracurricular::where('activity_name', 'like', '%' . $search . '%')
            ->orWhere('activity_description', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('itstaff.extracurriculars.index', compact('extracurriculars'));
    }

    public function create()
    {
        $schools = School::all();
        return view('itstaff.extracurriculars.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_name' => 'required',
            'activity_description' => 'required',
            'school_target_id' => 'required|exists:schools,id',
        ]);

        Extracurricular::create($request->all());
        Alert::success('Success', 'Activity created successfully.');

        return redirect()->route('extracurriculars.index');
    }

    public function edit(Extracurricular $extracurricular)
    {
        $schools = School::all();
        return view('itstaff.extracurriculars.edit', compact('extracurricular', 'schools'));
    }

    public function update(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'activity_name' => 'required',
            'activity_description' => 'required',
            'school_target_id' => 'required|exists:schools,id',
        ]);

        $extracurricular->update($request->all());
        Alert::success('Success', 'Activity updated successfully.');

        return redirect()->route('extracurriculars.index');
    }

    public function destroy(Extracurricular $extracurricular)
    {
        $extracurricular->delete();
        Alert::success('Success', 'Activity deleted successfully.');

        return redirect()->route('extracurriculars.index');
    }
}
