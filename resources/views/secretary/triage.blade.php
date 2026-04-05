@extends('layouts.secretary')

@section('page_title', 'Triage Console')

@push('scripts')
    @vite(['resources/js/secretary-triage.js'])
@endpush

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        @if (session('success'))
            <div
                class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 shadow-sm animate-pulse">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div
            class="p-6 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Daily Queue & Triage</h2>
                <p class="text-sm text-gray-500 mt-1">Record baseline vitals for arrived patients before they see the
                    provider.</p>
            </div>
            <div class="flex gap-4">
                <div class="bg-orange-50 border border-orange-100 px-4 py-2 rounded-xl text-center">
                    <p class="text-2xl font-black text-orange-500 leading-none">{{ $needsTriage->count() }}</p>
                    <p class="text-[10px] font-bold text-orange-700 uppercase tracking-wider">Waiting</p>
                </div>
                <div class="bg-green-50 border border-green-100 px-4 py-2 rounded-xl text-center">
                    <p class="text-2xl font-black text-green-500 leading-none">{{ $readyForDoctor->count() }}</p>
                    <p class="text-[10px] font-bold text-green-700 uppercase tracking-wider">Ready</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <div class="lg:col-span-5 flex flex-col gap-6">
                <div
                    class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm overflow-hidden flex flex-col h-[400px]">
                    <div class="p-4 bg-orange-50/50 border-b border-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-orange-500 animate-pulse"></span>
                        <h3 class="font-bold text-gray-800">Needs Triage</h3>
                    </div>

                    <div class="overflow-y-auto flex-1 p-3 space-y-2 custom-scrollbar">
                        @forelse($needsTriage as $apt)
                            <div onclick="selectPatient('{{ $apt->id }}', '{{ $apt->patient->first_name ?? '' }} {{ $apt->patient->last_name ?? '' }}', '{{ \Carbon\Carbon::parse($apt->appointment_date)->format('h:i A') }}', 'Dr. {{ $apt->doctor->last_name ?? '' }}')"
                                class="p-4 rounded-xl border border-gray-200 bg-white hover:border-securx-cyan hover:shadow-md cursor-pointer transition-all group">
                                <div class="flex justify-between items-start mb-1">
                                    <p class="font-bold text-securx-navy group-hover:text-securx-cyan transition">
                                        {{ $apt->patient->first_name ?? 'Unknown' }} {{ $apt->patient->last_name ?? '' }}
                                    </p>
                                    <span
                                        class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('h:i A') }}</span>
                                </div>
                                <p class="text-xs text-gray-500">Provider: Dr. {{ $apt->doctor->last_name ?? '' }}</p>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-400 text-sm">No patients waiting for triage.</div>
                        @endforelse
                    </div>
                </div>

                <div
                    class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm overflow-hidden flex flex-col flex-1">
                    <div class="p-4 bg-green-50/50 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h3 class="font-bold text-gray-800">Ready for Doctor</h3>
                    </div>
                    <div class="p-3 space-y-2">
                        @foreach ($readyForDoctor as $apt)
                            <div
                                class="p-3 rounded-xl border border-green-100 bg-green-50/30 flex justify-between items-center opacity-70">
                                <div>
                                    <p class="font-bold text-securx-navy text-sm">{{ $apt->patient->first_name ?? '' }}
                                        {{ $apt->patient->last_name ?? '' }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase">Vitals Logged</p>
                                </div>
                                <span
                                    class="text-xs font-bold text-green-600">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('h:i A') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div
                class="lg:col-span-7 bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm overflow-hidden flex flex-col h-full min-h-[600px]">

                <div id="empty_state" class="flex-1 flex flex-col items-center justify-center text-center p-10">
                    <div
                        class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100 shadow-inner">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-securx-navy">Select a Patient</h3>
                    <p class="text-sm text-gray-500 max-w-sm mt-2">Click on a patient from the "Needs Triage" queue on the
                        left to begin recording their baseline vitals.</p>
                </div>

                <div id="triage_form_container" class="hidden flex-col h-full">
                    <div class="p-6 bg-slate-800 text-white border-b border-slate-700">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-securx-cyan text-xs font-bold uppercase tracking-widest mb-1">Active Triage
                                    Profile</p>
                                <h2 id="display_name" class="text-2xl font-black">Patient Name</h2>
                                <p id="display_provider" class="text-sm text-slate-400 mt-1">Provider</p>
                            </div>
                            <span id="display_time"
                                class="bg-white/10 px-3 py-1.5 rounded-lg text-sm font-bold shadow-inner">Time</span>
                        </div>
                    </div>

                    <form id="triage_form" action="{{ route('secretary.triage.store') }}" method="POST"
                        class="p-8 flex-1 flex flex-col justify-between">
                        @csrf
                        <input type="hidden" name="appointment_id" id="form_appointment_id">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700">Blood
                                    Pressure</label>
                                <input type="text" name="blood_pressure" placeholder="120/80" required
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 bg-slate-50 py-3 pl-4 font-mono text-lg">
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700">Heart Rate
                                    (bpm)</label>
                                <input type="number" name="heart_rate" placeholder="75" required
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan bg-slate-50 py-3 pl-4 font-mono text-lg">
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700">Temperature
                                    (°C)</label>
                                <input type="number" step="0.1" name="temperature" placeholder="36.5" required
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan bg-slate-50 py-3 pl-4 font-mono text-lg">
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-bold text-gray-700">Weight (kg)</label>
                                <input type="number" step="0.1" name="weight" placeholder="65.0" required
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan bg-slate-50 py-3 pl-4 font-mono text-lg">
                            </div>
                        </div>

                        <div class="mt-6 space-y-2">
                            <label class="block text-sm font-bold text-gray-700">Chief Complaint / Notes (Optional)</label>
                            <textarea name="notes" rows="2"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan bg-slate-50 py-2.5 px-3 text-sm placeholder-gray-400"></textarea>
                        </div>

                        <div class="pt-6 mt-6 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex gap-3">
                                <button type="button" onclick="closeTriage()"
                                    class="text-sm font-bold text-gray-400 hover:text-gray-600 px-2">Cancel</button>

                                <form id="no_show_form" action="{{ route('secretary.appointments.no-show') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="appointment_id" id="no_show_appointment_id">
                                    <button type="submit"
                                        class="text-xs font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 border border-red-100 px-4 py-2.5 rounded-lg transition shadow-sm">Mark
                                        as No Show</button>
                                </form>
                            </div>

                            <button type="submit" form="triage_form"
                                class="bg-securx-cyan hover:bg-cyan-500 text-white font-bold py-3 px-8 rounded-xl transition shadow-[0_4px_14px_0_rgba(28,181,209,0.39)] flex items-center gap-2">
                                Save & Send to Doctor
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
