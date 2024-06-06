<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ITStaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentManagementController;
use App\Http\Controllers\SchoolTargetController;
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
        Route::resource('students', StudentManagementController::class);
        Route::resource('schooltargets', SchoolTargetController::class);
    });
});
