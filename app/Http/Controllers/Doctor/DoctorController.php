<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PatientProfile;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctorId = Auth::id();
        $today = Carbon::today()->toDateString();

        // 1. Top Metrics (Today's Overview)
        $scheduledToday = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $today)
            ->count();

        $completedToday = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $today)
            ->where('status', 'completed')
            ->count();

        $rxIssuedToday = DB::table('prescriptions')
            ->where('doctor_id', $doctorId)
            ->whereDate('created_at', clone Carbon::today())
            ->count();

        // 2. DUR Alerts (Trailing 30 Days)
        // Connects overrides -> dispensing logs -> prescription items -> prescriptions
        $durAlertsCount = DB::table('override_justifications')
            ->join('dispensing_logs', 'override_justifications.dispensing_log_id', '=', 'dispensing_logs.id')
            ->join('prescription_items', 'dispensing_logs.prescription_item_id', '=', 'prescription_items.id')
            ->join('prescriptions', 'prescription_items.prescription_id', '=', 'prescriptions.id')
            ->where('prescriptions.doctor_id', $doctorId)
            ->where('override_justifications.created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        // 3. Live Waiting Queue (Next 5 Pending/Confirmed for Today)
        $waitingQueue = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->where('appointment_date', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        // 4. Top Prescribed Medications (Trailing 30 Days for Chart)
        $topMedications = DB::table('prescription_items')
            ->select('medications.generic_name', DB::raw('count(*) as total'))
            ->join('medications', 'prescription_items.medication_id', '=', 'medications.id')
            ->join('prescriptions', 'prescription_items.prescription_id', '=', 'prescriptions.id')
            ->where('prescriptions.doctor_id', $doctorId)
            ->where('prescriptions.created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('medications.generic_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Format for Chart.js
        $chartLabels = $topMedications->pluck('generic_name')->toJson();
        $chartData = $topMedications->pluck('total')->toJson();

        // 5. Recent DUR Flags (Pharmacist Overrides)
        $recentDurFlags = DB::table('override_justifications')
            ->select(
                'override_justifications.warning_type',
                'override_justifications.justification_note',
                'override_justifications.created_at',
                'users.last_name as patient_last_name',
                'medications.generic_name'
            )
            ->join('dispensing_logs', 'override_justifications.dispensing_log_id', '=', 'dispensing_logs.id')
            ->join('prescription_items', 'dispensing_logs.prescription_item_id', '=', 'prescription_items.id')
            ->join('medications', 'prescription_items.medication_id', '=', 'medications.id')
            ->join('prescriptions', 'prescription_items.prescription_id', '=', 'prescriptions.id')
            ->join('users', 'prescriptions.patient_id', '=', 'users.id')
            ->where('prescriptions.doctor_id', $doctorId)
            ->orderByDesc('override_justifications.created_at')
            ->take(3)
            ->get();

        return view('doctor.dashboard', compact(
            'scheduledToday', 'completedToday', 'rxIssuedToday',
            'durAlertsCount', 'waitingQueue', 'chartLabels',
            'chartData', 'recentDurFlags'
        ));
    }

    public function directory(Request $request)
    {
        $query = User::where('role', 'patient')->with('patientProfile');

        // Handle Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('id', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('mobile_num', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Handle Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'z-a': $query->orderBy('last_name', 'desc');
                    break;
                case 'newest': $query->orderBy('created_at', 'desc');
                    break;
                default: $query->orderBy('last_name', 'asc');
                    break; // a-z
            }
        } else {
            $query->orderBy('last_name', 'asc');
        }

        $patients = $query->paginate(10)->withQueryString();

        return view('doctor.directory', compact('patients'));
    }

    public function storePatient(Request $request)
    {
        $request->validate([
            // Core User Fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'qualifier' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'mobile_num' => 'nullable|string',
            'email' => 'required|email|unique:users,email', // Enforced due to NOT NULL constraint

            // Generated by your upcoming JS Button
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',

            // Profile Fields
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'address' => 'nullable|string',
            'school_work' => 'nullable|string',
            'mother_name' => 'nullable|string|max:255',
            'mother_contact' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_contact' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // Safely concatenate the full name
            $nameParts = array_filter([
                $request->first_name,
                $request->middle_name,
                $request->last_name,
                $request->qualifier,
            ]);
            $fullName = implode(' ', $nameParts);

            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'qualifier' => $request->qualifier,
                'name' => $fullName,
                'username' => $request->username,
                'email' => $request->email,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'mobile_num' => $request->mobile_num,
                'password' => Hash::make($request->password),
                'role' => 'patient',
                'status' => 'active',
            ]);

            PatientProfile::create([
                'user_id' => $user->id,
                'height' => $request->height,
                'weight' => $request->weight,
                'address' => $request->address,
                'school_work' => $request->school_work,
                'mother_name' => $request->mother_name,
                'mother_contact' => $request->mother_contact,
                'father_name' => $request->father_name,
                'father_contact' => $request->father_contact,
                'data_consent' => $request->has('data_consent') ? 1 : 0,
            ]);
        });

        return redirect()->back()->with('success', 'Patient registered successfully.');
    }

    public function updatePatient(Request $request, $id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'qualifier' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string',
            'mobile_num' => 'nullable|string',
            // Ignore the current patient's email during unique validation
            'email' => 'required|email|unique:users,email,'.$patient->id,

            // Profile Fields
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'address' => 'nullable|string',
            'school_work' => 'nullable|string',
            'mother_name' => 'nullable|string|max:255',
            'mother_contact' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_contact' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $patient) {
            // Safely concatenate the full name
            $nameParts = array_filter([
                $request->first_name,
                $request->middle_name,
                $request->last_name,
                $request->qualifier,
            ]);
            $fullName = implode(' ', $nameParts);

            $patient->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'qualifier' => $request->qualifier,
                'name' => $fullName,
                'email' => $request->email,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'mobile_num' => $request->mobile_num,
            ]);

            // updateOrCreate ensures we don't crash if an old patient somehow lacks a profile row
            $patient->patientProfile()->updateOrCreate(
                ['user_id' => $patient->id],
                [
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'address' => $request->address,
                    'school_work' => $request->school_work,
                    'mother_name' => $request->mother_name,
                    'mother_contact' => $request->mother_contact,
                    'father_name' => $request->father_name,
                    'father_contact' => $request->father_contact,
                ]
            );
        });

        return redirect()->back()->with('success', 'Patient updated successfully.');
    }

    public function patientRecords($id)
    {
        $patient = User::with('patientProfile')
            ->where('role', 'patient')
            ->findOrFail($id);

        // 1. Encounters (Added SOAP Notes)
        $encounters = DB::table('encounters')
            ->where('patient_id', $id)
            ->select(
                'id',
                DB::raw("COALESCE(encounter_title, 'Clinical Encounter') as title"),
                'encounter_date as date',
                DB::raw("'encounter' as type"),
                DB::raw('1 as is_verified'),
                'subjective_note', 'objective_note', 'assessment_note', 'plan_note'
            )
            ->get();

        // 2. Lab Results (Added file_path)
        $labResults = DB::table('lab_results')
            ->where('patient_id', $id)
            ->select(
                'id',
                DB::raw("COALESCE(test_name, 'Laboratory Result') as title"),
                'test_date as date',
                DB::raw("'lab_result' as type"),
                'is_verified',
                'file_path'
            )
            ->get();

        // 3. Medical Documents (Added file_path)
        $documents = DB::table('medical_documents')
            ->where('patient_id', $id)
            ->select(
                'id',
                DB::raw("COALESCE(document_name, 'Medical Document') as title"),
                DB::raw('COALESCE(created_at, updated_at, CURRENT_TIMESTAMP) as date'),
                DB::raw("'document' as type"),
                'is_verified',
                'file_path'
            )
            ->get();

        // 4. Immunizations (Added facility and valid_until)
        $immunizations = DB::table('immunizations')
            ->where('patient_id', $id)
            ->select(
                'id',
                DB::raw("COALESCE(vaccine_name, 'Immunization Record') as title"),
                'administered_date as date',
                DB::raw("'immunization' as type"),
                'is_verified',
                'facility', 'valid_until'
            )
            ->get();

        // 5. Allergies (Added reaction)
        $allergies = DB::table('patient_allergies')
            ->where('patient_id', $id)
            ->select(
                'id',
                DB::raw("CONCAT_WS(' - ', CONCAT('Allergy: ', allergen_name), COALESCE(severity, 'Unspecified')) as title"),
                DB::raw('COALESCE(created_at, updated_at, CURRENT_TIMESTAMP) as date'),
                DB::raw("'allergy' as type"),
                'is_verified',
                'reaction'
            )
            ->get();

        // Combine and Sort
        $timeline = collect([])
            ->concat($encounters)
            ->concat($labResults)
            ->concat($documents)
            ->concat($immunizations)
            ->concat($allergies)
            ->sortByDesc('date')
            ->values();

        // 2. Return BOTH the Profile and the Timeline
        return response()->json([
            'profile' => [
                'name' => $patient->name,
                'dob' => $patient->dob,
                'gender' => $patient->gender,
                'mobile_num' => $patient->mobile_num,
                'height' => $patient->patientProfile->height ?? '--',
                'weight' => $patient->patientProfile->weight ?? '--',
                'address' => $patient->patientProfile->address ?? 'No address on file',
                'mother' => $patient->patientProfile->mother_name ? ($patient->patientProfile->mother_name.' - '.$patient->patientProfile->mother_contact) : 'N/A',
                'father' => $patient->patientProfile->father_name ? ($patient->patientProfile->father_name.' - '.$patient->patientProfile->father_contact) : 'N/A',
            ],
            'timeline' => $timeline,
        ]);
    }

    // NEW METHOD: Handles the verification action from the frontend
    public function verifyRecord(Request $request)
    {
        $request->validate([
            'id' => 'required|string|size:36', // Ensure it matches your char(36) UUIDs
            'type' => 'required|string|in:lab_result,document,immunization,allergy',
        ]);

        // Map the frontend 'type' to the actual database table name
        $tableMap = [
            'lab_result' => 'lab_results',
            'document' => 'medical_documents',
            'immunization' => 'immunizations',
            'allergy' => 'patient_allergies',
        ];

        $tableName = $tableMap[$request->type];

        // Update the specific record
        DB::table($tableName)
            ->where('id', $request->id)
            ->update(['is_verified' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Record officially verified.',
        ]);
    }

    public function searchMedications(Request $request)
    {
        $query = $request->get('q');

        $medications = DB::table('medications')
            ->select(
                'medications.*',
                'dpri_records.lowest_price',
                'dpri_records.median_price',
                'dpri_records.highest_price',
                'dpri_records.doh_raw_drug_name' // 1. Pull the DOH string
            )
            ->leftJoin('dpri_records', 'medications.id', '=', 'dpri_records.medication_id')
            ->where(function ($q) use ($query) {
                // Always group your OR statements when using joins!
                $q->where('medications.generic_name', 'LIKE', "%{$query}%")
                    ->orWhere('medications.brand_name', 'LIKE', "%{$query}%");
            })
            ->limit(20)
            ->get()
            ->map(function ($med) {
                // 1. Get the base name (prioritize DOH, fallback to generic)
                $baseName = $med->doh_raw_drug_name ?? $med->generic_name;

                // 2. Explicitly append Dosage Strength and Form (e.g., "500mg Capsule")
                $dosageAndForm = trim(($med->dosage_strength ?? '').' '.($med->form ?? ''));
                if (! empty($dosageAndForm)) {
                    $baseName .= ' '.$dosageAndForm;
                }

                // 3. Append the brand name in parentheses if it exists
                if (! empty($med->brand_name)) {
                    $baseName .= ' ('.$med->brand_name.')';
                }

                // Attach it as a new property called 'display_name'
                $med->display_name = trim(strtoupper($baseName));

                return $med;
            });

        return response()->json($medications);
    }

    public function checkDur(Request $request)
    {
        $rxcui = $request->input('rxcui');
        $patientId = $request->input('patient_id');
        $currentRxcuis = (array) $request->input('current_rxcuis', []);

        $alerts = [];
        $debug_logs = [];
        $trigger_drawer = false;

        // 1. Baseline Allergies
        $allergies = DB::table('patient_allergies')->where('patient_id', $patientId)->get();
        foreach ($allergies as $allergy) {
            $alerts[] = [
                'type' => 'allergy',
                'severity' => 'high',
                'title' => 'Baseline Patient Allergy',
                'source' => 'Medical History',
                'message' => "Documented baseline allergy to {$allergy->allergen_name}.",
            ];
        }

        if ($rxcui) {
            // Grab the generic name of the NEW drug
            $newMedication = DB::table('medications')->where('rxcui', $rxcui)->first();

            // --- CLEAN TARGET NAME ---
            // We get the first word (e.g., "Amoxicillin") and strip non-alpha chars
            $targetGenericName = $newMedication ? explode(' ', $newMedication->generic_name)[0] : '';
            $newMedName = preg_replace('/[^A-Za-z]/', '', $targetGenericName);

            // 2. Direct Allergy Match
            foreach ($allergies as $allergy) {
                if (stripos($newMedName, $allergy->allergen_name) !== false || stripos($allergy->allergen_name, $newMedName) !== false) {
                    $alerts[] = [
                        'type' => 'allergy',
                        'severity' => 'high',
                        'title' => "ALLERGY CONFLICT: {$newMedName}",
                        'source' => 'Patient Profile',
                        'message' => "CRITICAL: The patient has a documented allergy to the drug you just selected ({$allergy->allergen_name}).",
                    ];
                    $trigger_drawer = true;
                }
            }

            // 3. FDA Interaction Check
            $activeMeds = DB::table('prescriptions')
                ->join('prescription_items', 'prescriptions.id', '=', 'prescription_items.prescription_id')
                ->join('medications', 'prescription_items.medication_id', '=', 'medications.id')
                ->where('prescriptions.patient_id', $patientId)
                ->where('prescriptions.status', 'active')
                ->pluck('medications.generic_name')
                ->toArray();

            $cartMeds = DB::table('medications')
                ->whereIn('rxcui', $currentRxcuis)
                ->pluck('generic_name')
                ->toArray();

            $sourceMap = [];
            foreach ($activeMeds as $name) {
                $sourceMap[$name] = 'Active Prescription';
            }
            foreach ($cartMeds as $name) {
                $sourceMap[$name] = 'Current Session';
            }

            // --- THE CRITICAL FIX: EXCLUSION LOGIC ---
            // Merge all names, make them unique, and filter out the one we are currently checking
            $allExistingNames = array_filter(
                array_unique(array_merge($activeMeds, $cartMeds)),
                function ($existingName) use ($newMedName) {
                    // Remove if the existing name starts with the same word as our target (e.g., Amoxicillin)
                    $cleanedExisting = preg_replace('/[^A-Za-z]/', '', explode(' ', $existingName)[0]);

                    return strcasecmp($cleanedExisting, $newMedName) !== 0;
                }
            );

            $client = new Client(['verify' => false, 'timeout' => 5]);
            $apiKey = env('OPENFDA_API_KEY', '');
            $authParam = $apiKey ? "api_key={$apiKey}&" : '';

            foreach ($allExistingNames as $existingDrugName) {
                $cleanedName = preg_replace('/[^A-Za-z]/', '', explode(' ', $existingDrugName)[0]);

                // Interaction Check URL 1 & 2
                $query1 = "openfda.rxcui:\"{$rxcui}\"+AND+drug_interactions:{$cleanedName}";
                $url1 = "https://api.fda.gov/drug/label.json?{$authParam}search={$query1}&limit=1";

                $query2 = "openfda.generic_name:\"{$cleanedName}\"+AND+drug_interactions:{$newMedName}";
                $url2 = "https://api.fda.gov/drug/label.json?{$authParam}search={$query2}&limit=1";

                $urlsToTest = [$url1, $url2];
                $interactionFound = false;

                foreach ($urlsToTest as $url) {
                    if ($interactionFound) {
                        break;
                    }

                    try {
                        $response = $client->request('GET', $url);
                        if ($response->getStatusCode() == 200) {
                            $data = json_decode($response->getBody(), true);
                            if (isset($data['results'][0]['drug_interactions'])) {
                                $origin = $sourceMap[$existingDrugName] ?? 'Active Record';
                                $alerts[] = [
                                    'type' => 'interaction',
                                    'severity' => 'high',
                                    'title' => "{$newMedName} + {$cleanedName}",
                                    'source' => $origin,
                                    'message' => $data['results'][0]['drug_interactions'][0],
                                ];
                                $trigger_drawer = true;
                                $interactionFound = true;
                            }
                        }
                    } catch (\Exception $e) {
                        // Log or ignore 404/Network errors
                    }
                }
            }
        }

        return response()->json([
            'has_alerts' => count($alerts) > 0,
            'trigger_drawer' => $trigger_drawer,
            'alerts' => $alerts,
            'debug' => $debug_logs,
        ]);
    }
}
