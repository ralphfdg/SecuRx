<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;

// --------------------------------------------------------------------------
// PUBLIC & INFORMATIONAL PAGES
// --------------------------------------------------------------------------
Route::get('/', function () { return view('public.home'); })->name('home');
Route::get('/about', function () { return view('public.about'); })->name('about');
Route::get('/help-center', function () { return view('public.help'); })->name('help');
Route::get('/contact', function () { return view('public.contact'); })->name('contact');
Route::get('/privacy-policy', function () { return view('public.privacy'); })->name('privacy');
Route::get('/terms', function () { return view('public.terms'); })->name('terms');
Route::get('/accessibility', function () { return view('public.accessibility'); })->name('accessibility');

// --------------------------------------------------------------------------
// THE TRAFFIC DIRECTOR (Updated for Admin)
// --------------------------------------------------------------------------
Route::get('/dashboard', function () {
    /** @disregard */
    $user = auth()->user();
    
    if (!$user) {
        return redirect('/login');
    }

    $role = $user->role;
    
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard'); 
    } elseif ($role === 'doctor') {
        return redirect()->route('doctor.dashboard');
    } elseif ($role === 'pharmacist') {
        return redirect()->route('pharmacist.dashboard');
    } else {
        return redirect()->route('patient.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// --------------------------------------------------------------------------
// ADMIN ROUTES
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/medications', [App\Http\Controllers\AdminController::class, 'storeMedication'])->name('medications.store');
});

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
