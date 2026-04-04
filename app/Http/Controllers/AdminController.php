<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Medication;
use App\Models\Prescription;
use App\Models\AuditLog;

class AdminController extends Controller
{
    // ==========================================
    // 1. DASHBOARD
    // ==========================================
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

    // ==========================================
    // 2. USER MANAGEMENT
    // ==========================================
    public function users()
    {
        // Fetch medical staff awaiting approval
        $pendingUsers = User::whereIn('role', ['doctor', 'pharmacist'])
                            ->where('status', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Fetch already approved medical staff for the directory
        $activeUsers = User::whereIn('role', ['doctor', 'pharmacist'])
                           ->where('status', 'active')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('admin.users', compact('pendingUsers', 'activeUsers'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        
        return redirect()->back()->with('success', "{$user->name}'s account has been verified and activated.");
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', "{$user->name}'s application has been rejected.");
    }

    // ==========================================
    // 3. DATASET IMPORT ENGINE
    // ==========================================
    public function datasetView()
    {
        return view('admin.dataset');
    }

    public function importDataset(Request $request)
    {
        // 1. Validate that a file was uploaded and it is a CSV
        $request->validate([
            'dataset' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('dataset');
        
        // 2. Open the file for reading
        $handle = fopen($file->path(), 'r');
        
        // 3. Skip the first row (the header row)
        fgetcsv($handle);
        
        $importedCount = 0;

        // 4. Loop through every row in the CSV
        while (($row = fgetcsv($handle)) !== false) {
            // Ensure the row has the expected 4 columns before processing
            if (count($row) >= 4) {
                Medication::updateOrCreate(
                    [
                        'generic_name' => trim($row[0]),
                        'form' => trim($row[1]),
                    ],
                    [
                        'dosage_strength' => trim($row[2]),
                        'estimated_price' => (float) str_replace(',', '', $row[3]),
                    ]
                );
                $importedCount++;
            }
        }

        // 5. Close the file securely
        fclose($handle);

        return redirect()->route('admin.dashboard')
            ->with('success', "Dataset pipeline successful! {$importedCount} medications updated or added to the database.");
    }

    // ==========================================
    // 4. IMMUTABLE AUDIT LOGS
    // ==========================================
    public function logs()
    {
        // Fetch logs from newest to oldest, 20 per page. 
        // We use 'with' assuming the log belongs to a user (if your table has a user relation)
        $logs = AuditLog::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.logs', compact('logs'));
    }

    // ==========================================
    // 5. SYSTEM BACKUP & EXPORT
    // ==========================================
    public function backupView()
    {
        return view('admin.backup');
    }

    public function exportBackup(Request $request)
    {
        $type = $request->input('type', 'csv');
        $date = now()->format('Y-m-d_H-i-s');

        // --- CSV EXPORT (Live Data) ---
        if ($type === 'csv') {
            $medications = Medication::all();
            $filename = "securx_medications_backup_{$date}.csv";

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $columns = ['ID', 'Generic Name', 'Form', 'Dosage Strength', 'Estimated Price', 'Created At'];

            $callback = function() use($medications, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($medications as $med) {
                    fputcsv($file, [
                        $med->id,
                        $med->generic_name,
                        $med->form,
                        $med->dosage_strength,
                        $med->estimated_price,
                        $med->created_at
                    ]);
                }
                fclose($file);
            };

            // Log this action for security
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action_type' => 'Export',
                'description' => 'Admin downloaded a CSV backup of the medications table.',
                'ip_address' => request()->ip()
            ]);

            return response()->stream($callback, 200, $headers);
        }

        // --- SQL EXPORT (Prototype Simulation) ---
        if ($type === 'sql') {
            $filename = "securx_full_backup_{$date}.sql";
            
            // In a production environment, this would trigger a mysqldump command.
            // For this prototype, we generate a secure structural template.
            $content = "-- SecuRx Automated SQL Backup\n";
            $content .= "-- Generated at: {$date}\n";
            $content .= "-- Initiated by: " . auth()->user()->email . "\n\n";
            $content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\nSTART TRANSACTION;\nSET time_zone = \"+00:00\";\n\n";
            $content .= "-- Backup initialized successfully. (End of prototype dump)\n";
            $content .= "COMMIT;\n";

            // Log this action for security
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action_type' => 'Export',
                'description' => 'Admin downloaded a structural SQL backup.',
                'ip_address' => request()->ip()
            ]);

            return response($content)
                ->header('Content-Type', 'application/sql')
                ->header('Content-Disposition', "attachment; filename={$filename}");
        }

        return redirect()->back()->with('error', 'Invalid export type selected.');
    }

    // ==========================================
    // 6. GLOBAL PLATFORM SETTINGS
    // ==========================================
    public function settingsView()
    {
        // Mocking default platform settings for the prototype
        $settings = [
            'maintenance_mode' => false,
            'session_timeout' => 15,
            'max_login_attempts' => 5,
            'prescription_validity' => 30, // Days a QR code remains valid
        ];

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        // Validate the incoming setting constraints
        $request->validate([
            'session_timeout' => 'required|integer|min:5|max:120',
            'max_login_attempts' => 'required|integer|min:3|max:10',
            'prescription_validity' => 'required|integer|min:1|max:365',
        ]);

        // Securely log this action to the ledger
        \App\Models\AuditLog::create([
            'user_id' => $request->user()->id,
            'action_type' => 'System Update',
            'description' => 'Admin updated global platform configuration and security protocols.',
            'ip_address' => $request->ip()
        ]);

        // In a production app, you would save these to a DB table or config file here.
        
        return redirect()->back()->with('success', 'Global platform settings have been successfully updated and applied across the network.');
    }

    // ==========================================
    // 7. ADMIN PROFILE SETTINGS
    // ==========================================
    public function profile(Request $request)
    {
        return view('admin.profile', [
            'user' => $request->user(),
        ]);
    }

public function updateProfile(Request $request)
    {
        $user = $request->user();

        // Validate the incoming data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // Ensure the email is unique, but ignore the current user's email
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Automatically format the full name string
        $name = trim($request->first_name . ' ' . $request->last_name);

        // Update the user
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $name,
            'email' => $request->email,
        ]);

        // Log this action securely (Notice 'action_type' here!)
        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'action_type' => 'Profile Update', 
            'description' => 'Admin updated their personal profile credentials.',
            'ip_address' => $request->ip()
        ]);

        return redirect()->back()->with('success', 'Your personal details have been securely updated.');
    }
    }