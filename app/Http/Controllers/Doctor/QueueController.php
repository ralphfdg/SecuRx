<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function index()
    {
        $doctorId = Auth::id();
        $today = Carbon::today()->toDateString();

        // 1. Fetch Today's Live Queue (Paginated)
        $queue = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->where('appointment_date', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderByRaw('ISNULL(appointment_time), appointment_time ASC') // Sort time, nulls last
            ->orderBy('created_at', 'asc') // Fallback queue order
            ->paginate(10);

        // 2. Fetch All Appointments for the Master Calendar
        $allAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->get();

        // 3. Map Calendar Events to FullCalendar.js format
        // 3. Map Calendar Events to FullCalendar.js format
        $calendarEvents = $allAppointments->map(function ($appt) {
            $color = '#2563eb'; // Default Blue (Confirmed)
            if ($appt->status === 'completed') $color = '#10b981'; // Green
            if ($appt->status === 'cancelled') $color = '#ef4444'; // Red
            if ($appt->status === 'pending') $color = '#f59e0b'; // Orange

            $start = $appt->appointment_date;
            if ($appt->appointment_time) {
                // Force strict ISO8601 time format for FullCalendar
                $start .= 'T' . \Carbon\Carbon::parse($appt->appointment_time)->format('H:i:s');
            }

            return [
                'title' => $appt->patient->last_name . ' (' . ucfirst($appt->appointment_type) . ')',
                'start' => $start,
                'backgroundColor' => $color,
                // Setting text color explicitly to fix the "white text" contrast issue
                'textColor' => '#ffffff', 
                'borderColor' => 'transparent'
            ];
        });

        return view('doctor.queue', compact('queue', 'calendarEvents'));
    }
}