<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = Auth::id();
        $today = Carbon::today()->toDateString();

        // 1. Build the Live Queue Query
        $query = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->where('appointment_date', $today)
            ->whereIn('status', ['pending', 'confirmed']);

        // --- Apply Search Filter ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%"); // Search by short ID too
            });
        }

        // --- Apply Sort Direction ---
        $sortDirection = $request->sort === 'desc' ? 'desc' : 'asc';
        $query->orderByRaw("ISNULL(appointment_time), appointment_time $sortDirection")
            ->orderBy('created_at', $sortDirection);

        // Fetch paginated results and append current search queries to the pagination links
        $queue = $query->paginate(10)->appends($request->all());

        // --- Return Partial View for Alpine.js AJAX Keystroke Search ---
        if ($request->ajax()) {
            return view('doctor.partials.queue-list', compact('queue'))->render();
        }

        // 2. Fetch All Appointments for the Master Calendar (Sorted by Date & Time)
        $allAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->orderBy('appointment_date', 'asc')
            ->orderByRaw('ISNULL(appointment_time), appointment_time ASC')
            ->get();

        // 3. Map Calendar Events to FullCalendar.js format
        $calendarEvents = $allAppointments->map(function ($appt) {
            $color = '#2563eb'; // Default Blue
            if ($appt->status === 'completed') $color = '#10b981'; // Green
            if ($appt->status === 'cancelled') $color = '#ef4444'; // Red
            if ($appt->status === 'pending') $color = '#f59e0b'; // Orange

            $isAllDay = empty($appt->appointment_time);
            
            // STRICT DATE FORMAT: Strips out the " 00:00:00"
            $dateOnly = \Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d');
            $start = $dateOnly;
            $timeString = ''; 

            if (!$isAllDay) {
                $parsedTime = \Carbon\Carbon::parse($appt->appointment_time);
                
                // Creates perfect ISO8601 string: YYYY-MM-DDTHH:mm:ss
                $start = $dateOnly . 'T' . $parsedTime->format('H:i:s');
                
                // Formats the time label: "1:26pm "
                $timeString = $parsedTime->format('g:ia') . ' '; 
            }

            return [
                // Injects the time label directly into the visual title
                'title' => $timeString . $appt->patient->last_name . ' (' . ucfirst($appt->appointment_type) . ')',
                'start' => $start,
                'allDay' => $isAllDay,
                'backgroundColor' => $color,
                'textColor' => '#ffffff',
                'borderColor' => 'transparent'
            ];
        });

        return view('doctor.queue', compact('queue', 'calendarEvents'));
    }
}
