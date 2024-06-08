<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\School;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $facilities = Facility::where('facility_name', 'like', '%' . $search . '%')
            ->orWhere('facility_description', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('itstaff.facilities.index', compact('facilities'));
    }

    public function create()
    {
        $schools = School::all();
        return view('itstaff.facilities.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_name' => 'required',
            'facility_description' => 'required',
            'school_target_id' => 'required|exists:target_schools,id',
        ]);

        Facility::create($request->all());
        Alert::success('Success', 'Facility created successfully.');

        return redirect()->route('facilities.index');
    }

    public function edit(Facility $facility)
    {
        $schools = School::all();
        return view('itstaff.facilities.edit', compact('facility', 'schools'));
    }

    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'facility_name' => 'required',
            'facility_description' => 'required',
            'school_target_id' => 'required|exists:target_schools,id',
        ]);

        $facility->update($request->all());
        Alert::success('Success', 'Facility updated successfully.');

        return redirect()->route('facilities.index');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        Alert::success('Success', 'Facility deleted successfully.');

        return redirect()->route('facilities.index');
    }
}
