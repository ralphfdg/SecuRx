<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SecretaryController extends Controller
{
    /**
     * Display the Secretary Dashboard (Fully Dynamic)
     */
    public function dashboard()
    {
        $user = Auth::user();

        // 1. Fetch real Pending Requests (Status = 'pending')
        $pendingRequests = Appointment::with(['patient', 'doctor'])
            ->where('status', 'pending')
            ->orderBy('appointment_date', 'asc')
            ->get();

        // 2. Fetch real Today's Expected Patients (Status = 'confirmed' or 'completed', Date = Today)
        $todaysExpected = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', Carbon::today())
            ->whereIn('status', ['confirmed', 'completed'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('secretary.dashboard', compact('user', 'pendingRequests', 'todaysExpected'));
    }

    /**
     * Display the Master Calendar Page
     */
    public function calendar()
    {
        $user = Auth::user();

        return view('secretary.calendar', compact('user'));
    }

    /**
     * API Endpoint for FullCalendar to fetch dynamic appointments
     */
    public function getAppointments(Request $request)
    {
        // Fetch all appointments dynamically
        $appointments = Appointment::with(['patient', 'doctor'])->get();

        $events = [];

        foreach ($appointments as $appointment) {
            // Dynamically assign colors based on your database ENUM status
            $color = match ($appointment->status) {
                'pending' => '#f97316',   // Orange
                'confirmed' => '#10b981', // Green
                'completed' => '#64748b', // Slate/Gray
                'cancelled' => '#ef4444', // Red
                default => '#3b82f6',     // Blue
            };

            // Safely grab names, fallback if null
            $doctorName = $appointment->doctor ? 'Dr. '.$appointment->doctor->last_name : 'Unknown Doctor';
            $patientName = $appointment->patient ? $appointment->patient->first_name.' '.$appointment->patient->last_name : 'Unknown Patient';

            $events[] = [
                'id' => $appointment->id,
                'title' => $doctorName.' - '.$patientName,
                'start' => Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i:s'),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'status' => ucfirst($appointment->status),
                    'patientName' => $patientName,
                    'doctorName' => $doctorName,
                ],
            ];
        }

        return response()->json($events);
    }

    /**
     * Show the form for creating a new Walk-in Appointment
     */
    public function createAppointment()
    {
        $user = Auth::user();

        // Fetch all doctors and patients for the selection dropdowns
        $doctors = User::where('role', 'doctor')->get();
        $patients = User::where('role', 'patient')->get();

        return view('secretary.appointments-create', compact('user', 'doctors', 'patients'));
    }

    /**
     * Store the Walk-in Appointment in the database
     */
    public function storeAppointment(Request $request)
    {
        // 1. Validate the incoming form data
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'appointment_time' => 'required',
        ]);

        // 2. Combine "Today" with the selected time
        $appointmentDate = Carbon::today()->format('Y-m-d').' '.$request->appointment_time.':00';

        // 3. Insert into the database using your UUID structure
        DB::table('appointments')->insert([
            'id' => (string) Str::uuid(),
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'secretary_id' => Auth::id(),
            'appointment_date' => $appointmentDate,
            'status' => 'confirmed', // Walk-ins are instantly confirmed
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Redirect back to the calendar with a success message
        return redirect()->route('secretary.calendar')->with('success', 'Walk-in appointment successfully logged and confirmed!');
    }

    /**
     * Mark an appointment as a No Show (maps to 'cancelled' in DB)
     */
    public function markNoShow(Request $request)
    {
        $request->validate(['appointment_id' => 'required|exists:appointments,id']);

        DB::table('appointments')->where('id', $request->appointment_id)->update([
            'status' => 'cancelled',
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Patient has been marked as a No Show.');
    }

    /**
     * Display the Daily Queue & Triage Console
     */
    public function triage()
    {
        $user = Auth::user();

        // Fetch all of TODAY'S confirmed appointments
        $queue = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', Carbon::today())
            ->where('status', 'confirmed')
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Split the queue based on whether the JSON vitals column is empty or filled
        $needsTriage = $queue->whereNull('triage_vitals');
        $readyForDoctor = $queue->whereNotNull('triage_vitals');

        return view('secretary.triage', compact('user', 'needsTriage', 'readyForDoctor'));
    }

    /**
     * Store the Patient's Vitals into the JSON column
     */
    public function storeTriage(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'blood_pressure' => 'required|string',
            'temperature' => 'required|numeric',
            'weight' => 'required|numeric',
            'heart_rate' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        // Construct the JSON payload
        $vitals = [
            'blood_pressure' => $request->blood_pressure,
            'temperature' => $request->temperature,
            'weight' => $request->weight,
            'heart_rate' => $request->heart_rate,
            'notes' => $request->notes,
            'logged_at' => now()->toDateTimeString(),
            'logged_by' => Auth::user()->name,
        ];

        // Update the appointment record
        DB::table('appointments')->where('id', $request->appointment_id)->update([
            'triage_vitals' => json_encode($vitals),
            'updated_at' => now(),
        ]);

        return redirect()->route('secretary.triage')->with('success', 'Vitals successfully logged. Patient is ready for the doctor.');
    }

    /**
     * Display the Patient Directory
     */
    public function patients(Request $request)
    {
        $user = Auth::user();

        // Base query for patients, eager loading their medical profile
        $query = User::where('role', 'patient')->with('patientProfile');

        // Simple Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Paginate results (15 per page)
        $patients = $query->orderBy('last_name', 'asc')->paginate(15);

        return view('secretary.patients', compact('user', 'patients'));
    }

    /**
     * Store a New Patient (Fully Expanded)
     */
    public function storePatient(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'qualifier' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'mobile_num' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'address' => 'required|string',
            'school_work' => 'nullable|string',
            'mother_name' => 'nullable|string',
            'mother_contact' => 'nullable|string',
            'father_name' => 'nullable|string',
            'father_contact' => 'nullable|string',
        ]);

        $userId = (string) Str::uuid();

        // 1. Create Core User Account
        DB::table('users')->insert([
            'id' => $userId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            // Assuming your schema handles the full name combination
            'name' => trim($request->first_name.' '.$request->middle_name.' '.$request->last_name.' '.$request->qualifier),
            'username' => strtolower($request->first_name).rand(1000, 9999),
            'email' => $request->email,
            'password' => Hash::make('SecuRx'.date('Y')),
            'dob' => $request->dob,
            'gender' => $request->gender,
            'mobile_num' => $request->mobile_num,
            'role' => 'patient',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Create Full Patient Profile with all extended demographics
        DB::table('patient_profiles')->insert([
            'id' => (string) Str::uuid(),
            'user_id' => $userId,
            'middle_name' => $request->middle_name,
            'qualifier' => $request->qualifier,
            'height' => $request->height,
            'weight' => $request->weight,
            'address' => $request->address,
            'school_work' => $request->school_work,
            'mother_name' => $request->mother_name,
            'mother_contact' => $request->mother_contact,
            'father_name' => $request->father_name,
            'father_contact' => $request->father_contact,
            'data_consent' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Patient profile successfully created and linked.');
    }

    /**
     * Update an Existing Patient (Fully Expanded)
     */
    public function updatePatient(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'qualifier' => 'nullable|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'dob' => 'required|date',
            'gender' => 'required|string',
            'mobile_num' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'address' => 'required|string',
            'school_work' => 'nullable|string',
            'mother_name' => 'nullable|string',
            'mother_contact' => 'nullable|string',
            'father_name' => 'nullable|string',
            'father_contact' => 'nullable|string',
        ]);

        DB::table('users')->where('id', $id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => trim($request->first_name.' '.$request->middle_name.' '.$request->last_name.' '.$request->qualifier),
            'email' => $request->email,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'mobile_num' => $request->mobile_num,
            'updated_at' => now(),
        ]);

        DB::table('patient_profiles')->where('user_id', $id)->update([
            'middle_name' => $request->middle_name,
            'qualifier' => $request->qualifier,
            'height' => $request->height,
            'weight' => $request->weight,
            'address' => $request->address,
            'school_work' => $request->school_work,
            'mother_name' => $request->mother_name,
            'mother_contact' => $request->mother_contact,
            'father_name' => $request->father_name,
            'father_contact' => $request->father_contact,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Patient profile updated successfully.');
    }
}
