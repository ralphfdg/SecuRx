<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('welcome');
});

// --------------------------------------------------------------------------
// THE TRAFFIC DIRECTOR (Fixes Breeze Login & Navigation)
// --------------------------------------------------------------------------
Route::get('/dashboard', function () {
    /** @var \App\Models\User|null $user */
    /** @disregard */
    $user = auth()->user();
    
    // IDE Fix: Prove to VS Code that the user is definitely not null
    if (!$user) {
        return redirect('/login');
    }

    $role = $user->role;
    
    if ($role === 'doctor') {
        return redirect()->route('doctor.dashboard');
    } elseif ($role === 'pharmacist') {
        return redirect()->route('pharmacist.dashboard');
    } else {
        return redirect()->route('patient.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// --------------------------------------------------------------------------
// Doctor ROUTES
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::post('/prescribe', [DoctorController::class, 'storePrescription'])->name('prescribe.store');
});

// --------------------------------------------------------------------------
// PHARMACIST ROUTES
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::get('/dashboard', [PharmacistController::class, 'dashboard'])->name('dashboard');
    // API Endpoint for the Javascript Webcam Scanner
    Route::post('/verify-qr', [PharmacistController::class, 'verifyQr'])->name('verify');
    // The Route to officially log the transaction
    Route::post('/dispense', [PharmacistController::class, 'dispense'])->name('dispense');
});

// --------------------------------------------------------------------------
// PATIENT ROUTES
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
