<?php

use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\SchoolTargetController;
use App\Http\Controllers\ITStaffController;
use App\Http\Controllers\StudentManagementController;
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
        Route::get('students', [StudentManagementController::class, 'index'])->name('students.index');
        Route::get('students/create', [StudentManagementController::class, 'create'])->name('students.create');
        Route::post('students', [StudentManagementController::class, 'store'])->name('students.store');
        Route::get('students/{student}', [StudentManagementController::class, 'show'])->name('students.show');
        Route::get('students/{student}/edit', [StudentManagementController::class, 'edit'])->name('students.edit');
        Route::patch('students/{student}', [StudentManagementController::class, 'update'])->name('students.update');
        Route::delete('students/{student}', [StudentManagementController::class, 'destroy'])->name('students.destroy');

        Route::get('schooltargets', [SchoolTargetController::class, 'index'])->name('schooltargets.index');
        Route::get('schooltargets/create', [SchoolTargetController::class, 'create'])->name('schooltargets.create');
        Route::post('schooltargets', [SchoolTargetController::class, 'store'])->name('schooltargets.store');
        Route::get('schooltargets/{targetSchool}', [SchoolTargetController::class, 'show'])->name('schooltargets.show');
        Route::get('schooltargets/{targetSchool}/edit', [SchoolTargetController::class, 'edit'])->name('schooltargets.edit');
        Route::patch('schooltargets/{targetSchool}', [SchoolTargetController::class, 'update'])->name('schooltargets.update');
        Route::delete('schooltargets/{targetSchool}', [SchoolTargetController::class, 'destroy'])->name('schooltargets.destroy');

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
        Route::get('schooltargets/{targetSchool}/facilities', [SchoolTargetController::class, 'attachFacilities'])->name('schooltargets.facilities.attach');
        Route::post('schooltargets/{targetSchool}/facilities', [SchoolTargetController::class, 'storeFacility'])->name('schooltargets.facilities.store');

        Route::get('schooltargets/{targetSchool}/extracurriculars', [SchoolTargetController::class, 'attachExtracurriculars'])->name('schooltargets.extracurriculars.attach');
        Route::post('schooltargets/{targetSchool}/extracurriculars', [SchoolTargetController::class, 'storeExtracurricular'])->name('schooltargets.extracurriculars.store');
    });
});
