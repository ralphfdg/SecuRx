@extends('layouts.patient')

@section('page_title', 'Appointment Management')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">

    <div class="max-w-6xl mx-auto space-y-6">

        @if (session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-4 border border-green-100 text-sm font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-4 border border-red-100 text-sm font-bold">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') ?? 'Oops! We couldn\'t process that:' }}
                </div>
                @if($errors->any())
                    <ul class="list-disc list-inside ml-7 font-normal space-y-1 mt-2">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 glass-panel p-6 bg-white/80">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">My Appointments</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your upcoming clinic visits and view your consultation history.</p>
            </div>
            <a href="{{ route('patient.appointments.book') }}" class="glass-btn-primary flex items-center justify-center gap-2 py-2.5 px-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Book New Visit
            </a>
        </div>

        <div class="flex overflow-x-auto border-b border-gray-200 mb-2">
            <button onclick="window.switchApptTab('upcoming')" id="tab-upcoming" class="px-6 py-3 text-sm font-bold border-b-2 border-securx-cyan text-securx-cyan transition-colors">Upcoming Visits</button>
            <button onclick="window.switchApptTab('history')" id="tab-history" class="px-6 py-3 text-sm font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-800 transition-colors">History</button>
        </div>

        <div id="content-upcoming" class="grid grid-cols-1 gap-6 block">
            @forelse($upcomingAppointments as $appointment)
                <div class="glass-panel bg-white/70 p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 hover:shadow-lg transition-shadow border-l-4 {{ $appointment->status === 'confirmed' ? 'border-green-500' : 'border-securx-gold' }}">
                    
                    <div class="flex items-start gap-4">
                        <div class="flex flex-col items-center justify-center bg-securx-navy/5 rounded-xl border border-securx-navy/10 p-3 min-w-[80px]">
                            <span class="text-xs font-bold text-gray-500 uppercase">{{ $appointment->appointment_date->format('M') }}</span>
                            <span class="text-2xl font-extrabold text-securx-navy">{{ $appointment->appointment_date->format('d') }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-securx-navy flex items-center gap-2">
                                Dr. {{ $appointment->doctor->last_name }}
                                @if ($appointment->status === 'confirmed')
                                    <span class="bg-green-100 text-green-700 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full tracking-wider">Confirmed</span>
                                @else
                                    <span class="bg-securx-gold/20 text-securx-gold text-[10px] uppercase font-bold px-2 py-0.5 rounded-full tracking-wider">Pending</span>
                                @endif
                            </h3>
                            <div class="mt-2 space-y-1 text-sm text-gray-600">
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'Time TBD' }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $appointment->doctor->doctorProfile->clinic->clinic_name ?? 'Primary Clinic' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-auto flex flex-col items-end gap-3 relative">
                        
                        <div id="taken-container-{{ $appointment->id }}" class="hidden w-full p-3 bg-slate-100 border border-slate-200 rounded-lg text-sm shadow-inner text-left mb-1">
                            <p class="font-bold text-slate-700 mb-1.5 text-[11px] uppercase tracking-wider">Booked on <span id="taken-date-{{ $appointment->id }}"></span>:</p>
                            <div id="taken-list-{{ $appointment->id }}" class="flex flex-wrap gap-1.5"></div>
                        </div>
                        
                        <div id="conflict-warning-{{ $appointment->id }}" class="hidden w-full p-2.5 bg-red-50 border border-red-200 rounded-lg text-red-600 text-xs font-bold flex items-center gap-2 mb-1 text-left shadow-sm">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Time slot taken! Please adjust.</span>
                        </div>

                        <form action="{{ route('patient.appointments.reschedule', $appointment->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                            @csrf
                            <input type="text" name="appointment_date" required data-doctor-id="{{ $appointment->doctor_id }}" data-appt-id="{{ $appointment->id }}" placeholder="Select new date & time..." class="flatpickr-reschedule bg-white border border-gray-200 rounded-lg text-sm text-gray-700 px-3 py-2 focus:border-securx-cyan focus:ring-1 focus:ring-securx-cyan outline-none shadow-sm w-full sm:w-48">
                            <button type="submit" id="btn-reschedule-{{ $appointment->id }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-lg hover:bg-securx-cyan hover:text-white transition w-full sm:w-auto text-center shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">Reschedule</button>
                        </form>
                        
                        <form action="{{ route('patient.appointments.cancel', $appointment->id) }}" method="POST" class="w-full sm:w-auto flex justify-end">
                            @csrf
                            <button type="submit" onclick="return confirm('Are you sure you want to cancel this appointment? This action cannot be undone.')" class="px-4 py-2 bg-white border border-red-100 text-red-500 hover:bg-red-50 text-sm font-bold rounded-lg transition w-full sm:w-auto text-center shadow-sm">Cancel Appointment</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="glass-panel bg-white/50 border-dashed border-2 border-securx-cyan/30 flex flex-col items-center justify-center py-16 px-4 text-center rounded-2xl">
                    <p class="text-gray-500 text-sm">You have no upcoming appointments.</p>
                </div>
            @endforelse
        </div>

        <div id="content-history" class="hidden">
            <div class="grid grid-cols-1 gap-6 mb-6">
                @forelse($historyAppointments as $appointment)
                    <div class="glass-panel bg-slate-50 p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 border-l-4 {{ $appointment->status === 'completed' ? 'border-securx-cyan' : 'border-gray-400' }}">
                        <div class="flex items-start gap-4 opacity-75">
                            <div class="flex flex-col items-center justify-center bg-gray-200 rounded-xl border border-gray-300 p-3 min-w-[80px]">
                                <span class="text-xs font-bold text-gray-500 uppercase">{{ $appointment->appointment_date->format('M') }}</span>
                                <span class="text-2xl font-extrabold text-gray-600">{{ $appointment->appointment_date->format('d') }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-700 flex items-center gap-2">
                                    Dr. {{ $appointment->doctor->last_name }}
                                    @if ($appointment->status === 'completed')
                                        <span class="bg-securx-cyan/10 text-securx-cyan border border-securx-cyan/20 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full tracking-wider">Completed</span>
                                    @else
                                        <span class="bg-gray-200 text-gray-600 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full tracking-wider">Cancelled</span>
                                    @endif
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $appointment->appointment_date->format('l, F j, Y') }} at {{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') : 'TBD' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="glass-panel bg-white/50 border-dashed border-2 border-gray-200 flex flex-col items-center justify-center py-16 px-4 text-center rounded-2xl">
                        <p class="text-gray-500 text-sm">Your past appointment history will appear here.</p>
                    </div>
                @endforelse
            </div>
            
            <div>
                {{ $historyAppointments->links() }}
            </div>
        </div>
    </div>

    <script>
        window.doctorSchedules = window.doctorSchedules || {};
        @foreach($upcomingAppointments as $appt)
            @if($appt->doctor && $appt->doctor->schedules)
                window.doctorSchedules["{{ $appt->doctor_id }}"] = @json($appt->doctor->schedules);
            @endif
        @endforeach
        
        window.bookedAppointments = @json($bookedAppointments ?? []);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @vite(['resources/js/appointments.js'])
@endsection