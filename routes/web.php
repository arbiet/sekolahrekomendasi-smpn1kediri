<?php

use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ITStaffController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\ToSweetAlert;

require __DIR__.'/auth.php';

Route::middleware(['web', ToSweetAlert::class])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::get('admin/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'admin']);
    Route::get('itstaff/dashboard', [ITStaffController::class, 'index'])->middleware(['auth', 'itstaff']);
    Route::get('student/dashboard', [StudentController::class, 'index'])->middleware(['auth', 'student']);

    Route::middleware(['auth', 'itstaff'])->group(function () {
        Route::get('students', [StudentController::class, 'index'])->name('students.index');
        Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('students', [StudentController::class, 'store'])->name('students.store');
        Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

        Route::get('students/{student}/add-choice', [StudentController::class, 'addChoice'])->name('students.addChoice');
        Route::post('students/{student}/store-choice', [StudentController::class, 'storeChoice'])->name('students.storeChoice');

        Route::get('students/{student}/add-graduated-school', [StudentController::class, 'addGraduatedSchool'])->name('students.addGraduatedSchool');
        Route::post('students/{student}/store-graduated-school', [StudentController::class, 'storeGraduatedSchool'])->name('students.storeGraduatedSchool');

        Route::get('schools', [SchoolController::class, 'index'])->name('schools.index');
        Route::get('schools/create', [SchoolController::class, 'create'])->name('schools.create');
        Route::post('schools', [SchoolController::class, 'store'])->name('schools.store');
        Route::get('schools/{school}', [SchoolController::class, 'show'])->name('schools.show');
        Route::get('schools/{school}/edit', [SchoolController::class, 'edit'])->name('schools.edit');
        Route::patch('schools/{school}', [SchoolController::class, 'update'])->name('schools.update');
        Route::delete('schools/{school}', [SchoolController::class, 'destroy'])->name('schools.destroy');

        // Routes for Facilities
        Route::get('facilities', [FacilityController::class, 'index'])->name('facilities.index');
        Route::get('facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
        Route::post('facilities', [FacilityController::class, 'store'])->name('facilities.store');
        Route::get('facilities/{facility}/edit', [FacilityController::class, 'edit'])->name('facilities.edit');
        Route::patch('facilities/{facility}', [FacilityController::class, 'update'])->name('facilities.update');
        Route::delete('facilities/{facility}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

        // Routes for Extracurriculars
        Route::get('extracurriculars', [ExtracurricularController::class, 'index'])->name('extracurriculars.index');
        Route::get('extracurriculars/create', [ExtracurricularController::class, 'create'])->name('extracurriculars.create');
        Route::post('extracurriculars', [ExtracurricularController::class, 'store'])->name('extracurriculars.store');
        Route::get('extracurriculars/{extracurricular}/edit', [ExtracurricularController::class, 'edit'])->name('extracurriculars.edit');
        Route::patch('extracurriculars/{extracurricular}', [ExtracurricularController::class, 'update'])->name('extracurriculars.update');
        Route::delete('extracurriculars/{extracurricular}', [ExtracurricularController::class, 'destroy'])->name('extracurriculars.destroy');

        // Routes for attaching facilities and extracurriculars to school targets
        Route::get('schools/{school}/facilities', [SchoolController::class, 'attachFacilities'])->name('schools.facilities.attach');
        Route::post('schools/{school}/facilities', [SchoolController::class, 'storeFacility'])->name('schools.facilities.store');

        Route::get('schools/{school}/extracurriculars', [SchoolController::class, 'attachExtracurriculars'])->name('schools.extracurriculars.attach');
        Route::post('schools/{school}/extracurriculars', [SchoolController::class, 'storeExtracurricular'])->name('schools.extracurriculars.store');
    });
});
