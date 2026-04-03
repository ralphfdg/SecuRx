<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\DispensingLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\AuthorizedRepresentative;
use Illuminate\Support\Str;

class GuestVerificationController extends Controller
{
    /**
     * Step 1: Show the hardware scanner page.
     */
    public function index()
    {
        return view('verify'); // Loads your verify.blade.php
    }

    /**
     * Step 2: Catch the scanned UUID and show the Gatekeeper.
     */
    public function gatekeeper($qr_uuid)
    {
        // 1. Security Check: Is it a valid UUID format?
        if (!Str::isUuid($qr_uuid)) {
            return redirect()->route('home')->withErrors(['error' => 'Invalid QR Code Format.']);
        }

        // 2. Architect Check: Does this QR code actually exist in the database?
        $exists = Prescription::where('id', $qr_uuid)->exists();

        if (!$exists) {
            return redirect()->route('home')->withErrors(['error' => 'Invalid or Forged Prescription Code Detected.']);
        }

        // 3. Pass the valid UUID to the view
        return view('gatekeeper', ['qr_uuid' => $qr_uuid]);
    }

    /**
     * Step 3: Authenticate the PRC License and reveal the Payload.
     */
    public function decrypt(Request $request)
    {
        // 1. Validate the pharmacist's legal input
        $request->validate([
            'qr_uuid'       => 'required|uuid',
            'prc_license'   => 'required|string|min:5',
            'pharmacy_name' => 'required|string|max:255',
        ]);

        // 2. Fetch the highly relational data using Eager Loading to save database memory
        $prescription = Prescription::with([
            'patient', 
            'patient.patientProfile', 
            'patient.patientAllergies.medication', // Needed for the DUR red flag
            'doctor.doctorProfile', 
            'items.medication'
        ])
        ->where('id', $request->qr_uuid)
        ->firstOrFail();

        // 3. Check if it's already fully dispensed or expired
        if ($prescription->status !== 'active') {
             return back()->withErrors(['prc_license' => 'This prescription is no longer active (Status: ' . $prescription->status . ').']);
        }

        // 4. Temporarily store the pharmacist's credentials in the session 
        // This ensures the payload view knows WHO is looking at it, which is required for the audit log later.
        session([
            'guest_prc_license' => $request->prc_license,
            'guest_pharmacy'    => $request->pharmacy_name,
            'verified_qr_uuid'  => $request->qr_uuid
        ]);

        // 5. Send all the data to the Payload view
        return view('payload', compact('prescription'));
    }

    /**
     * Step 4: Save the Snapshot to the Dispensing Logs.
     */
    public function dispense(Request $request)
    {
        // 1. Security Check: Did they bypass the gatekeeper?
        if (!session()->has('guest_prc_license') || !session()->has('verified_qr_uuid')) {
            abort(403, 'Unauthorized Access. PRC License verification required.');
        }

        $uuid = session('verified_qr_uuid');

        // 2. Validate the incoming form data
        $request->validate([
            'dispensed_to'          => 'required|string',
            'receiver_id_presented' => 'required|string|max:255',
            'manual_name'           => 'required_if:dispensed_to,manual|string|max:255|nullable',
            'manual_relationship'   => 'required_if:dispensed_to,manual|string|max:255|nullable',
        ]);

        // 3. Fetch the Prescription
        $prescription = Prescription::with(['patient', 'items'])->findOrFail($uuid);

        if ($prescription->status !== 'active') {
            return back()->withErrors(['error' => 'This prescription is no longer active.']);
        }

        // 4. The Snapshot Logic Engine
        $receiverName = '';
        $receiverRelationship = '';
        $representativeId = null;

        if ($request->dispensed_to === 'self') {
            $receiverName = $prescription->patient->name;
            $receiverRelationship = 'Self (Patient)';
        } elseif ($request->dispensed_to === 'manual') {
            $receiverName = $request->manual_name;
            $receiverRelationship = $request->manual_relationship;
        } else {
            // They selected a pre-authorized representative from the dropdown
            $rep = AuthorizedRepresentative::where('id', $request->dispensed_to)
                    ->where('patient_id', $prescription->patient_id)
                    ->firstOrFail();
                    
            $receiverName = $rep->full_name;
            $receiverRelationship = $rep->relationship;
            $representativeId = $rep->id;
        }

        // 5. Database Transaction (Atomicity)
        DB::transaction(function () use ($prescription, $request, $receiverName, $receiverRelationship, $representativeId) {
        
            // Loop through the medicines and log each one
            foreach ($prescription->items as $item) {
                DispensingLog::create([
                    'prescription_item_id' => $item->id,
                    'pharmacist_id'        => null, // Null because it's a Guest
                    'guest_prc_license'    => session('guest_prc_license'),
                    'quantity_dispensed'   => $item->quantity,
                
                    // The Immutable Snapshots
                    'representative_id'              => $representativeId,
                    'receiver_name_snapshot'         => $receiverName,
                    'receiver_relationship_snapshot' => $receiverRelationship,
                    'receiver_id_presented'          => $request->receiver_id_presented,
                
                    'dispensed_at' => now(),
                ]);
            }

            // Lock the QR code so it can never be scanned again
            $prescription->update(['status' => 'dispensed']);
        });

        // 6. Security Cleanup: Wipe the session so the next patient is blank
        session()->forget(['guest_prc_license', 'guest_pharmacy', 'verified_qr_uuid']);

        // 7. Success Redirect
        // NOTE: You will need to add a generic success alert in your verify.blade.php to show this message
        return redirect()->route('verify.index')->with('success', 'Transaction legally logged. Prescription fulfilled and locked.');
    }
}