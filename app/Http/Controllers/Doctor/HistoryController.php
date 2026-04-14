<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Encounter;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = Auth::id();

        // Base query: Encounters with their related patient and prescription
        $query = Encounter::with(['patient', 'prescriptions'])
            ->where('doctor_id', $doctorId);

        // 1. Handle Search (Name, ID, Diagnosis)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($patientQuery) use ($search) {
                    $patientQuery->where('name', 'LIKE', "%{$search}%")
                                 ->orWhere('id', 'LIKE', "%{$search}%");
                })
                ->orWhere('assessment_note', 'LIKE', "%{$search}%"); // Diagnosis search
            });
        }

        // 2. Handle Status Filter
        if ($request->filled('status') && $request->status !== 'All') {
            $status = strtolower($request->status); // 'active', 'dispensed', 'revoked'
            $query->whereHas('prescriptions', function ($rxQuery) use ($status) {
                $rxQuery->where('status', $status);
            });
        }

        // 3. Handle Date Filter
        if ($request->filled('date')) {
            $query->whereDate('encounter_date', $request->date);
        }

        // Order by latest and paginate
        $encounters = $query->orderBy('encounter_date', 'desc')->paginate(10)->withQueryString();

        return view('doctor.history', compact('encounters'));
    }

    public function revoke(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string',
            'password' => 'required|string',
        ]);

        // Security Check: Verify Doctor's Password before allowing revocation
        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors(['password' => 'Security verification failed. Incorrect password.']);
        }

        // Find the specific prescription
        $prescription = Prescription::where('id', $id)
            ->where('doctor_id', Auth::id())
            ->firstOrFail();

        // Update status to revoked so Pharmacist portal flags it immediately
        $prescription->update(['status' => 'revoked']);

        return back()->with('success', 'Prescription successfully revoked and invalidated.');
    }

    public function show($id)
    {
        // Fetch the encounter with nested relationships to get the exact drugs and patient info
        $encounter = Encounter::with([
            'patient.patientProfile',
            'prescriptions.items.medication'
        ])->findOrFail($id);

        // Fetch the doctor's license details for the prescription pad
        $doctorProfile = \Illuminate\Support\Facades\DB::table('doctor_profiles')
            ->where('user_id', Auth::id())
            ->first();

        return view('doctor.view-history', compact('encounter', 'doctorProfile'));
    }
}
