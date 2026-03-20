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
            'active_prescriptions' => Prescription::whereColumn('refills_used', '<', 'max_refills')->count(),
        ];

        $medications = Medication::orderBy('name')->get();
        
        return view('admin.dashboard', compact('stats', 'medications'));
    }

    // 2. Add New Medication to Inventory
    public function storeMedication(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:medications,name',
            'dosage_form' => 'required|string|max:255',
        ]);

        Medication::create([
            'name' => $request->name,
            'dosage_form' => $request->dosage_form,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'New medication securely added to the inventory.');
    }
}
