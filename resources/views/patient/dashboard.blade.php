@extends('layouts.patient')

@section('page_title', 'Patient Dashboard')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">

        <div
            class="glass-panel p-8 bg-white/80 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="absolute top-0 right-0 w-64 h-64 bg-securx-cyan/10 rounded-bl-full pointer-events-none -z-10"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-securx-navy mb-2">Welcome back, {{ $user->first_name }}.</h1>
                <p class="text-gray-600 font-medium">Your medical profile is up to date. You have <span
                        class="text-securx-cyan font-bold">{{ $activePrescriptionsCount }} active prescriptions</span> ready
                    for dispensing.</p>
            </div>

            <div class="relative z-10 w-full md:w-auto">
                @if (isset($recentPrescriptions) &&
                        $recentPrescriptions->isNotEmpty() &&
                        $recentPrescriptions->first()->status === 'active')
                    <a href="{{ route('patient.qr-live', $recentPrescriptions->first()->id) }}"
                        class="glass-btn-primary flex items-center justify-center gap-2 py-3 px-8 shadow-[0_4px_14px_0_rgba(28,181,209,0.39)]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                            </path>
                        </svg>
                        View Latest QR Code
                    </a>
                @else
                    <a href="{{ route('patient.prescriptions') }}"
                        class="glass-btn-primary flex items-center justify-center gap-2 py-3 px-8 shadow-[0_4px_14px_0_rgba(28,181,209,0.39)]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        View Prescriptions
                    </a>
                @endif
            </div>
        </div>

        @if (isset($nextAppointment) && $nextAppointment)
            <div
                class="glass-panel p-5 bg-gradient-to-r from-slate-900 to-securx-navy rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4 shadow-xl border border-slate-700 relative overflow-hidden group hover:border-securx-cyan/50 transition-colors">
                <div
                    class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-securx-cyan/10 to-transparent pointer-events-none">
                </div>

                <div class="flex items-center gap-4 z-10 w-full md:w-auto">
                    <div class="bg-white/10 p-3.5 rounded-xl border border-white/10 text-securx-cyan backdrop-blur-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <p class="text-securx-cyan text-xs font-bold uppercase tracking-wider">Next Appointment</p>
                            @if ($nextAppointment->status === 'confirmed')
                                <span
                                    class="bg-green-500/20 text-green-400 text-[9px] uppercase font-bold px-1.5 py-0.5 rounded border border-green-500/30">Confirmed</span>
                            @else
                                <span
                                    class="bg-securx-gold/20 text-securx-gold text-[9px] uppercase font-bold px-1.5 py-0.5 rounded border border-securx-gold/30">Pending</span>
                            @endif
                        </div>
                        <h4 class="text-white font-bold text-lg md:text-xl">Dr. {{ $nextAppointment->doctor->last_name }}
                            &bull; {{ $nextAppointment->appointment_date->format('F d, Y') }}</h4>
                        <p class="text-slate-300 text-sm flex items-center gap-1.5 mt-1">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $nextAppointment->appointment_date->format('h:i A') }}
                            <span class="mx-2 opacity-30">|</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $nextAppointment->doctor->doctorProfile->clinic->clinic_name ?? 'Primary Clinic' }}
                        </p>
                    </div>
                </div>

                <div class="z-10 w-full md:w-auto">
                    <a href="{{ route('patient.appointments') }}"
                        class="block w-full md:w-auto text-center px-6 py-3 bg-white/10 hover:bg-white text-white hover:text-securx-navy font-bold rounded-xl border border-white/20 transition-all shadow-sm">
                        View Details
                    </a>
                </div>
            </div>
        @else
            <div
                class="glass-panel p-4 bg-white/60 border border-dashed border-securx-cyan/40 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4 hover:bg-white transition-colors">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-50 p-3 rounded-xl text-securx-cyan border border-blue-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-securx-navy font-bold">No Upcoming Appointments</h4>
                        <p class="text-gray-500 text-sm">Stay on top of your health by scheduling your next check-up with a
                            verified doctor.</p>
                    </div>
                </div>
                <a href="{{ route('patient.appointments.book') }}"
                    class="w-full md:w-auto text-center px-6 py-2.5 text-sm font-bold bg-securx-cyan text-white rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    Book Now
                </a>
            </div>
        @endif

        <div>
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 px-1">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <a href="{{ route('patient.appointments.book') }}"
                    class="glass-panel p-5 bg-white/60 hover:bg-white hover:-translate-y-1 transition-all flex flex-col items-center text-center gap-3 group border border-transparent hover:border-securx-cyan/30">
                    <div
                        class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-bold text-securx-navy text-sm">Book Visit</span>
                </a>

                <a href="{{ route('patient.prescriptions') }}"
                    class="glass-panel p-5 bg-white/60 hover:bg-white hover:-translate-y-1 transition-all flex flex-col items-center text-center gap-3 group border border-transparent hover:border-securx-cyan/30">
                    <div
                        class="w-12 h-12 rounded-full bg-securx-cyan/10 text-securx-cyan flex items-center justify-center group-hover:bg-securx-cyan group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-bold text-securx-navy text-sm">My Prescriptions</span>
                </a>

                <a href="{{ route('patient.profile.medical') }}"
                    class="glass-panel p-5 bg-white/60 hover:bg-white hover:-translate-y-1 transition-all flex flex-col items-center text-center gap-3 group border border-transparent hover:border-slate-800/30">
                    <div
                        class="w-12 h-12 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-slate-800 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-securx-navy text-sm">Clinical Record</span>
                </a>

                <a href="{{ route('patient.consent') }}"
                    class="glass-panel p-5 bg-white/60 hover:bg-white hover:-translate-y-1 transition-all flex flex-col items-center text-center gap-3 group border border-transparent hover:border-green-500/30">
                    <div
                        class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-bold text-securx-navy text-sm">Data Consent</span>
                </a>

            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 glass-panel overflow-hidden bg-white/80 flex flex-col h-full">
                <div class="p-6 border-b border-gray-200/60 flex justify-between items-center bg-white/50">
                    <h3 class="text-lg font-bold text-securx-navy">Recent Prescriptions</h3>
                    <a href="{{ route('patient.prescriptions') }}"
                        class="text-sm font-bold text-securx-cyan hover:text-securx-navy transition">View All &rarr;</a>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 text-xs text-gray-500 uppercase tracking-wider">
                                <th class="p-4 font-bold">Details</th>
                                <th class="p-4 font-bold">Prescribed By</th>
                                <th class="p-4 font-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                            @if (isset($recentPrescriptions))
                                @forelse($recentPrescriptions as $prescription)
                                    <tr class="hover:bg-white/40 transition">
                                        <td class="p-4">
                                            <p class="font-bold text-securx-navy">
                                                {{ $prescription->items->first()->medication->generic_name ?? 'Medication Data' }}
                                                @if ($prescription->items->count() > 1)
                                                    <span
                                                        class="text-xs text-securx-cyan">+{{ $prescription->items->count() - 1 }}
                                                        more</span>
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $prescription->created_at->format('M d, Y') }}</p>
                                        </td>
                                        <td class="p-4 font-medium">Dr.
                                            {{ $prescription->doctor->last_name ?? 'Unknown' }}
                                        </td>
                                        <td class="p-4">
                                            @if ($prescription->status === 'active')
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-500/10 text-green-700 border border-green-500/20">Active</span>
                                            @elseif($prescription->status === 'dispensed')
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-securx-gold/10 text-securx-gold border border-securx-gold/30">Dispensed</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-500/10 text-red-700 border border-red-500/20">{{ ucfirst($prescription->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-8 text-center text-gray-500">
                                            <div class="flex justify-center mb-3">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="mb-1 font-medium">No prescriptions found.</p>
                                            <p class="text-xs">Your new prescriptions will appear here automatically.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2 px-1">Account Overview</h3>

                <div class="glass-panel p-5 bg-white/60 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500">Active Rx</p>
                        <p class="text-2xl font-extrabold text-securx-navy">{{ $activePrescriptionsCount ?? 0 }}</p>
                    </div>
                    <div
                        class="w-12 h-12 rounded-full bg-securx-cyan/10 text-securx-cyan flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="glass-panel p-5 bg-white/60 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500">Total Visits</p>
                        <p class="text-2xl font-extrabold text-securx-navy">
                            {{ isset($user) ? $user->patientEncounters()->count() : 0 }}</p>
                    </div>
                    <div
                        class="w-12 h-12 rounded-full bg-securx-gold/15 text-securx-gold flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="glass-panel p-5 bg-white/60 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1">Data Consent</p>
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ isset($user) && $user->patientProfile?->data_consent ? 'bg-green-500/10 text-green-700 border border-green-500/20' : 'bg-securx-gold/10 text-securx-gold border border-securx-gold/30' }}">
                            @if (isset($user) && $user->patientProfile?->data_consent)
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                            @else
                                <span class="w-1.5 h-1.5 rounded-full bg-securx-gold"></span> Pending
                            @endif
                        </span>
                    </div>
                    <div
                        class="w-12 h-12 rounded-full {{ isset($user) && $user->patientProfile?->data_consent ? 'bg-green-500/10 text-green-600' : 'bg-securx-gold/10 text-securx-gold' }} flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
