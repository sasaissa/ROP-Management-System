<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\TreatmentPlanController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\NicuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/refresh', [DashboardController::class, 'refresh'])->name('dashboard.refresh');
    Route::post('/dashboard/examinations/{examination}/mark-reviewed', [ExaminationController::class, 'markReviewed'])
        ->name('examinations.mark-reviewed');

    // Patient Management Routes
    Route::resource('patients', PatientController::class);
    
    // Examination Management Routes
    Route::get('examinations/create', [ExaminationController::class, 'selectPatient'])->name('examinations.create');
    Route::resource('examinations', ExaminationController::class)->except(['create']);
    Route::get('patients/{patient}/examinations/create', [ExaminationController::class, 'create'])
        ->name('patients.examinations.create');
    Route::post('patients/{patient}/examinations', [ExaminationController::class, 'store'])
        ->name('patients.examinations.store');
    Route::post('examinations/{examination}/mark-reviewed', [ExaminationController::class, 'markReviewed'])
        ->name('examinations.mark-reviewed');

    // Treatment Management Routes
    Route::get('patients/{patient}/treatments/create', [TreatmentController::class, 'create'])
        ->name('patients.treatments.create');
    Route::post('patients/{patient}/treatments', [TreatmentController::class, 'store'])
        ->name('patients.treatments.store');
    Route::resource('treatments', TreatmentController::class);
    Route::patch('/treatments/{treatment}/complete', [TreatmentController::class, 'complete'])->name('treatments.complete');

    // NICU Management Routes
    Route::middleware('auth')->group(function () {
        // Routes accessible by all authenticated users
        Route::get('/nicus', [NicuController::class, 'index'])->name('nicus.index');
        Route::get('/nicus/{nicu}', [NicuController::class, 'show'])->name('nicus.show');

        // Routes accessible only by admins
        Route::middleware('role:admin')->group(function () {
            Route::get('/nicus/create', [NicuController::class, 'create'])->name('nicus.create');
            Route::post('/nicus', [NicuController::class, 'store'])->name('nicus.store');
            Route::get('/nicus/{nicu}/edit', [NicuController::class, 'edit'])->name('nicus.edit');
            Route::put('/nicus/{nicu}', [NicuController::class, 'update'])->name('nicus.update');
            Route::delete('/nicus/{nicu}', [NicuController::class, 'destroy'])->name('nicus.destroy');
            Route::post('/nicus/{nicu}/assign-doctors', [NicuController::class, 'assignDoctors'])->name('nicus.assign-doctors');
        });
    });

    // Treatment Plan Routes
    Route::post('examinations/{examination}/treatment-plan', [TreatmentPlanController::class, 'generate'])
        ->name('examinations.treatment-plan.generate');
    Route::post('examinations/{examination}/accept-treatment-plan', [ExaminationController::class, 'acceptTreatmentPlan'])
        ->name('examinations.accept-treatment-plan');
    Route::post('treatment-plans/{treatmentPlan}/accept', [TreatmentPlanController::class, 'accept'])
        ->name('treatment-plans.accept');
    Route::put('treatment-plans/{treatmentPlan}', [TreatmentPlanController::class, 'update'])
        ->name('treatment-plans.update');
    Route::post('treatment-plans/{treatmentPlan}/cancel', [TreatmentPlanController::class, 'cancel'])
        ->name('treatment-plans.cancel');
});

require __DIR__.'/auth.php';
