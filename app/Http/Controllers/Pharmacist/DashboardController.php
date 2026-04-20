<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\DispensingLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();

        // 1. Create a base query builder (Notice there is NO ->get() at the end of this!)
        $baseQuery = DispensingLog::where('pharmacist_id', $user->id)
            ->whereDate('dispensed_at', $today);

        // 2. Calculate shift metrics using the base query
        $totalDispensed = (clone $baseQuery)->count();
        $durOverrides = 0;
        $rejectedCount = 0;

        // 3. Fetch PAGINATED data for the table
        // We use ->paginate(5) instead of ->take(5)->get() or just ->get()
        $recentLogs = (clone $baseQuery)->with(['prescriptionItem.prescription.patient'])
            ->latest('dispensed_at')
            ->paginate(5);

        $pharmacyName = $user->pharmacy->name ?? 'Guest Pharmacy Portal';

        return view('pharmacist.dashboard', compact(
            'totalDispensed', 'durOverrides', 'rejectedCount', 'recentLogs', 'pharmacyName'
        ));
    }
}
