<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\ScanLog;
use Illuminate\Support\Facades\Auth;

class PharmacistController extends Controller
{
    public function dashboard()
    {
        return view('pharmacist.dashboard');
    }

    // THE SCANNER API
    public function verifyQr(Request $request)
    {
        // Require the frontend to send a valid UUID string
        $request->validate([
            'qr_token' => 'required|uuid'
        ]);

        // Search the database for the exact token and pull all related names
        $prescription = Prescription::with(['patient', 'doctor', 'medication'])
            ->where('qr_token', $request->qr_token)
            ->first();

        // If no match is found, it's a counterfeit QR code
        if (!$prescription) {
            return response()->json([
                'status' => 'error',
                'message' => 'SECURITY ALERT: Invalid or Counterfeit QR Code detected.'
            ], 404);
        }

        // --- THE TELEMETRY WARNING ---
        $warnings = [];

        // Flag 1: Hard Limit Reached
        if ($prescription->refills_used >= $prescription->max_refills) {
            $warnings[] = "⚠️ Maximum authorized refills ({$prescription->max_refills}) have already been dispensed.";
        }

        // Flag 2: Pacing Algorithm (Are they refilling too early?)
        $lastScan = ScanLog::where('prescription_id', $prescription->id)
            ->where('was_dispensed', true)
            ->latest('scanned_at')
            ->first();

        if ($lastScan) {
            $daysSinceLastRefill = now()->diffInDays($lastScan->scanned_at);
            $expectedDuration = $prescription->days_supply_per_refill;

            // If they come back with more than 5 days of medicine theoretically left
            if ($daysSinceLastRefill < ($expectedDuration - 5)) {
                $warnings[] = "⚠️ Early Refill Alert: Patient should still have medicine for " . ($expectedDuration - $daysSinceLastRefill) . " more days.";
            }
        }

        // Return all the data back to frontend scanner
        return response()->json([
            'status' => 'success',
            'data' => $prescription,
            'warnings' => $warnings
        ]);
    }

    //THE DISPENSE LOGIC
    public function dispense(Request $request)
    {
        $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id'
        ]);

        $prescription = Prescription::findOrFail($request->prescription_id);

        // Update the counter
        $prescription->increment('refills_used');

        // Create the permanent un-deletable audit log
        ScanLog::create([
            'prescription_id' => $prescription->id,
            'pharmacist_id' => Auth::id(),
            'was_dispensed' => true,
        ]);

        return redirect()->route('pharmacist.dashboard')->with('success', 'Medication dispensed and permanently logged.');
    }
}