<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\User;
use App\Models\Medication;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function dashboard()
    {
        // Fetch all patients and medications to send to the frontend form
        $patients = User::where('role', 'patient')->get();
        $medications = Medication::all();
        
        return view('doctor.dashboard', compact('patients', 'medications'));
    }

    // Store and Generate QR token
    public function storePrescription(Request $request)
    {
        // 1. Validate the incoming form data
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'medication_id' => 'required|exists:medications,id',
            'dosage_instructions' => 'required|string',
            'days_supply_per_refill' => 'required|integer',
            'max_refills' => 'required|integer',
        ]);

        // 2. Generate the Cryptographic Token for the QR Code
        $secureToken = Str::uuid()->toString();

        // 3. Save it to the database
        Prescription::create([
            'doctor_id' => Auth::id(),
            'patient_id' => $request->patient_id,
            'medication_id' => $request->medication_id,
            'qr_token' => $secureToken,
            'dosage_instructions' => $request->dosage_instructions,
            'days_supply_per_refill' => $request->days_supply_per_refill,
            'max_refills' => $request->max_refills,
            'refills_used' => 0,
        ]);

        // 4. Send the doctor back to the dashboard with a success message
        return redirect()->route('doctor.dashboard')->with('success', 'Prescription generated securely!');
    }
}