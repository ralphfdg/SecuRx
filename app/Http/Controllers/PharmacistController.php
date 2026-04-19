<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Prescription;
use App\Models\PatientAllergy;
use App\Models\DispensingLog;
use App\Models\PrescriptionItem;
use Carbon\Carbon;
use GuzzleHttp\Client;

class PharmacistController extends Controller
{
    public function scanner()
    {
        return view('pharmacist.scanner');
    }

    public function processScan(Request $request)
    {
        $request->validate(['prescription_uuid' => 'required|string|size:36']);

        $prescription = Prescription::with([
            'patient.patientProfile',
            'doctor.doctorProfile',
            'items.medication'
        ])->find($request->prescription_uuid);

        if (!$prescription) {
            return response()->json(['message' => 'Cryptographic signature invalid.'], 404);
        }

        if ($prescription->status !== 'active') {
            return response()->json(['message' => 'Transaction blocked. Status: ' . strtoupper($prescription->status)], 403);
        }

        $durWarnings = [];
        $patientAllergies = PatientAllergy::where('patient_id', $prescription->patient_id)->get();

        foreach ($prescription->items as $item) {
            // Allergy Check
            foreach ($patientAllergies as $allergy) {
                if (stripos($item->medication->generic_name, $allergy->allergen_name) !== false) {
                    $durWarnings[] = [
                        'type' => 'Allergy',
                        'level' => 'Severe',
                        'message' => "Verified allergy to {$allergy->allergen_name}. High cross-reactivity risk."
                    ];
                }
            }

            // Time-Gate Check (Fixed Timestamp)
            $lastDispense = DispensingLog::where('prescription_item_id', $item->id)
                ->orderBy('dispensed_at', 'desc')
                ->first();

            if ($lastDispense) {
                $hoursSinceLastDispense = Carbon::parse($lastDispense->dispensed_at)->diffInHours(now());
                if ($hoursSinceLastDispense < 24) {
                    $durWarnings[] = [
                        'type' => 'Time-Gate',
                        'level' => 'Warning',
                        'message' => "Early Refill Attempt. Last dispensed {$hoursSinceLastDispense} hours ago."
                    ];
                }
            }
        }

        return response()->json([
            'id' => $prescription->id,
            'date' => $prescription->created_at->format('m/d/Y'), // New Field
            'patient' => [
                'name' => $prescription->patient->first_name . ' ' . $prescription->patient->last_name,
                'age' => Carbon::parse($prescription->patient->dob)->age,
                'sex' => substr($prescription->patient->gender, 0, 1)
            ],
            'doctor' => [
                'name' => 'Dr. ' . $prescription->doctor->first_name . ' ' . $prescription->doctor->last_name,
                'prc_license' => $prescription->doctor->doctorProfile->prc_number ?? 'N/A',
                'ptr_number' => $prescription->doctor->doctorProfile->ptr_number ?? 'N/A',
                // Fallbacks if you haven't linked the clinic table yet
                'clinic_name' => 'MEDICAL CLINIC INC.',
                'clinic_address' => '123 Health Avenue, Medical District, City',
                'contact_number' => '(000) 123-4567',
            ],
            'items' => $prescription->items->map(function ($item) {
                return [
                    'item_id' => $item->id,
                    'brand_name' => $item->medication->brand_name,
                    'generic_name' => $item->medication->generic_name,
                    'dosage' => $item->medication->dosage_strength,
                    'sig' => $item->sig,
                    'quantity' => $item->quantity,
                    'dispense_as_written' => $item->pharmacist_instructions
                ];
            }),
            'dur_warnings' => $durWarnings
        ]);
    }

    public function dispense($prescription_id)
    {
        $prescription = Prescription::with([
            'patient.patientProfile', 
            'items.medication', 
            'doctor.doctorProfile.clinic'
        ])->findOrFail($prescription_id);

        if ($prescription->status !== 'active') {
            return redirect()->route('pharmacist.scanner')->with('error', 'Prescription is no longer active.');
        }

        $durWarnings = [];
        $patientAllergies = DB::table('patient_allergies')->where('patient_id', $prescription->patient_id)->get();
        
        $pastActiveMeds = \App\Models\PrescriptionItem::whereHas('prescription', function($query) use ($prescription) {
            $query->where('patient_id', $prescription->patient_id)
                  ->where('id', '!=', $prescription->id)
                  ->whereIn('status', ['active', 'partially_dispensed']);
        })->with('medication')->get();

        $medsToCheck = [];

        foreach ($prescription->items as $item) {
            if ($item->status === 'completed') continue;
            
            $targetGeneric = explode(' ', $item->medication->generic_name)[0];
            $cleanedName = preg_replace('/[^A-Za-z]/', '', $targetGeneric);

            $medsToCheck[] = [
                'id' => $item->id,
                'rxcui' => $item->medication->rxcui,
                'cleaned_name' => $cleanedName,
                'brand_name' => $item->medication->brand_name,
                'source' => 'Current Prescription'
            ];

            // 1. SEVERE: Allergy Conflict (RED)
            foreach ($patientAllergies as $allergy) {
                if (stripos($cleanedName, $allergy->allergen_name) !== false || stripos($allergy->allergen_name, $cleanedName) !== false) {
                    $durWarnings[] = [
                        'type' => 'Allergy Conflict',
                        'level' => 'Severe',
                        'item' => $item->medication->brand_name,
                        'message' => "CRITICAL: The patient has a documented allergy to {$allergy->allergen_name}."
                    ];
                }
            }

            // 2. ADVISORY: Early Refill / Time-Gate (BLUE)
            $lastDispense = \App\Models\DispensingLog::where('prescription_item_id', $item->id)->orderBy('dispensed_at', 'desc')->first();
            if ($lastDispense) {
                $hours = \Carbon\Carbon::parse($lastDispense->dispensed_at)->diffInHours(now());
                if ($hours < 24) {
                    $durWarnings[] = [
                        'type' => 'Early Refill', 
                        'level' => 'Advisory', 
                        'item' => $item->medication->brand_name, 
                        'message' => "Advisory: This medication was last dispensed only {$hours} hours ago."
                    ];
                }
            }
        }

        foreach ($pastActiveMeds as $pastMed) {
            $targetGeneric = explode(' ', $pastMed->medication->generic_name)[0];
            $medsToCheck[] = [
                'id' => $pastMed->id,
                'rxcui' => $pastMed->medication->rxcui,
                'cleaned_name' => preg_replace('/[^A-Za-z]/', '', $targetGeneric),
                'brand_name' => $pastMed->medication->brand_name,
                'source' => 'Active Medical History'
            ];
        }

        // 3. WARNING: FDA Drug Interaction (YELLOW)
        $client = new \GuzzleHttp\Client(['verify' => false, 'timeout' => 5]);
        $apiKey = env('OPENFDA_API_KEY', '');
        $authParam = $apiKey ? "api_key={$apiKey}&" : '';
        $checkedPairs = [];

        for ($i = 0; $i < count($medsToCheck); $i++) {
            for ($j = $i + 1; $j < count($medsToCheck); $j++) {
                $drugA = $medsToCheck[$i];
                $drugB = $medsToCheck[$j];

                if ($drugA['source'] === 'Active Medical History' && $drugB['source'] === 'Active Medical History') continue;
                if (strcasecmp($drugA['cleaned_name'], $drugB['cleaned_name']) === 0) continue;

                $pairKey = $drugA['cleaned_name'] . '-' . $drugB['cleaned_name'];
                if (in_array($pairKey, $checkedPairs)) continue;
                $checkedPairs[] = $pairKey;

                $query1 = "openfda.rxcui:\"{$drugA['rxcui']}\"+AND+drug_interactions:{$drugB['cleaned_name']}";
                $url1 = "https://api.fda.gov/drug/label.json?{$authParam}search={$query1}&limit=1";

                $query2 = "openfda.generic_name:\"{$drugB['cleaned_name']}\"+AND+drug_interactions:{$drugA['cleaned_name']}";
                $url2 = "https://api.fda.gov/drug/label.json?{$authParam}search={$query2}&limit=1";

                foreach ([$url1, $url2] as $url) {
                    try {
                        $response = $client->request('GET', $url);
                        if ($response->getStatusCode() == 200) {
                            $data = json_decode($response->getBody(), true);
                            if (isset($data['results'][0]['drug_interactions'])) {
                                $durWarnings[] = [
                                    'type' => 'FDA Clinical Interaction',
                                    'level' => 'Warning', // Mapped to Yellow
                                    'item' => strtoupper($drugA['brand_name']) . " + " . strtoupper($drugB['brand_name']),
                                    'message' => \Illuminate\Support\Str::limit($data['results'][0]['drug_interactions'][0], 250)
                                ];
                                break;
                            }
                        }
                    } catch (\Exception $e) {}
                }
            }
        }

        return view('pharmacist.dispense', compact('prescription', 'durWarnings'));
    }

    public function processDispense(Request $request, $prescription_id)
    {
        // Added Validation for Receiver/Proxy
        $request->validate([
            'receiver_id_presented' => 'required|string|max:255',
            'is_proxy' => 'required|boolean',
            'representative_name' => 'nullable|required_if:is_proxy,true|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:prescription_items,id',
            'items.*.actual_drug_dispensed' => 'required|string|max:255',
            'items.*.quantity_dispensed' => 'required|integer|min:1',
            'items.*.lot_number' => 'required|string|max:255',
            'items.*.expiry_date' => 'required|date|after:today',
            'global_override_reason' => 'nullable|string'
        ]);

        try {
            DB::transaction(function () use ($request, $prescription_id) {
                
                // Format the Receiver String safely for the database
                $receiverString = $request->is_proxy 
                    ? "PROXY: " . $request->representative_name . " (ID: " . $request->receiver_id_presented . ")"
                    : "PATIENT ID: " . $request->receiver_id_presented;

                foreach ($request->items as $data) {
                    $item = PrescriptionItem::findOrFail($data['item_id']);

                    $currentRemaining = $item->quantity_remaining ?? $item->quantity;
                    if ($data['quantity_dispensed'] > $currentRemaining) {
                        throw new \Exception("Cannot dispense more than the remaining quantity for " . $item->medication->brand_name);
                    }

                    $newRemaining = $currentRemaining - $data['quantity_dispensed'];
                    $item->update([
                        'quantity_remaining' => $newRemaining,
                        'status' => ($newRemaining === 0) ? 'completed' : 'partially_dispensed'
                    ]);

                    $log = DispensingLog::create([
                        'id' => Str::uuid(),
                        'prescription_item_id' => $item->id,
                        /** @disregard P1013 */
                        'pharmacist_id' => auth()->id(),
                        'receiver_id_presented' => $receiverString, // Fixes SQL error!
                        'quantity_dispensed' => $data['quantity_dispensed'],
                        'actual_drug_dispensed' => $data['actual_drug_dispensed'],
                        'lot_number' => $data['lot_number'],
                        'expiry_date' => $data['expiry_date'],
                    ]);

                    if ($request->filled('global_override_reason')) {
                        DB::table('override_justifications')->insert([
                            'id' => Str::uuid(),
                            'dispensing_log_id' => $log->id,
                            'warning_type' => 'clinical_override', 
                            'justification_note' => $request->global_override_reason
                        ]);
                    }
                }

                $prescription = Prescription::with('items')->find($prescription_id);
                if ($prescription->items->every(fn($i) => $i->status === 'completed')) {
                    $prescription->update(['status' => 'dispensed']);
                }
            });

            return response()->json(['message' => 'Bulk transaction successfully logged.']);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}