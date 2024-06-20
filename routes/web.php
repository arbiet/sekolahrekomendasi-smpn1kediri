<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ITStaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\ToSweetAlert;
use App\Http\Controllers\SchoolDecisionController;
use App\Http\Controllers\SchoolChoiceController;


require __DIR__.'/auth.php';

Route::middleware(['web', ToSweetAlert::class])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/schools/json/{id}', [SchoolController::class, 'showJson']);


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        Route::get('/dashboard', function () {
            $user = Auth::user();

            if ($user->usertype === 'admin') {
                return redirect()->route('admin.dashboard.index');
            } elseif ($user->usertype === 'itstaff') {
                return redirect()->route('itstaff.dashboard.index');
            } elseif ($user->usertype === 'student') {
                return redirect()->route('student.dashboard.index');
            } 
        })->name('dashboard');
    });

    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard.index');
    });

    Route::middleware(['auth', 'itstaff'])->prefix('itstaff')->group(function () {
        Route::match(['get', 'post'], '/calculate-saw', [SchoolDecisionController::class, 'calculateSAW'])->name('calculate-saw');
        Route::get('/student-details/{id}', [SchoolDecisionController::class, 'getStudentDetails']);
        Route::post('/check-probability', [SchoolDecisionController::class, 'checkProbability'])->name('check-probability');
        Route::get('/check-probability-index', [SchoolDecisionController::class, 'indexProbability'])->name('check-probability.index');

        Route::get('/dashboard', [ITStaffController::class, 'index'])->name('itstaff.dashboard.index');
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

        Route::get('students/{student}/edit-address', [StudentController::class, 'editAddress'])->name('students.edit_address');
        Route::get('students/{student}/edit-achievements', [StudentController::class, 'editAchievements'])->name('students.edit_achievements');
        Route::get('students/{student}/edit-final-scores', [StudentController::class, 'editFinalScores'])->name('students.edit_final_scores');
        Route::get('students/{student}/edit-school-choices', [StudentController::class, 'editSchoolChoice'])->name('students.edit_school_choices');
        Route::get('students/{student}/edit-graduated-school', [StudentController::class, 'editGraduatedSchool'])->name('students.edit_graduated_school');
        Route::put('students/{student}/update-address', [StudentController::class, 'updateAddress'])->name('students.update_address');
        Route::put('students/{student}/update-achievements', [StudentController::class, 'updateAchievements'])->name('students.update_achievements');
        Route::put('students/{student}/update-final-scores', [StudentController::class, 'updateFinalScores'])->name('students.update_final_scores');
        Route::put('students/{student}/update-school-choices', [StudentController::class, 'updateSchoolChoice'])->name('students.update_school_choice');
        Route::put('students/{student}/update-graduated-school', [StudentController::class, 'updateGraduatedSchool'])->name('students.update_graduated_school');
    });

    Route::middleware(['auth', 'student'])->prefix('student')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'studentIndex'])->name('student.dashboard.index');
        Route::get('/choose-schools', [StudentController::class, 'chooseSchools'])->name('student.choose.schools');
        Route::put('/store-choice', [StudentController::class, 'storeChoice'])->name('student.store_choice');
        Route::get('/schools/json/{id}', [SchoolController::class, 'showJson']);

    });
    
    
});
