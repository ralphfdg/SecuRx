<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Encounter;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class HistoryController extends Controller
{
    /**
     * Reusable query builder for both Index and CSV Export
     */
    private function buildHistoryQuery(Request $request)
    {
        $doctorId = Auth::id();

        // Base query
        $query = Encounter::with(['patient', 'prescriptions'])
            ->where('doctor_id', $doctorId);

        // 1. Handle Search (Name, ID, Diagnosis)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($patientQuery) use ($search) {
                    $patientQuery->where('name', 'LIKE', "%{$search}%")
                                 ->orWhere('id', 'LIKE', "%{$search}%")
                                 ->orWhere('first_name', 'LIKE', "%{$search}%")
                                 ->orWhere('last_name', 'LIKE', "%{$search}%");
                })
                ->orWhere('assessment_note', 'LIKE', "%{$search}%"); 
            });
        }

        // 2. Handle Status Filter
        if ($request->filled('status') && $request->status !== 'All') {
            $status = strtolower($request->status);
            $query->whereHas('prescriptions', function ($rxQuery) use ($status) {
                $rxQuery->where('status', $status);
            });
        }

        // 3. Handle Date Filter
        if ($request->filled('date')) {
            $query->whereDate('encounter_date', $request->date);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->buildHistoryQuery($request);
        
        $encounters = $query->orderBy('encounter_date', 'desc')->paginate(10)->withQueryString();

        // If this is an AJAX request from our real-time search, only return the table rows
        if ($request->ajax()) {
            return view('doctor.partials.history-table', compact('encounters'))->render();
        }

        return view('doctor.history', compact('encounters'));
    }

    public function exportCsv(Request $request)
    {
        $query = $this->buildHistoryQuery($request);
        
        // Fetch all matching records without pagination
        $encounters = $query->orderBy('encounter_date', 'desc')->get();

        $fileName = 'SecuRx_Consultation_History_' . date('Y-m-d_H-i') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Stream the CSV directly to the browser to save server memory
        $callback = function() use ($encounters) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, ['Encounter Date', 'Time', 'Patient Name', 'Patient ID', 'Diagnosis', 'Plan', 'Rx Status']);

            foreach ($encounters as $encounter) {
                $patient = $encounter->patient;
                $rx = $encounter->prescriptions->first();
                $rxStatus = $rx ? ucfirst($rx->status) : 'No Rx';

                fputcsv($file, [
                    \Carbon\Carbon::parse($encounter->encounter_date)->format('Y-m-d'),
                    \Carbon\Carbon::parse($encounter->created_at)->format('h:i A'),
                    $patient ? $patient->last_name . ', ' . $patient->first_name : 'Unknown',
                    $patient ? $patient->id : 'N/A',
                    $encounter->assessment_note ?? 'None',
                    $encounter->plan_note ?? 'None',
                    $rxStatus
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function revoke(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors(['password' => 'Security verification failed. Incorrect password.']);
        }

        $prescription = Prescription::where('id', $id)
            ->where('doctor_id', Auth::id())
            ->firstOrFail();

        $prescription->update(['status' => 'revoked', 'revocation_reason' => $request->reason]);

        return back()->with('success', 'Prescription successfully revoked and invalidated.');
    }

    public function show($id)
    {
        $encounter = Encounter::with([
            'patient.patientProfile',
            'prescriptions.items.medication'
        ])->findOrFail($id);

        return view('doctor.view-history', compact('encounter'));
    }
}