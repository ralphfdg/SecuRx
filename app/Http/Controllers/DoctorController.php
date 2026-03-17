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
    // 1. Load the Dashboard
    public function dashboard()
    {
        $patients = User::where('role', 'patient')->get();
        $medications = Medication::all();
        
        return view('doctor.dashboard', compact('patients', 'medications'));
    }

    // 2. Process the Form Submission
    public function storePrescription(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'medication_id' => 'required|exists:medications,id',
            'dosage_instructions' => 'required|string',
            'days_supply_per_refill' => 'required|integer',
            'max_refills' => 'required|integer',
        ]);

        // Generate the Cryptographic Token
        $secureToken = Str::uuid()->toString();

        // Save to Database
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

        return redirect()->route('doctor.dashboard')->with('success', 'Prescription generated securely!');
    }
}