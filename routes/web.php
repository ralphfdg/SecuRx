<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --------------------------------------------------------------------------
// PUBLIC & INFORMATIONAL PAGES
// --------------------------------------------------------------------------
Route::get('/', function () {
    return view('public.home');
})->name('home'); // Now Patient-focused
Route::get('/for-doctors', function () {
    return view('public.doctors');
})->name('doctors.home');
Route::get('/for-pharmacies', function () {
    return view('public.pharmacies');
})->name('pharmacies.home');
Route::get('/about', function () {
    return view('public.about');
})->name('about');
Route::get('/help-center', function () {
    return view('public.help');
})->name('help');
Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');
Route::get('/privacy-policy', function () {
    return view('public.privacy');
})->name('privacy');
Route::get('/terms', function () {
    return view('public.terms');
})->name('terms');
Route::get('/accessibility', function () {
    return view('public.accessibility');
})->name('accessibility');

/*
|--------------------------------------------------------------------------
| CUSTOM ONBOARDING & SECURITY PAGES (Auth overrides)
|--------------------------------------------------------------------------
|
*/
Route::middleware('auth')->group(function () {
    Route::get('/pending-approval', function () {
        return view('auth.pending-approval');
    })->name('approval.pending');
    Route::get('/2fa/setup', function () {
        return view('auth.2fa-setup');
    })->name('2fa.setup');
    Route::get('/2fa/challenge', function () {
        return view('auth.2fa-challenge');
    })->name('2fa.challenge');
});

// --------------------------------------------------------------------------
// THE TRAFFIC DIRECTOR (Updated for Admin)
// --------------------------------------------------------------------------
Route::get('/dashboard', function () {
    /** @disregard */
    $user = auth()->user();

    if (! $user) {
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
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/medications', [AdminController::class, 'storeMedication'])->name('medications.store');
});

/*
|--------------------------------------------------------------------------
| DOCTOR PORTAL ROUTES(Secure)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {

    // 1. Initial Setup (Specialization & Clinic Info)
    Route::get('/setup', function () {
        return view('doctor.setup');
    })->name('setup');

    // 2. The Main Dashboard
    // Note: If you already have database logic in DoctorController, change this back to [DoctorController::class, 'index']
    Route::get('/dashboard', function () {
        return view('doctor.dashboard');
    })->name('dashboard');

    // 3. Create Prescription (The QR Generator)
    Route::get('/prescribe', function () {
        return view('doctor.create-prescription');
    })->name('prescribe');

    // 4. Prescription History & Revocation Table
    Route::get('/history', function () {
        return view('doctor.history');
    })->name('history');

    // 5. Patient Directory
    Route::get('/directory', function () {
        return view('doctor.directory');
    })->name('directory');

    // 6. Prescribing Analytics
    Route::get('/analytics', function () {
        return view('doctor.analytics');
    })->name('analytics');

    // 7. Profile & Settings
    Route::get('/settings', function () {
        return view('doctor.settings');
    })->name('settings');

    // ---------------------------------------------------------
    // FUTURE BACKEND ROUTES (For when you connect the database)
    // ---------------------------------------------------------
    // Route::post('/prescribe', [DoctorController::class, 'storePrescription'])->name('prescribe.store');
    // Route::post('/revoke/{uuid}', [DoctorController::class, 'revokePrescription'])->name('revoke');
    // Route::post('/settings', [DoctorController::class, 'updateSettings'])->name('settings.update');
});

/*
|--------------------------------------------------------------------------
| PHARMACIST PORTAL ROUTES
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| 6. PHARMACIST PORTAL ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::get('/dashboard', function () { 
        return view('pharmacist.dashboard'); 
    })->name('dashboard');
    
    Route::get('/scanner', function () { 
        return view('pharmacist.scanner'); 
    })->name('scanner');
    
    Route::get('/dispense', function () { 
        return view('pharmacist.dispense'); 
    })->name('dispense');
    
    Route::get('/logs', function () { 
        return view('pharmacist.logs'); 
    })->name('logs');
    
    Route::get('/settings', function () { 
        return view('pharmacist.settings'); 
    })->name('settings');
});

/*
|--------------------------------------------------------------------------
| PATIENT PORTAL ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'index'])->name('dashboard');
    Route::get('/qr-live', function () {
        return view('patient.qr-live');
    })->name('qr-live');
    Route::get('/qr-print', function () {
        return view('patient.qr-print');
    })->name('qr-print');
    Route::get('/medical-profile', function () {
        return view('patient.medical-profile');
    })->name('profile.medical');
    Route::get('/data-consent', function () {
        return view('patient.data-consent');
    })->name('consent');
    Route::get('/settings', function () {
        return view('patient.settings');
    })->name('settings');
});

/*
|--------------------------------------------------------------------------
| SYSTEM ROUTES (Breeze Profile & Auth)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
