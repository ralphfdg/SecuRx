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
use Illuminate\Support\Str;

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

        $patients = $query->paginate(15)->withQueryString();

        return view('doctor.directory', compact('patients'));
    }

    public function storePatient(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'mobile_num' => 'required|string',
            'email' => 'nullable|email|unique:users,email',
        ]);

        DB::transaction(function () use ($request) {
            $password = $request->has('generate_password') ? Str::random(10) : 'password123';

            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'qualifier' => $request->qualifier,
                'name' => $request->name,
                'username' => strtolower($request->first_name).'_'.time(),
                'email' => $request->email,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'mobile_num' => $request->mobile_num,
                'password' => Hash::make($password),
                'role' => 'patient',
                'status' => 'active',
            ]);

            // Assuming you have a PatientProfile model linking to the patient_profiles table
            PatientProfile::create([
                'user_id' => $user->id,
                'height' => $request->height,
                'weight' => $request->weight,
                // Add address and family contacts here if they exist in your migration
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
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'mobile_num' => 'required|string',
            'email' => 'nullable|email|unique:users,email,'.$patient->id,
        ]);

        DB::transaction(function () use ($request, $patient) {
            $patient->update($request->only([
                'first_name', 'middle_name', 'last_name', 'qualifier',
                'name', 'email', 'dob', 'gender', 'mobile_num',
            ]));

            $patient->patientProfile()->updateOrCreate(
                ['user_id' => $patient->id],
                $request->only(['height', 'weight']) // Add other fields as needed
            );
        });

        return redirect()->back()->with('success', 'Patient updated successfully.');
    }

    public function patientRecords($id)
    {
        $encounters = DB::table('encounters')
            ->where('patient_id', $id)
            ->select('id', 'encounter_title as title', 'encounter_date as date', DB::raw("'encounter' as type"))
            ->get();

        $labResults = DB::table('lab_results')
            ->where('patient_id', $id)
            ->where('is_verified', 1)
            ->select('id', 'test_name as title', 'test_date as date', DB::raw("'lab_result' as type"))
            ->get();

        $documents = DB::table('medical_documents')
            ->where('patient_id', $id)
            ->where('is_verified', 1)
            ->select('id', 'document_name as title', 'created_at as date', DB::raw("'document' as type"))
            ->get();

        $immunizations = DB::table('immunizations')
            ->where('patient_id', $id)
            ->where('is_verified', 1)
            ->select('id', 'vaccine_name as title', 'administered_date as date', DB::raw("'immunization' as type"))
            ->get();

        $allergies = DB::table('patient_allergies')
            ->where('patient_id', $id)
            ->where('is_verified', 1)
            ->select('id', DB::raw("CONCAT('Allergy: ', allergen_name) as title"), 'created_at as date', DB::raw("'allergy' as type"))
            ->get();

        $timeline = collect([])
            ->concat($encounters)
            ->concat($labResults)
            ->concat($documents)
            ->concat($immunizations)
            ->concat($allergies)
            ->sortByDesc('date')
            ->values();

        return response()->json([
            'timeline' => $timeline,
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
                // 2. Format a beautiful display name for the frontend
                // Prioritize DOH name. If missing, combine generic name + dosage
                $baseName = $med->doh_raw_drug_name ?? ($med->generic_name.' '.($med->dosage_strength ?? ''));

                // Append the brand name in parentheses if it exists
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

        $alerts = [];

        // Check 1: Allergies (If rxcui matches or we do a simple check. Since our allergy schema doesn't have rxcui, we check medication_id or name if passed)
        // For simplicity, if medication_id was provided we could use it, but prompt says "accept the selected drug's rxcui". We'll do a join if needed.
        if ($rxcui) {
            $medication = DB::table('medications')->where('rxcui', $rxcui)->first();
            if ($medication) {
                $allergies = DB::table('patient_allergies')
                    ->where('patient_id', $patientId)
                    ->where(function ($q) use ($medication) {
                        $q->where('medication_id', $medication->id)
                            ->orWhere('allergen_name', 'LIKE', '%'.$medication->generic_name.'%');
                    })
                    ->get();

                foreach ($allergies as $allergy) {
                    $alerts[] = [
                        'type' => 'allergy',
                        'severity' => $allergy->severity ?? 'high',
                        'message' => 'Patient has a documented allergy to '.($allergy->allergen_name ?? $medication->generic_name).'.',
                    ];
                }
            }

            // Check 2: Active Prescriptions Interactions
            $activePrescriptions = DB::table('prescriptions')
                ->join('prescription_items', 'prescriptions.id', '=', 'prescription_items.prescription_id')
                ->join('medications', 'prescription_items.medication_id', '=', 'medications.id')
                ->where('prescriptions.patient_id', $patientId)
                ->where('prescriptions.status', 'active')
                ->whereNotNull('medications.rxcui')
                ->select('medications.rxcui', 'medications.generic_name')
                ->get();

            $activeRxCuis = $activePrescriptions->pluck('rxcui')->unique()->filter()->toArray();

            if (! empty($activeRxCuis) && ! in_array($rxcui, $activeRxCuis)) {
                $activeRxCuis[] = $rxcui;
                $rxcuisString = implode('+', $activeRxCuis);

                try {
                    $client = new Client;
                    $response = $client->request('GET', "https://rxnav.nlm.nih.gov/REST/interaction/list.json?rxcuis={$rxcuisString}");

                    if ($response->getStatusCode() == 200) {
                        $data = json_decode($response->getBody(), true);
                        if (isset($data['fullInteractionTypeGroup'])) {
                            foreach ($data['fullInteractionTypeGroup'] as $group) {
                                foreach ($group['fullInteractionType'] as $interactionType) {
                                    $involvesNewDrug = false;
                                    foreach ($interactionType['minConcept'] as $concept) {
                                        if ($concept['rxcui'] == $rxcui) {
                                            $involvesNewDrug = true;
                                            break;
                                        }
                                    }

                                    if ($involvesNewDrug) {
                                        foreach ($interactionType['interactionPair'] as $pair) {
                                            $alerts[] = [
                                                'type' => 'interaction',
                                                'severity' => $pair['severity'] ?? 'warning',
                                                'message' => $pair['description'] ?? 'Potential drug interaction detected.',
                                            ];
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // Fail silently or log
                }
            }
        }

        return response()->json([
            'has_alerts' => count($alerts) > 0,
            'alerts' => $alerts,
        ]);
    }
}
