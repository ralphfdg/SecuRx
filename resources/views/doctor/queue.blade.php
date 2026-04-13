@extends('layouts.doctor')

@section('page_title', 'Clinic Queue & Schedule')

@section('content')
    <div x-data="{ activeTab: 'queue' }" class="max-w-6xl mx-auto space-y-6">

        <div
            class="p-6 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Clinic Queue & Schedule</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your active patients and upcoming appointments.</p>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end">
                <div class="flex p-1.5 bg-slate-100 rounded-xl border border-gray-200">
                    <button @click="activeTab = 'queue'"
                        :class="activeTab === 'queue' ? 'bg-white text-blue-600 shadow-sm' :
                            'text-gray-500 hover:text-blue-600'"
                        class="px-5 py-2 text-sm font-bold rounded-lg transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        Live Queue
                    </button>

                    <button @click="activeTab = 'calendar'; setTimeout(() => window.initDoctorCalendar(), 50)"
                        :class="activeTab === 'calendar' ? 'bg-white text-blue-600 shadow-sm' :
                            'text-gray-500 hover:text-blue-600'"
                        class="px-5 py-2 text-sm font-bold rounded-lg transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Master Calendar
                    </button>
                </div>

                <a href="#" onclick="alert('Please select a patient from the queue to start a consultation.')"
                    class="hidden lg:flex bg-white border border-gray-300 hover:border-securx-navy text-securx-navy font-bold py-2.5 px-5 rounded-xl transition shadow-sm items-center justify-center gap-2 text-sm whitespace-nowrap">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Walk-in
                </a>
            </div>
        </div>

        <div x-show="activeTab === 'queue'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            class="space-y-4">

            @forelse($queue as $index => $appt)
                @php
                    $patient = $appt->patient;
                    $age = $patient->dob ? \Carbon\Carbon::parse($patient->dob)->age : '--';
                    $hasVitals = !empty($appt->triage_vitals);

                    // Decode vitals from JSON
                    $bp = $hasVitals && isset($appt->triage_vitals['blood_pressure']) ? $appt->triage_vitals['blood_pressure'] : '--/--';
                    $temp =
                        $hasVitals && isset($appt->triage_vitals['temperature']) ? $appt->triage_vitals['temperature'] . '°C' : '--';
                    $weight =
                        $hasVitals && isset($appt->triage_vitals['weight'])
                            ? $appt->triage_vitals['weight'] . 'kg'
                            : '--';

                    $queueNum = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    $shortId = strtoupper(substr($patient->id, 0, 8));
                    $reason = $appt->reason_for_visit ?? 'Routine checkup / No reason provided';
                @endphp

                @if ($index === 0 && $hasVitals)
                    <div class="bg-white border-2 border-blue-500 rounded-2xl shadow-md overflow-hidden relative group">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>

                        <div class="p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-blue-600 flex flex-col items-center justify-center text-white shadow-lg shrink-0">
                                    <span class="text-[10px] font-bold uppercase opacity-80 leading-none mb-1">Now</span>
                                    <span class="text-xl font-black leading-none">{{ $queueNum }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-lg font-black text-securx-navy">{{ $patient->last_name }},
                                            {{ $patient->first_name }}</h3>
                                        <span
                                            class="px-2 py-0.5 rounded-md text-[10px] font-black bg-blue-100 text-blue-700 uppercase tracking-widest border border-blue-200 animate-pulse">Session
                                            Active</span>
                                    </div>
                                    <p class="text-sm text-gray-500 font-medium">{{ $age }} yrs •
                                        {{ $patient->gender ?? 'N/A' }} • ID: {{ $shortId }}</p>
                                    <p class="text-xs text-blue-600 font-bold mt-1 italic">"{{ $reason }}"</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-8 px-6 py-3 bg-slate-50 rounded-xl border border-gray-100">
                                <div class="text-center">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">BP</p>
                                    <p class="text-sm font-black text-red-500">{{ $bp }}</p>
                                </div>
                                <div class="text-center border-x border-gray-200 px-8">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Temp</p>
                                    <p class="text-sm font-black text-securx-navy">{{ $temp }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Weight</p>
                                    <p class="text-sm font-black text-securx-navy">{{ $weight }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('doctor.consultation.show', ['appointment' => $appt->id]) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] flex items-center gap-2 whitespace-nowrap">
                                    Resume Console
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @elseif($hasVitals)
                    <div
                        class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm overflow-hidden relative group hover:border-blue-300 transition-colors">
                        <div class="p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-6">

                            <div
                                class="flex items-start gap-4 text-gray-400 group-hover:text-securx-navy transition-colors">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-slate-100 group-hover:bg-blue-50 flex flex-col items-center justify-center text-slate-500 group-hover:text-blue-600 font-bold shrink-0 transition-colors">
                                    <span class="text-xl font-black leading-none">{{ $queueNum }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-lg font-bold text-securx-navy">{{ $patient->last_name }},
                                            {{ $patient->first_name }}</h3>
                                        <span
                                            class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 uppercase tracking-widest border border-emerald-200">Triaged
                                            • Ready</span>
                                    </div>
                                    <p class="text-sm text-gray-500 font-medium">{{ $age }} yrs •
                                        {{ $patient->gender ?? 'N/A' }} • ID: {{ $shortId }}</p>
                                    <p class="text-xs text-gray-400 mt-1 group-hover:text-securx-navy transition-colors">
                                        {{ ucfirst($appt->appointment_type) }}: {{ $reason }}</p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-8 px-6 py-3 bg-white/50 rounded-xl border border-gray-100 group-hover:bg-white transition-colors">
                                <div class="text-center">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">BP</p>
                                    <p class="text-sm font-black text-emerald-600">{{ $bp }}</p>
                                </div>
                                <div class="text-center border-x border-gray-200 px-8">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Temp</p>
                                    <p class="text-sm font-black text-securx-navy">{{ $temp }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Weight</p>
                                    <p class="text-sm font-black text-securx-navy">{{ $weight }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('doctor.consultation.show', ['appointment' => $appt->id]) }}"
                                    class="bg-white border-2 border-gray-200 text-securx-navy hover:border-blue-600 hover:text-blue-600 font-bold py-2.5 px-6 rounded-xl transition text-sm shadow-sm flex items-center gap-2 whitespace-nowrap">
                                    Start Consultation
                                    <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white/40 border border-dashed border-gray-300 rounded-2xl overflow-hidden opacity-70">
                        <div class="p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-slate-50 border border-gray-200 flex items-center justify-center text-slate-300 font-bold shrink-0">
                                    <span class="text-xl font-black leading-none">{{ $queueNum }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-lg font-bold text-gray-400">{{ $patient->last_name }},
                                            {{ $patient->first_name }}</h3>
                                        <span
                                            class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 text-gray-400 uppercase tracking-widest">Front
                                            Desk Waiting</span>
                                    </div>
                                    <p class="text-sm text-gray-400">{{ $age }} yrs •
                                        {{ $patient->gender ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="flex-1 text-center py-2 italic text-xs text-gray-400">
                                Awaiting triage vitals from Secretary...
                            </div>

                            <div class="flex items-center gap-3">
                                <button disabled
                                    class="bg-gray-100 text-gray-400 font-bold py-2.5 px-6 rounded-xl text-sm cursor-not-allowed border border-gray-200 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                    Awaiting Vitals
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center py-10 bg-white rounded-2xl border border-gray-200 shadow-sm">
                    <p class="text-gray-500 font-medium">No patients currently in the queue.</p>
                </div>
            @endforelse

            @if ($queue->total() > 0)
                <div
                    class="bg-white/60 backdrop-blur-sm border border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                    <p class="text-xs text-gray-500 font-medium">
                        Showing <span class="font-bold text-securx-navy">{{ $queue->firstItem() }}</span> to <span
                            class="font-bold text-securx-navy">{{ $queue->lastItem() }}</span> of <span
                            class="font-bold text-securx-navy">{{ $queue->total() }}</span> patients in queue
                    </p>

                    <div class="flex items-center gap-1.5">
                        {{ $queue->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        </div>

        <div x-show="activeTab === 'calendar'" style="display: none;"
            class="bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl p-6 shadow-sm min-h-[600px]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-securx-navy border-l-4 border-blue-600 pl-3">Appointment Schedule</h3>
                <span
                    class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold border border-emerald-200">Accepting
                    Appointments</span>
            </div>
            <div id="doctorCalendar" class="w-full min-h-[600px]"></div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        let calendarLoaded = false;

        // Dynamic events injected from the Controller
        const dynamicEvents = {!! json_encode($calendarEvents) !!};

        window.initDoctorCalendar = function() {
            if (calendarLoaded) {
                if (window.doctorCal) window.doctorCal.updateSize();
                return;
            }

            const calendarEl = document.getElementById('doctorCalendar');

            if (calendarEl) {
                window.doctorCal = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    themeSystem: 'standard',
                    height: 600,
                    eventClassNames: 'rounded-md border-0 text-xs font-bold px-1 cursor-pointer text-white',
                    events: dynamicEvents // Mapped directly from backend
                });

                window.doctorCal.render();
                calendarLoaded = true;
            }
        };
    </script>

    <style>
        .fc-theme-standard .fc-scrollgrid {
            border-color: #e2e8f0;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: #f1f5f9;
        }

        .fc-col-header-cell {
            background-color: #f8fafc;
            padding: 8px 0;
            color: #475569;
            font-size: 0.875rem;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        .fc-button-primary {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            text-transform: capitalize;
            font-weight: bold !important;
            border-radius: 0.5rem !important;
        }

        .fc-button-primary:not(:disabled):active,
        .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
        }

        .fc-toolbar-title {
            font-weight: 800 !important;
            color: #0f172a;
            font-size: 1.25rem !important;
        }

        .fc-day-today {
            background-color: #f0fdf4 !important;
        }

        .fc-event {
            border-radius: 4px !important;
            margin: 1px 2px !important;
        }
    </style>
@endsection
