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
     * Store a New Patient (Perfectly Mapped)
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
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userId = (string) Str::uuid();

        // 1. Create Core User Account
        DB::table('users')->insert([
            'id' => $userId,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'qualifier' => $request->qualifier,
            'name' => trim($request->first_name.' '.$request->middle_name.' '.$request->last_name.' '.$request->qualifier),
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'gender' => $request->gender,
            'mobile_num' => $request->mobile_num,
            'role' => 'patient',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Create Patient Profile
        DB::table('patient_profiles')->insert([
            'id' => (string) Str::uuid(),
            'user_id' => $userId,
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
     * Update an Existing Patient (Perfectly Mapped)
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

        // 1. Update Core User Details
        DB::table('users')->where('id', $id)->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'qualifier' => $request->qualifier,
            'name' => trim($request->first_name.' '.$request->middle_name.' '.$request->last_name.' '.$request->qualifier),
            'email' => $request->email,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'mobile_num' => $request->mobile_num,
            'updated_at' => now(),
        ]);

        // 2. Update Medical Demographics
        DB::table('patient_profiles')->where('user_id', $id)->update([
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

    /**
     * Display the Secretary Account Settings Page
     */
    public function settings()
    {
        $user = Auth::user();

        return view('secretary.settings', compact('user'));
    }

    /**
     * Update the Secretary's Credentials and Information
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        // 1. Validate the incoming request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'qualifier' => 'nullable|string|max:10',
            'mobile_num' => 'required|string|max:20',

            // Ensure email and username are unique, EXCEPT for the current user's ID
            'email' => 'required|email|unique:users,email,'.$user->id,
            'username' => 'required|string|unique:users,username,'.$user->id,

            // Password is optional, but if provided, must match confirmation
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 2. Prepare the data array for the 'users' table
        $userData = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'qualifier' => $request->qualifier,
            // Rebuild the full name string just in case pieces changed
            'name' => trim($request->first_name.' '.$request->middle_name.' '.$request->last_name.' '.$request->qualifier),
            'email' => $request->email,
            'username' => $request->username,
            'mobile_num' => $request->mobile_num,
            'updated_at' => now(),
        ];

        // 3. Only update the password if the user actually typed a new one
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // 4. Execute the update
        DB::table('users')->where('id', $user->id)->update($userData);

        // 5. Redirect back with the success pulse banner
        return back()->with('success', 'Account credentials successfully updated.');
    }
}
