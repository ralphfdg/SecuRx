<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;

class PatientController extends Controller
{
    /**
     * Display the main Patient Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Count only the prescriptions that haven't been fully dispensed or revoked
        $activePrescriptionsCount = $user->patientPrescriptions()->where('status', 'active')->count();
        
        // Fetch the 5 most recent prescriptions for the dashboard table
        $recentPrescriptions = $user->patientPrescriptions()
            ->with(['doctor', 'items']) // Eager load the doctor and medication items
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('patient.dashboard', compact('user', 'activePrescriptionsCount', 'recentPrescriptions'));
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
            ->with(['doctor', 'items.medication'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patient.prescriptions', compact('user', 'prescriptions'));
    }

    /**
     * Display the Medical Profile (Allergies, Vitals, etc.)
     */
    public function medicalProfile()
    {
        $user = Auth::user();
        
        // Load the user with all their medical history
        $user->load(['patientProfile', 'allergies.medication', 'immunizations', 'labResults']);

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
            ->whereHas('doctorProfile', function($query) {
                $query->where('is_verified', true);
            })->with('doctorProfile.clinic', 'schedules')
            ->get();

        return view('patient.book-appointment', compact('user', 'doctors'));
    }

    /**
     * Store the new Appointment in the Database
     */
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
            'appointment_date' => ['required', 'date', 'after:now'],
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
            'status' => 'cancelled'
        ]);

        return redirect()->back()->with('success', 'Appointment has been cancelled.');
    }
}