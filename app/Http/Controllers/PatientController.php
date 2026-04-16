<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalDocument;
use App\Models\Prescription;
use App\Models\User;
use App\Models\AuthorizedRepresentative;
use App\Rules\ValidAppointmentTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display the main Patient Dashboard
     */
    public function index()
    {
        $user = Auth::user();

        $activePrescriptionsCount = $user->patientPrescriptions()->where('status', 'active')->count();

        $recentPrescriptions = $user->patientPrescriptions()
            ->with(['doctor', 'items'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // NEW: Fetch the single next upcoming appointment
        $nextAppointment = $user->patientAppointments()
            ->where('appointment_date', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['doctor.doctorProfile.clinic'])
            ->orderBy('appointment_date', 'asc')
            ->first();

        // Pass the new variable to the view
        return view('patient.dashboard', compact('user', 'activePrescriptionsCount', 'recentPrescriptions', 'nextAppointment'));
    }

    /**
     * Display the Appointment Management Page
     */
    public function appointments()
    {
        $user = Auth::user();
        
        // 1. Fetch Upcoming (Not paginated)
        $upcomingAppointments = $user->patientAppointments()
            ->with(['doctor.schedules']) 
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date', 'asc')
            ->get();
            
        // 2. Fetch History (Paginated at 5 per page!)
        $historyAppointments = $user->patientAppointments()
            ->with(['doctor']) 
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(5);
            
        // 3. Fetch taken slots for the reschedule calendar
        $doctorIds = $upcomingAppointments->pluck('doctor_id')->unique();
        
        $bookedAppointments = \App\Models\Appointment::whereIn('doctor_id', $doctorIds)
            ->where('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->groupBy('doctor_id')
            ->map(function ($appts) {
                return $appts->map(function ($appt) {
                    $time = $appt->appointment_time ?? '00:00:00';
                    return \Carbon\Carbon::parse($appt->appointment_date->format('Y-m-d') . ' ' . $time)->toDateTimeString();
                });
            });
            
        return view('patient.appointments', compact('user', 'upcomingAppointments', 'historyAppointments', 'bookedAppointments'));
    }

    /**
     * Display the complete list of Prescriptions
     */
    public function prescriptions()
    {
        $user = Auth::user();

        $prescriptions = $user->patientPrescriptions()
            ->with(['doctor.doctorProfile', 'items.medication'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.prescriptions', compact('user', 'prescriptions'));
    }

    /**
     * Display the Medical Profile (Allergies, Vitals, etc.)
     */
    public function medicalProfile()
    {
        $user = Auth::user();
        $user->load('patientProfile');

        // Paginate each section independently with distinct query parameters
        $allergies = $user->allergies()
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'allergies_page')
            ->withQueryString();

        $immunizations = $user->immunizations()
            ->orderBy('administered_date', 'desc')
            ->paginate(5, ['*'], 'immunizations_page')
            ->withQueryString();

        $labs = $user->labResults()
            ->orderBy('test_date', 'desc')
            ->paginate(5, ['*'], 'labs_page')
            ->withQueryString();

        $documents = $user->medicalDocuments()
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'documents_page')
            ->withQueryString();

        $encounters = $user->patientEncounters()
            ->with('doctor')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'encounters_page')
            ->withQueryString();

        return view('patient.medical-profile', compact(
            'user', 'allergies', 'immunizations', 'labs', 'documents', 'encounters'
        ));
    }

    /**
     * Store a new Patient Allergy
     */
    public function storeAllergy(Request $request)
    {
        $request->validate([
            'allergen_name' => 'required|string|max:255',
            'reaction' => 'required|string|max:255',
            'severity' => 'required|string|in:Low,Medium,High Severity', 
        ]);

        Auth::user()->allergies()->create([
            'allergen_name' => $request->allergen_name,
            'reaction' => $request->reaction,
            'severity' => $request->severity,
            'is_verified' => false,
        ]);

        return redirect()->back()->with('success', 'Allergy reported successfully. It is now pending physician verification.');
    }

    /**
     * Store a new Patient Immunization
     */
    public function storeImmunization(Request $request)
    {
        $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'administered_date' => 'required|date|before_or_equal:today',
            'facility' => 'required|string|max:255',
        ]);

        Auth::user()->immunizations()->create([
            'vaccine_name' => $request->vaccine_name,
            'administered_date' => $request->administered_date,
            'facility' => $request->facility,
            'is_verified' => false,
        ]);

        return redirect()->back()->with('success', 'Immunization logged successfully.');
    }

    /**
     * Store a new Patient Lab Result
     */
    public function storeLabResult(Request $request)
    {
        $request->validate([
            'test_name' => 'required|string|max:255',
            // FIX: Add validation for the missing test date
            'test_date' => 'required|date|before_or_equal:today', 
            'lab_file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120', 
        ]);

        if ($request->hasFile('lab_file')) {
            $file = $request->file('lab_file');
            $filename = time().'_lab_'.Auth::id().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('lab_results', $filename, 'public');

            Auth::user()->labResults()->create([
                'test_name' => $request->test_name,
                // FIX: Save the test date to the database
                'test_date' => $request->test_date, 
                'file_path' => $path,
                'is_verified' => false,
            ]);

            return redirect()->back()->with('success', 'Lab result uploaded successfully.');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    /**
     * Securely display uploaded medical files (Bypasses public symlinks)
     */
    public function viewFile($path)
    {
        // Get the absolute path to the file inside the secure storage directory
        $fullPath = storage_path('app/public/' . $path);

        // Check if the file actually exists
        if (!file_exists($fullPath)) {
            abort(404, 'Medical record not found.');
        }

        // Return the file securely directly through Laravel's backend
        return response()->file($fullPath);
    }

    /**
     * Display the Appointment Booking Form
     */
    public function bookAppointment()
    {
        $user = Auth::user();

        $doctors = User::where('role', 'doctor')
            ->where('status', 'active')
            ->whereHas('doctorProfile', function ($query) {
                $query->where('is_verified', true);
            })->with('doctorProfile.clinic', 'schedules')
            ->orderBy('last_name')
            ->get();

        // Fix: Properly combine date and time for the Javascript calendar checking
        $upcomingAppointments = Appointment::where('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->groupBy('doctor_id')
            ->map(function ($appointments) {
                return $appointments->map(function ($appt) {
                    $time = $appt->appointment_time ?? '00:00:00';
                    return Carbon::parse($appt->appointment_date->format('Y-m-d') . ' ' . $time)->toDateTimeString();
                });
            });

        return view('patient.book-appointment', compact('user', 'doctors', 'upcomingAppointments'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
            'appointment_date' => [
                'required',
                'date',
                'after:now',
                new ValidAppointmentTime($request->doctor_id),
                
                // NEW: Anti-Double-Booking Validation
                function ($attribute, $value, $fail) use ($request) {
                    $datetime = Carbon::parse($value);
                    
                    $conflict = Appointment::where('doctor_id', $request->doctor_id)
                        ->where('appointment_date', $datetime->toDateString())
                        ->where('appointment_time', $datetime->toTimeString())
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->exists();

                    if ($conflict) {
                        $fail('That exact time slot has already been booked. Please choose a different time.');
                    }
                },
            ],
        ]);

        $datetime = Carbon::parse($request->appointment_date);

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $datetime->toDateString(),
            'appointment_time' => $datetime->toTimeString(),
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Your appointment request has been submitted to the clinic.');
    }

    /**
     * Cancel an existing Appointment
     */
    /**
     * Cancel an existing appointment
     */
    public function cancelAppointment($id)
    {
        // FIX: Changed appointments() to patientAppointments()
        $appointment = Auth::user()->patientAppointments()->findOrFail($id);

        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'This appointment cannot be modified.');
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Your appointment has been successfully cancelled.');
    }

    public function rescheduleAppointment(Request $request, $id)
    {
        $appointment = Auth::user()->patientAppointments()->findOrFail($id);

        $request->validate([
            'appointment_date' => [
                'required',
                'date',
                'after:now',
                new \App\Rules\ValidAppointmentTime($appointment->doctor_id),
                
                // NEW: Anti-Double-Booking Validation
                function ($attribute, $value, $fail) use ($appointment) {
                    $datetime = Carbon::parse($value);
                    
                    $conflict = Appointment::where('doctor_id', $appointment->doctor_id)
                        ->where('appointment_date', $datetime->toDateString())
                        ->where('appointment_time', $datetime->toTimeString())
                        ->where('id', '!=', $appointment->id) // Ignore their own current slot!
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->exists();

                    if ($conflict) {
                        $fail('That exact time slot has already been booked. Please choose a different time.');
                    }
                },
            ],
        ]);

        $datetime = Carbon::parse($request->appointment_date);

        $appointment->update([
            'appointment_date' => $datetime->toDateString(),
            'appointment_time' => $datetime->toTimeString(),
            'status' => 'pending', 
        ]);

        return redirect()->back()->with('success', 'Your appointment has been rescheduled and is pending clinic confirmation.');
    }

    /**
     * Display the Live QR Code for a specific prescription
     */
    public function showQr($id)
    {
        $user = Auth::user();

        // Fetch the specific prescription, ensuring it actually belongs to the logged-in patient!
        $prescription = Prescription::where('id', $id)
            ->where('patient_id', $user->id)
            ->with(['doctor.doctorProfile', 'items.medication', 'encounter'])
            ->firstOrFail();

        return view('patient.qr-live', compact('user', 'prescription'));
    }

    /**
     * Store a patient-uploaded medical document
     */
    public function storeDocument(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time().'_'.$request->user()->id.'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('medical_documents', $filename, 'public');

            Auth::user()->medicalDocuments()->create([
                'document_name' => $request->document_name,
                'file_path' => $path,
                'is_verified' => false,
                // FIX: We completely removed the 'document_type' line here so it matches your ERD!
            ]);

            return redirect()->back()->with('success', 'Medical document uploaded successfully.');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    /**
     * Display the Data Consent & Privacy Settings Page
     */
    public function consent()
    {
        $user = Auth::user();
        $profile = $user->patientProfile;

        return view('patient.data-consent', compact('user', 'profile'));
    }

    /**
     * Update the patient's Data Consent Settings
     */
    public function updateConsent(Request $request)
    {
        $user = Auth::user();

        // Save the master toggle state to the existing database column
        $user->patientProfile()->updateOrCreate(
            ['user_id' => $user->id],
            ['data_consent' => $request->has('data_consent')]
        );

        return redirect()->back()->with('success', 'Your master privacy settings have been securely updated.');
    }

    /**
     * Display the Patient Settings Page
     */
    public function settings()
    {
        // Eager load the profile so we don't hit the database twice
        $user = Auth::user()->load('patientProfile');
        
        return view('patient.settings', compact('user'));
    }

    /**
     * Display the Authorized Representatives Page
     */
    public function representatives()
    {
        $user = Auth::user();
        
        // Fetch the user's representatives
        $representatives = AuthorizedRepresentative::where('patient_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patient.representatives', compact('user', 'representatives'));
    }

    /**
     * Store a new Authorized Representative
     */
    public function storeRepresentative(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'relationship' => 'required|string|max:100',
        ]);

        AuthorizedRepresentative::create([
            'patient_id' => Auth::id(),
            'full_name' => $request->full_name,
            'relationship' => $request->relationship,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Authorized representative added successfully.');
    }

    /**
     * Toggle the active status of a representative
     */
    public function toggleRepresentative($id)
    {
        // Ensure the rep exists AND belongs to the logged-in patient
        $rep = AuthorizedRepresentative::where('id', $id)
            ->where('patient_id', Auth::id())
            ->firstOrFail();

        $rep->update([
            'is_active' => !$rep->is_active
        ]);

        $status = $rep->is_active ? 'activated' : 'temporarily revoked';
        return redirect()->back()->with('success', "Representative access has been {$status}.");
    }

    /**
     * Delete a representative permanently
     */
    public function destroyRepresentative($id)
    {
        $rep = AuthorizedRepresentative::where('id', $id)
            ->where('patient_id', Auth::id())
            ->firstOrFail();

        $rep->delete();

        return redirect()->back()->with('success', 'Representative removed permanently.');
    }
}
