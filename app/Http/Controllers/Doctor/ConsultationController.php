<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\Encounter;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\SoapTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    public function show(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this consultation.');
        }

        $appointment->load('patient.patientProfile');
        $doctorProfile = DoctorProfile::where('user_id', Auth::id())->first();
        $triageVitals = $appointment->triage_vitals ?? [];

        // FETCH THE SOAP TEMPLATES
        $soapTemplates = SoapTemplate::where('doctor_id', Auth::id())->get();

        return view('doctor.prescribe', compact('appointment', 'doctorProfile', 'triageVitals', 'soapTemplates'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        // Ensure the appointment belongs to the logged-in doctor
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this consultation.');
        }

        $request->validate([
            'subjective_note' => 'nullable|string',
            'objective_note' => 'nullable|string',
            'assessment_note' => 'nullable|string',
            'plan_note' => 'nullable|string',
            'next_appointment_date' => 'nullable|date',
            'print_patient_name' => 'boolean',
            'general_instructions' => 'nullable|string',
            'medications' => 'nullable|array',
            'medications.*.medication_id' => 'required|integer',
            'medications.*.dose' => 'nullable|string',
            'medications.*.frequency' => 'nullable|string',
            'medications.*.duration' => 'nullable|string',
            'medications.*.pharmacist_instructions' => 'nullable|string',
            'medications.*.patient_instructions' => 'nullable|string',
            'medications.*.sig' => 'nullable|string',
            'medications.*.quantity' => 'nullable|integer',
        ]);

        // Initialize a variable to capture the UUID outside the transaction scope
        $prescriptionId = null;

        DB::transaction(function () use ($request, $appointment, &$prescriptionId) {
            // 1. Create Encounter record
            $encounter = Encounter::create([
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'subjective_note' => $request->subjective_note,
                'objective_note' => $request->objective_note,
                'assessment_note' => $request->assessment_note,
                'plan_note' => $request->plan_note,
                'encounter_date' => now(),
                'next_appointment_date' => $request->next_appointment_date,
            ]);

            // 2. Create Prescription record
            // Even if no medications, we might still have a prescription if there are general instructions
            if (($request->has('medications') && count($request->medications) > 0) || $request->filled('general_instructions')) {
                $prescription = Prescription::create([
                    'encounter_id' => $encounter->id,
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'print_patient_name' => $request->print_patient_name ?? false,
                    'general_instructions' => $request->general_instructions,
                    'status' => 'active',
                ]);

                // Capture the newly generated UUID (char(36))
                $prescriptionId = $prescription->id;

                // 3. Loop and save PrescriptionItem records
                if ($request->has('medications') && is_array($request->medications)) {
                    foreach ($request->medications as $medication) {
                        PrescriptionItem::create([
                            'prescription_id' => $prescription->id,
                            'medication_id' => $medication['medication_id'],
                            'dose' => $medication['dose'] ?? null,
                            'frequency' => $medication['frequency'] ?? null,
                            'duration' => $medication['duration'] ?? null,
                            'pharmacist_instructions' => $medication['pharmacist_instructions'] ?? null,
                            'patient_instructions' => $medication['patient_instructions'] ?? null,
                            'sig' => $medication['sig'] ?? null,
                            'quantity' => $medication['quantity'] ?? null,
                        ]);
                    }
                }
            }

            // 4. Update Appointment status
            $appointment->update([
                'status' => 'completed',
            ]);
        });

        // 5. Build the dynamic response payload for the frontend
        $responseData = [
            'success' => true,
            'message' => 'Consultation completed successfully.',
        ];

        // If a prescription was generated, pass the UUID and future PDF URL
        if ($prescriptionId) {
            $responseData['has_prescription'] = true;
            $responseData['prescription_id'] = $prescriptionId;

            // IMPORTANT: This uses a named route. Ensure this route exists in your web.php
            $responseData['pdf_url'] = route('doctor.prescription.pdf', ['id' => $prescriptionId]);
        } else {
            $responseData['has_prescription'] = false;
        }

        return response()->json($responseData);
    }
}
