<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ContractorWorkerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinishingWorkController;
use App\Http\Controllers\LaborCostController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StructureCostController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::resource('projects', ProjectController::class);

    Route::prefix('projects/{project}')->name('projects.')->group(function () {
        Route::resource('materials', MaterialController::class);
        Route::resource('contractors', LaborCostController::class);
        Route::resource('structure-costs', StructureCostController::class);
        Route::resource('finishing-works', FinishingWorkController::class);
        Route::resource('workers', WorkerController::class);
        Route::resource('attendances', AttendanceController::class);
        Route::resource('payments', PaymentController::class);

        // Attendance calendar and bulk operations
        Route::get('attendances-calendar', [AttendanceController::class, 'calendar'])
            ->name('attendances.calendar');
        Route::post('attendances/bulk', [AttendanceController::class, 'bulkStore'])
            ->name('attendances.bulk');

        // Contractor workers
        Route::get('contractors/{contractor}/workers', [ContractorWorkerController::class, 'index'])
            ->name('contractors.workers.index');
        Route::post('contractors/{contractor}/workers', [ContractorWorkerController::class, 'attach'])
            ->name('contractors.workers.attach');
        Route::delete('contractors/{contractor}/workers/{worker}', [ContractorWorkerController::class, 'detach'])
            ->name('contractors.workers.detach');
    });
});

require __DIR__.'/auth.php';
