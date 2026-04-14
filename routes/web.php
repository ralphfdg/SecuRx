<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Doctor\ConsultationController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\QueueController;
use App\Http\Controllers\Doctor\HistoryController;
use App\Http\Controllers\GuestVerificationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecretaryController;
use Illuminate\Support\Facades\Route;

// The Public Guest Pharmacist Portal Routes
Route::prefix('verify')->group(function () {

    // 1. The Idle Terminal / Fallback Scanner Page (verify.blade.php)
    Route::get('/', [GuestVerificationController::class, 'index'])->name('verify.index');

    // 2. The Direct URL Scan / Gatekeeper (gatekeeper.blade.php)
    Route::get('/{qr_uuid}', [GuestVerificationController::class, 'gatekeeper'])->name('verify.gatekeeper');

    // 3. The Decryption Action (POST)
    Route::post('/decrypt', [GuestVerificationController::class, 'decrypt'])->name('verify.decrypt');

    // 4. The Final Dispense Action (POST)
    Route::post('/dispense', [GuestVerificationController::class, 'dispense'])->name('verify.dispense');

});

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
*/
Route::middleware('auth')->group(function () {
    Route::get('/pending-approval', function () {
        return view('auth.pending-approval');
    })->name('pending.approval');

    // The Demo Onboarding Flow
    Route::get('/onboarding/verify-email', function () {
        return view('auth.static-verify-email');
    })->name('onboarding.verify-email');
    Route::get('/2fa/setup', function () {
        return view('auth.2fa-setup');
    })->name('2fa.setup');
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
    } elseif ($role === 'secretary') {
        return redirect()->route('secretary.dashboard');
    } else {
        return redirect()->route('patient.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// --------------------------------------------------------------------------
// ADMIN ROUTES
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. Dataset Import Engine
    Route::get('/dataset', [AdminController::class, 'datasetView'])->name('dataset');
    Route::post('/dataset/import', [AdminController::class, 'importDataset'])->name('dataset.import');

    // 3. Professional User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
    Route::patch('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

    // 4. Immutable Audit Logs
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');

    // 5. System Backup & Export
    Route::get('/backup', [AdminController::class, 'backupView'])->name('backup');
    Route::post('/backup/export', [AdminController::class, 'exportBackup'])->name('backup.export');

    // 6. Global Platform Settings
    Route::get('/settings', [AdminController::class, 'settingsView'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // 7. Admin Profile Settings
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::patch('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
});
/*
|--------------------------------------------------------------------------
| DOCTOR PORTAL ROUTES (Secure)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {

    // 1. Initial Setup (Specialization & Clinic Info)
    Route::get('/setup', function () {
        return view('doctor.setup');
    })->name('setup');

    // 2. The Main Command Center (Integrated Analytics)
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');

    // 3. Clinic Queue & Schedule (Fixed)
    Route::get('/queue', [QueueController::class, 'index'])->name('queue');

    // 4. Voice-Assisted Consultation Console
    Route::get('/consultation/{appointment}', [ConsultationController::class, 'show'])->name('consultation.show');
    Route::post('/consultation/{appointment}', [ConsultationController::class, 'store'])->name('consultation.store');

    // 5. Consultation & Prescription History
    Route::get('/history', function () {
        return view('doctor.history');
    })->name('history');

    // Consultation History & Revocation
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    Route::post('/history/revoke/{id}', [HistoryController::class, 'revoke'])->name('history.revoke');
    Route::get('/history/{id}', [HistoryController::class, 'show'])->name('history.show');

    // Patient Directory & CRUD
    Route::get('/directory', [DoctorController::class, 'directory'])->name('directory');
    Route::post('/directory/patient', [DoctorController::class, 'storePatient'])->name('patient.store');
    Route::patch('/directory/patient/{id}', [DoctorController::class, 'updatePatient'])->name('patient.update');

    // API Endpoint for the Records Drawer
    Route::get('/api/patients/{id}/records', [DoctorController::class, 'patientRecords'])->name('api.patient.records');

    // API Endpoints for Medications Search and DUR Check
    Route::get('/api/medications/search', [DoctorController::class, 'searchMedications'])->name('api.medications.search');
    Route::post('/api/dur/check', [DoctorController::class, 'checkDur'])->name('api.dur.check');

    // 7. SOAP Templates (Clinical Macros)
    Route::get('/templates', function () {
        return view('doctor.templates');
    })->name('templates');

    // 8. Staff Management (Secretary Accounts)
    Route::get('/staff', function () {
        return view('doctor.staff');
    })->name('staff');

    // 9. Profile & Settings (Digital Signature, Clinic Info)
    Route::get('/settings', function () {
        return view('doctor.settings');
    })->name('settings');
});

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
    // We are routing these to the PatientController now so we can pass backend data!
    Route::get('/dashboard', [PatientController::class, 'index'])->name('dashboard');

    Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
    // NEW: The missing routes from your demo flow
    Route::get('/appointments/book', [PatientController::class, 'bookAppointment'])->name('appointments.book');
    Route::post('/appointments', [PatientController::class, 'storeAppointment'])->name('appointments.store');
    Route::patch('/appointments/{id}/cancel', [PatientController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::get('/prescriptions', [PatientController::class, 'prescriptions'])->name('prescriptions');

    Route::get('/prescriptions/{id}/qr', [PatientController::class, 'showQr'])->name('qr-live');

    Route::get('/medical-profile', [PatientController::class, 'medicalProfile'])->name('profile.medical');
    Route::post('/documents/upload', [PatientController::class, 'storeDocument'])->name('documents.store');

    // Update the GET route to point to the controller instead of a closure
    Route::get('/data-consent', [PatientController::class, 'consent'])->name('consent');
    // Add the POST route to handle the save
    Route::post('/data-consent', [PatientController::class, 'updateConsent'])->name('consent.update');

    Route::get('/settings', [PatientController::class, 'settings'])->name('settings');

    // Authorized Representatives
    Route::get('/representatives', [PatientController::class, 'representatives'])->name('representatives');
    Route::post('/representatives', [PatientController::class, 'storeRepresentative'])->name('representatives.store');
    Route::patch('/representatives/{id}/toggle', [PatientController::class, 'toggleRepresentative'])->name('representatives.toggle');
    Route::delete('/representatives/{id}', [PatientController::class, 'destroyRepresentative'])->name('representatives.destroy');
});

// ==========================================
// SECRETARY PORTAL ROUTES
// ==========================================
Route::middleware(['auth', 'role:secretary'])->prefix('secretary')->name('secretary.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [SecretaryController::class, 'dashboard'])->name('dashboard');

    // Calendar
    Route::get('/calendar', [SecretaryController::class, 'calendar'])->name('calendar');
    Route::get('/api/appointments', [SecretaryController::class, 'getAppointments'])->name('api.appointments');

    // Appointment Management
    Route::get('/appointments/create', [SecretaryController::class, 'createAppointment'])->name('appointments.create');
    Route::post('/appointments', [SecretaryController::class, 'storeAppointment'])->name('appointments.store');
    // Appointment Actions
    Route::post('/appointments/no-show', [SecretaryController::class, 'markNoShow'])->name('appointments.no-show');

    // Triage & Queue Console
    Route::get('/triage', [SecretaryController::class, 'triage'])->name('triage');
    Route::post('/triage/store', [SecretaryController::class, 'storeTriage'])->name('triage.store');

    // Patient Directory
    Route::get('/patients', [SecretaryController::class, 'patients'])->name('patients');
    Route::post('/patients', [SecretaryController::class, 'storePatient'])->name('patients.store');
    Route::put('/patients/{id}', [SecretaryController::class, 'updatePatient'])->name('patients.update');

    // Account Settings
    Route::get('/settings', [SecretaryController::class, 'settings'])->name('settings');
    Route::put('/settings', [SecretaryController::class, 'updateSettings'])->name('settings.update');
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
