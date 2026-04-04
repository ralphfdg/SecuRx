<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Medication;
use App\Models\Prescription;

class AdminController extends Controller
{
    // 1. Load the Command Center
    public function dashboard()
    {
        $stats = [
            'total_doctors' => User::where('role', 'doctor')->count(),
            'total_pharmacists' => User::where('role', 'pharmacist')->count(),
            'total_patients' => User::where('role', 'patient')->count(),
            'total_medications' => Medication::count(),
            'active_prescriptions' => Prescription::where('status', 'active')->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    // 2. Dataset Import Engine
    public function importDataset(Request $request)
    {
        // Require a valid CSV file to be uploaded
        $request->validate([
            'dataset' => 'required|file|mimes:csv,txt|max:10240', // max 10MB
        ]);

        // Note: The actual CSV parsing and DB insertion logic will go here.
        // For now, we will simulate a successful pipeline trigger.

        return redirect()->route('admin.dashboard')
            ->with('success', 'Dataset pipeline initialized. DPRI pricing and interactions are being updated in the background.');
    }
}