<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DispensingLog;
use Carbon\Carbon;

class LogsController extends Controller
{
    public function index(Request $request)
    {
        $query = DispensingLog::with(['prescriptionItem.prescription.patient'])
            ->where('pharmacist_id', auth()->id());

        // 1. Handle Dynamic Search (Update on Key)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('receiver_name_snapshot', 'like', '%' . $searchTerm . '%')
                  ->orWhere('actual_drug_dispensed', 'like', '%' . $searchTerm . '%')
                  ->orWhere('prescription_item_id', 'like', '%' . $searchTerm . '%');
            });
        }

        // 2. Handle Date Filter
        if ($request->filled('date')) {
            $query->whereDate('dispensed_at', $request->date);
        } else {
            // Default to today if no date is explicitly selected
            $query->whereDate('dispensed_at', Carbon::today());
        }

        // Fetch paginated results (10 per page)
        $logs = $query->latest('dispensed_at')->paginate(10);

        // 3. Return only the table rows if this is an AJAX/Javascript request
        if ($request->ajax()) {
            return view('pharmacist.partials._log_rows', compact('logs'))->render();
        }

        // 4. Return the full view on initial page load
        return view('pharmacist.logs', compact('logs'));
    }
}