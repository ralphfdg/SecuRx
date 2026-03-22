<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        // Fetch the most recent prescription for the logged-in patient
        // We use 'with' to eagerly load the medication and doctor names so we don't just get raw IDs
        $latestPrescription = Prescription::with(['medication', 'doctor'])
            ->where('patient_id', Auth::id())
            ->latest()
            ->first();

        // Send that data straight to the Blade view
        return view('patient.dashboard', compact('latestPrescription'));
    }
}