<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Medication;
use App\Models\Prescription;
use App\Models\AuditLog;

class AdminController extends Controller
{
    // ==========================================
    // 1. DASHBOARD
    // ==========================================
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

        // Fetch the 4 most recently added/updated medications for the Quick View
        $recentMedications = Medication::orderBy('updated_at', 'desc')->take(4)->get();
        
        // Fetch the 4 most recent audit logs for the new widget
        $recentLogs = AuditLog::orderBy('created_at', 'desc')->take(4)->get();

        return view('admin.dashboard', compact('stats', 'recentMedications', 'recentLogs'));
    }

    // ==========================================
    // 2. USER MANAGEMENT
    // ==========================================
    public function users()
    {
        $pendingUsers = User::whereIn('role', ['doctor', 'pharmacist'])
                            ->where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $activeUsers = User::whereIn('role', ['doctor', 'pharmacist'])
                           ->where('status', 'active')->orderBy('created_at', 'desc')->get();

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
    // 3. DATASET IMPORT ENGINE & MANAGEMENT
    // ==========================================
    public function datasetView(Request $request)
    {
        $search = $request->input('search');

        // Start the query
        $query = Medication::query();

        // If the user typed something in the search bar, filter the results
        if ($search) {
            $query->where('generic_name', 'LIKE', "%{$search}%")
                  ->orWhere('form', 'LIKE', "%{$search}%");
        }

        // Fetch paginated results (15 per page) and keep the search query in the pagination links
        $medications = $query->orderBy('updated_at', 'desc')->paginate(15)->appends(['search' => $search]);

        return view('admin.dataset', compact('medications', 'search'));
    }

    public function importDataset(Request $request)
    {
        // 1. Initial Validation
        $request->validate([
            'dataset' => 'required|file|max:10240',
        ], [
            'dataset.required' => 'Please select a file to upload.',
            'dataset.max' => 'The file size cannot exceed 10MB.'
        ]);

        try {
            $file = $request->file('dataset');
            $handle = fopen($file->path(), 'r');
            
            // Skip the header row
            fgetcsv($handle); 
            
            $importedCount = 0;

            // 2. Safely parse the CSV
            while (($row = fgetcsv($handle)) !== false) {
                // Only process rows that have all 4 required columns
                if (count($row) >= 4 && !empty(trim($row[0]))) {
                    Medication::updateOrCreate(
                        [
                            'generic_name' => trim($row[0]),
                            'form' => trim($row[1]),
                        ],
                        [
                            'dosage_strength' => trim($row[2]),
                            'estimated_price' => (float) preg_replace('/[^0-9.]/', '', $row[3]),
                        ]
                    );
                    $importedCount++;
                }
            }
            fclose($handle);

            // 3. Handle Empty or Invalid Files
            if ($importedCount === 0) {
                return redirect()->route('admin.dataset')
                    ->with('error', 'The uploaded file was empty or did not contain data matching the 4-column requirement.');
            }

            // 4. Secure Logging
            AuditLog::create([
                'user_id' => auth()->id(),
                'action_type' => 'Import',
                'description' => "Admin successfully imported a dataset with {$importedCount} medications.",
                'ip_address' => request()->ip()
            ]);

            return redirect()->route('admin.dataset')
                ->with('success', "Dataset pipeline successful! {$importedCount} medications updated or added to the database.");

        } catch (\Exception $e) {
            // 5. Catch any catastrophic parsing failures (like trying to read a broken file)
            return redirect()->route('admin.dataset')
                ->with('error', 'A structural error occurred while processing the file. Please ensure it is a properly formatted CSV.');
        }
    }

    public function updateMedication(Request $request, $id)
    {
        $request->validate([
            'generic_name' => 'required|string|max:255',
            'form' => 'required|string|max:255',
            'dosage_strength' => 'required|string|max:255',
            'estimated_price' => 'required|numeric|min:0',
        ]);

        $medication = Medication::findOrFail($id);
        
        $medication->update([
            'generic_name' => trim($request->generic_name),
            'form' => trim($request->form),
            'dosage_strength' => trim($request->dosage_strength),
            'estimated_price' => (float) $request->estimated_price,
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Update',
            'description' => "Admin manually updated clinical data for: {$medication->generic_name}.",
            'ip_address' => request()->ip()
        ]);

        return redirect()->back()->with('success', "{$medication->generic_name} has been successfully updated.");
    }

    public function deleteMedication($id)
    {
        $medication = Medication::findOrFail($id);
        $medicationName = $medication->generic_name;
        
        // Because we added the SoftDeletes trait, this will safely hide the record, not destroy it permanently!
        $medication->delete(); 

        AuditLog::create([
            'user_id' => auth()->id(),
            'action_type' => 'Delete',
            'description' => "Admin safely soft-deleted the medication: {$medicationName}.",
            'ip_address' => request()->ip()
        ]);

        return redirect()->back()->with('success', "{$medicationName} has been successfully archived from the active inventory.");
    }

    // ==========================================
    // 4. IMMUTABLE AUDIT LOGS
    // ==========================================
    public function logs()
    {
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

        if ($type === 'csv') {
            $medications = Medication::all();
            $filename = "securx_medications_backup_{$date}.csv";

            AuditLog::create([
                'user_id' => auth()->id(),
                'action_type' => 'Export',
                'description' => 'Admin downloaded a CSV backup of the medications table.',
                'ip_address' => request()->ip()
            ]);

            return response()->streamDownload(function() use($medications) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Generic Name', 'Form', 'Dosage Strength', 'Estimated Price', 'Created At']);

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
            }, $filename, ["Content-type" => "text/csv"]);
        }

        // --- REAL SQL EXPORT ENGINE ---
        if ($type === 'sql') {
            $filename = "securx_full_backup_{$date}.sql";
            
            $content = "-- SecuRx Automated SQL Backup\n";
            $content .= "-- Generated at: {$date}\n";
            $content .= "-- Initiated by: " . auth()->user()->email . "\n\n";
            $content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\nSTART TRANSACTION;\nSET time_zone = \"+00:00\";\n\n";

            try {
                // 1. Fetch all tables from the database
                $tables = DB::select('SHOW TABLES');
                $pdo = DB::getPdo(); // Use PDO to safely escape strings

                foreach ($tables as $table) {
                    // Extract the table name dynamically
                    $tableName = array_values((array) $table)[0];

                    // 2. Get the Table Creation Structure
                    $content .= "-- --------------------------------------------------------\n\n";
                    $content .= "--\n-- Table structure for table `{$tableName}`\n--\n\n";
                    $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                    $content .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                    $content .= array_values((array) $createTable[0])[1] . ";\n\n";

                    // 3. Get all rows (Data) for the Table
                    $rows = DB::table($tableName)->get();
                    if ($rows->count() > 0) {
                        $content .= "--\n-- Dumping data for table `{$tableName}`\n--\n\n";
                        foreach ($rows as $row) {
                            // Safely quote each value or set to NULL
                            $values = array_map(function ($value) use ($pdo) {
                                return is_null($value) ? 'NULL' : $pdo->quote($value);
                            }, (array) $row);
                            
                            $content .= "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n";
                        }
                        $content .= "\n";
                    }
                }
                
                $content .= "COMMIT;\n";

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to generate SQL backup: ' . $e->getMessage());
            }

            AuditLog::create([
                'user_id' => auth()->id(),
                'action_type' => 'Export',
                'description' => 'Admin downloaded a full structural and data SQL backup.',
                'ip_address' => request()->ip()
            ]);

            return response($content)->withHeaders([
                'Content-Type' => 'application/sql',
                'Content-Disposition' => "attachment; filename={$filename}",
            ]);
        }

        return redirect()->back()->with('error', 'Invalid export type selected.');
    }

    // ==========================================
    // 6. GLOBAL PLATFORM SETTINGS
    // ==========================================
    public function settingsView()
    {
        // Use Laravel Cache to retrieve platform settings
        $settings = [
            'maintenance_mode' => Cache::get('settings.maintenance_mode', false),
            'session_timeout' => Cache::get('settings.session_timeout', 15),
            'max_login_attempts' => Cache::get('settings.max_login_attempts', 5),
            'prescription_validity' => Cache::get('settings.prescription_validity', 30),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'session_timeout' => 'required|integer|min:5|max:120',
            'max_login_attempts' => 'required|integer|min:3|max:10',
            'prescription_validity' => 'required|integer|min:1|max:365',
        ]);

        // Persist settings forever in the cache
        Cache::forever('settings.maintenance_mode', $request->has('maintenance_mode'));
        Cache::forever('settings.session_timeout', $request->input('session_timeout'));
        Cache::forever('settings.max_login_attempts', $request->input('max_login_attempts'));
        Cache::forever('settings.prescription_validity', $request->input('prescription_validity'));

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action_type' => 'System Update',
            'description' => 'Admin updated global platform configuration and security protocols.',
            'ip_address' => $request->ip()
        ]);
        
        return redirect()->back()->with('success', 'Global platform settings have been successfully updated and applied across the network.');
    }

    // ==========================================
    // 7. ADMIN PROFILE SETTINGS
    // ==========================================
    public function profile(Request $request)
    {
        return view('admin.profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $name = trim($request->first_name . ' ' . $request->last_name);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $name,
            'email' => $request->email,
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'action_type' => 'Profile Update', 
            'description' => 'Admin updated their personal profile credentials.',
            'ip_address' => $request->ip()
        ]);

        return redirect()->back()->with('success', 'Your personal details have been securely updated.');
    }
}