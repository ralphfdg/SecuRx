<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalDocument;
use App\Models\Prescription;
use App\Models\User;
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

        // Get upcoming appointments
        $appointments = $user->patientAppointments()
            ->with('doctor')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('patient.appointments', compact('user', 'appointments'));
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

        // Eager load ALL medical history relationships to prevent N+1 queries
        $user->load([
            'patientProfile',
            'allergies.medication',
            'immunizations',
            'labResults',
            'medicalDocuments',
            'patientEncounters.doctor', // Eager load the doctor for each encounter
        ]);

        return view('patient.medical-profile', compact('user'));
    }

    /**
     * Display the Appointment Booking Form
     */
    public function bookAppointment()
    {
        $user = Auth::user();

        // Fetch only verified, active doctors for the dropdown
        $doctors = User::where('role', 'doctor')
            ->where('status', 'active')
            ->whereHas('doctorProfile', function ($query) {
                $query->where('is_verified', true);
            })->with('doctorProfile.clinic', 'schedules')
            ->orderBy('last_name')
            ->get();

        // Fetch all upcoming appointments to check for conflicts on the frontend
        $upcomingAppointments = Appointment::where('appointment_date', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->groupBy('doctor_id')
            ->map(function ($appointments) {
                return $appointments->pluck('appointment_date')->map(function ($date) {
                    return Carbon::parse($date)->toDateTimeString();
                });
            });

        return view('patient.book-appointment', compact('user', 'doctors', 'upcomingAppointments'));
    }

    /**
     * Store the new Appointment in the Database
     */
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
            'appointment_date' => [
                'required',
                'date',
                'after:now',
                new ValidAppointmentTime($request->doctor_id),
            ],
        ]);

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            // Assuming the secretary will be assigned later by the clinic
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
        ]);

        // Redirect back to the appointments list with a success message
        return redirect()->route('patient.appointments')->with('success', 'Your appointment request has been submitted to the clinic.');
    }

    /**
     * Cancel an existing Appointment
     */
    public function cancelAppointment($id)
    {
        // Ensure the patient can only cancel THEIR OWN appointments
        $appointment = Appointment::where('id', $id)
            ->where('patient_id', Auth::id())
            ->firstOrFail();

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()->back()->with('success', 'Appointment has been cancelled.');
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
            'document_file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'document_name' => 'required|string|max:255',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            // Generate a secure, unique filename
            $filename = time().'_'.Auth::id().'.'.$file->getClientOriginalExtension();

            // Save to storage/app/public/medical_documents
            $path = $file->storeAs('medical_documents', $filename, 'public');

            // Save to database
            MedicalDocument::create([
                'patient_id' => Auth::id(),
                'document_name' => $request->document_name,
                'document_type' => $file->getClientOriginalExtension(), // PDF, JPG, etc.
                'file_path' => $path,
                'is_verified' => false, // STRICT COMPLIANCE: Defaults to unverified PGHD
            ]);

            return redirect()->back()->with('success', 'Document uploaded successfully. It is now pending physician review.');
        }

        return redirect()->back()->with('error', 'File upload failed. Please try again.');
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

        // Checkboxes in HTML only send data if they are checked.
        // We use $request->has() to convert that to a boolean true/false.
        $user->patientProfile()->update([
            'data_consent' => $request->has('allow_pharmacist'), // This is your main database column
            // Note: If you add 'allow_doctor' or 'allow_research' to your database later,
            // you would update those here as well.
        ]);

        return redirect()->back()->with('success', 'Your privacy settings have been securely updated.');
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
}
