@extends('layouts.secretary')

@section('page_title', 'Master Calendar')

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    @vite(['resources/js/secretary-calendar.js'])
@endpush

@section('content')
    @if (session('success'))
        <div
            class="max-w-6xl mx-auto mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 shadow-sm animate-pulse">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif
    <div class="max-w-7xl mx-auto space-y-6">

        <div
            class="p-6 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Appointment Manager</h2>
                <p class="text-sm text-gray-500 mt-1">Manage clinic schedules, approve pending requests, and log walk-in
                    patients.</p>
            </div>

            <div class="flex items-center gap-3">
                <button
                    class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl transition shadow-sm text-sm">
                    Export Schedule
                </button>
                <a href="{{ route('secretary.appointments.create') }}"
                    class="bg-securx-navy hover:bg-slate-800 text-white font-bold py-2.5 px-5 rounded-xl transition shadow-[0_4px_14px_0_rgba(15,23,42,0.39)] flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                        </path>
                    </svg>
                    New Appointment
                </a>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">

            <div class="flex-1 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row sm:items-center gap-4 lg:gap-6">
                <span class="font-bold text-securx-navy border-b sm:border-b-0 sm:border-r border-gray-200 pb-2 sm:pb-0 sm:pr-6 whitespace-nowrap">
                    Status Legend
                </span>
                <ul class="flex flex-wrap items-center gap-4 text-sm font-medium text-gray-700">
                    <li class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-orange-500 shadow-sm"></span>
                        Pending Approval
                    </li>
                    
                    <li class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-green-500 shadow-sm"></span>
                        Confirmed
                    </li>

                    <li class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-blue-500 shadow-sm animate-pulse"></span>
                        Arrived (In-Progress)
                    </li>
                    
                    <li class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-slate-500 shadow-sm"></span>
                        Completed
                    </li>
                    
                    <li class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-red-500 shadow-sm"></span>
                        Cancelled
                    </li>
                </ul>
            </div>

            <div
                class="lg:w-80 bg-slate-800 border border-slate-700 rounded-2xl p-4 shadow-xl text-white flex items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-sm">Triage & Queue</h3>
                    <p class="text-[10px] text-slate-400">Manage arrived patients</p>
                </div>
                <a href="{{ route('secretary.triage') }}"
                    class="bg-securx-cyan hover:bg-cyan-400 text-white font-bold py-2 px-4 rounded-xl transition text-xs shadow-[0_0_15px_rgba(28,181,209,0.3)] whitespace-nowrap">
                    Open Console &rarr;
                </a>
            </div>

        </div>

        <div class="bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl p-6 shadow-sm">
            <div id="calendar" data-url="{{ route('secretary.api.appointments') }}" class="min-h-[700px] w-full"></div>
        </div>

    </div>

    <style>
        /* UI Cleanups for the larger calendar */
        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a202c;
        }

        .fc .fc-button-primary {
            background-color: #1e293b;
            border-color: #1e293b;
            border-radius: 0.5rem;
            text-transform: capitalize;
            font-weight: 600;
        }

        .fc .fc-button-primary:not(:disabled):active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #1cb5d1;
            border-color: #1cb5d1;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: #e2e8f0;
        }

        .fc-day-today {
            background-color: #f8fafc !important;
        }

        /* Style the "+ More" popover link */
        .fc-daygrid-more-link {
            font-weight: 700;
            color: #1e293b;
            font-size: 0.75rem;
            padding-top: 2px;
        }

        .fc-popover {
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .fc-popover-header {
            background-color: #1e293b;
            color: white;
            font-weight: bold;
        }
    </style>
@endsection
