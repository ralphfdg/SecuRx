@extends('layouts.doctor')

@section('page_title', 'Encounter Details')

@section('content')
    @php
        $patient = $encounter->patient;
        $profile = $patient->patientProfile;
        $age = $patient->dob ? \Carbon\Carbon::parse($patient->dob)->age : '--';
        $initials = strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1));

        // Decode triage vitals if it's a JSON string, or just use it if it's already cast to an array
        $vitals = is_string($encounter->triage_vitals)
            ? json_decode($encounter->triage_vitals, true)
            : $encounter->triage_vitals ?? [];

        // Grab the primary prescription for this encounter
        $rx = $encounter->prescriptions->first();
    @endphp

    <div x-data="{ showRevokeModal: false }" class="max-w-7xl mx-auto space-y-6 pb-12">

        <div
            class="bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl p-5 flex flex-col md:flex-row md:items-center justify-between shadow-sm">
            <div class="flex items-center gap-5">
                <a href="{{ route('doctor.history') }}"
                    class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition border border-gray-100"
                    title="Back to History">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h2 class="text-xl font-black text-securx-navy leading-none">Consultation Record</h2>

                        @if (!$rx)
                            <span
                                class="bg-gray-50 text-gray-600 border border-gray-200 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-widest">No
                                Rx Issued</span>
                        @elseif($rx->status === 'active')
                            <span
                                class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-widest flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>Active (Unscanned)
                            </span>
                        @elseif($rx->status === 'dispensed')
                            <span
                                class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-widest">Dispensed</span>
                        @elseif($rx->status === 'revoked')
                            <span
                                class="bg-red-50 text-red-600 border border-red-100 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-widest">Revoked</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Date:
                        {{ \Carbon\Carbon::parse($encounter->encounter_date)->format('M d, Y • h:i A') }} • Ref:
                        {{ strtoupper(substr($encounter->id, 0, 8)) }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-4 md:mt-0">
                @if ($rx)
                    <button onclick="window.print()"
                        class="bg-white border border-gray-300 text-gray-600 hover:border-blue-300 hover:text-blue-600 font-bold py-2 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Print PDF
                    </button>
                    @if ($rx->status === 'active')
                        <button @click="showRevokeModal = true"
                            class="bg-red-50 border border-red-100 text-red-600 hover:bg-red-600 hover:text-white font-bold py-2 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Revoke Rx
                        </button>
                    @endif
                @endif
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">

            <div class="w-full lg:w-1/2 xl:w-5/12 space-y-6">

                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Patient Profile</h3>
                    <div class="flex items-center gap-4 mb-4 border-b border-gray-100 pb-4">
                        <div
                            class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xl shrink-0">
                            {{ $initials }}</div>
                        <div>
                            <p class="font-black text-securx-navy text-lg leading-none">{{ $patient->last_name }},
                                {{ $patient->first_name }}</p>
                            <p class="text-sm text-gray-500 font-medium mt-1">ID: {{ substr($patient->id, 0, 8) }} •
                                {{ $age }} yrs • {{ $patient->gender ?? 'Unknown' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 bg-slate-50 p-3 rounded-xl border border-gray-100">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">BP</p>
                            <p class="text-sm font-black text-red-500">{{ $vitals['blood_pressure'] ?? '--' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">Temp</p>
                            <p class="text-sm font-black text-securx-navy">{{ $vitals['temperature'] ?? '--' }}°C</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">Weight</p>
                            <p class="text-sm font-black text-securx-navy">
                                {{ $vitals['weight'] ?? ($profile->weight ?? '--') }}kg</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-slate-50/50">
                        <h3 class="text-sm font-black text-securx-navy">Clinical Notes (SOAP)</h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider mb-1">Subjective</p>
                            <div
                                class="bg-slate-50 border border-gray-100 p-3 rounded-lg text-sm text-gray-700 font-medium leading-relaxed">
                                {{ $encounter->subjective_note ?? 'No subjective notes recorded.' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider mb-1">Objective</p>
                            <div
                                class="bg-slate-50 border border-gray-100 p-3 rounded-lg text-sm text-gray-700 font-medium leading-relaxed">
                                {{ $encounter->objective_note ?? 'No objective notes recorded.' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-purple-600 uppercase tracking-wider mb-1">Assessment</p>
                            <div
                                class="bg-slate-50 border border-gray-100 p-3 rounded-lg text-sm text-gray-700 font-medium leading-relaxed">
                                {{ $encounter->assessment_note ?? 'No assessment recorded.' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-amber-600 uppercase tracking-wider mb-1">Plan</p>
                            <div
                                class="bg-slate-50 border border-gray-100 p-3 rounded-lg text-sm text-gray-700 font-medium leading-relaxed">
                                {{ $encounter->plan_note ?? 'No plan recorded.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 xl:w-7/12 print:w-full print:m-0 flex flex-col items-center relative">

                @if ($rx && $rx->status === 'revoked')
                    <div class="absolute inset-0 z-50 flex items-center justify-center pointer-events-none print:hidden">
                        <div
                            class="border-8 border-red-500 text-red-500 font-black text-6xl uppercase tracking-widest px-8 py-4 -rotate-45 opacity-60 bg-white/20 backdrop-blur-sm">
                            REVOKED
                        </div>
                    </div>
                @endif

                <div id="prescription-paper"
                    class="bg-white shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 aspect-[1/1.414] relative flex flex-col w-full max-w-[500px] rounded-sm overflow-hidden print:shadow-none print:border-none print:max-w-none {{ $rx && $rx->status === 'revoked' ? 'opacity-70 grayscale print:hidden' : '' }}">

                    <div class="h-2 w-full bg-securx-navy shrink-0"></div>

                    <div class="p-6 flex-1 flex flex-col relative z-10">

                        <div class="text-center border-b-2 border-gray-800 pb-4 mb-4 flex flex-col items-center">
                            <div class="flex items-center justify-center gap-2">
                                <a class="relative inline-block group pt-2 pb-1">
                                    <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                                        class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                                </a>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-4 gap-2 text-[10px] font-serif text-gray-800 mb-4 border-b border-gray-300 pb-3">
                            <div class="col-span-2">
                                <p class="text-[8px] font-bold text-gray-500 uppercase">Name:</p>
                                <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">
                                    {{ $patient->name }}</p>
                            </div>
                            <div class="col-span-1">
                                <p class="text-[8px] font-bold text-gray-500 uppercase">Age/Sex:</p>
                                <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">
                                    {{ $age }}/{{ strtoupper(substr($patient->gender ?? 'U', 0, 1)) }}</p>
                            </div>
                            <div class="col-span-1">
                                <p class="text-[8px] font-bold text-gray-500 uppercase">Date:</p>
                                <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">
                                    {{ \Carbon\Carbon::parse($encounter->encounter_date)->format('m/d/Y') }}</p>
                            </div>
                        </div>

                        <div class="mb-2">
                            <span class="text-4xl font-serif font-black text-gray-900 italic tracking-tighter">Rx</span>
                        </div>

                        <div class="flex-1 space-y-4 pl-2 font-serif overflow-y-auto custom-scrollbar pr-2 flex flex-col">
                            @if ($rx && $rx->items->isNotEmpty())
                                @foreach ($rx->items as $index => $item)
                                    <div class="relative group">
                                        <p class="text-sm font-bold text-gray-900">{{ $index + 1 }}.
                                            {{ $item->medication->brand_name ?? $item->medication->generic_name }}
                                            {{ $item->dose }}</p>
                                        <div class="flex justify-between items-end mt-0.5">
                                            <p class="text-xs text-gray-700 italic">Sig: {{ $item->sig }}</p>
                                            <p class="text-xs font-bold text-gray-900">#{{ $item->quantity }}</p>
                                        </div>
                                        @if ($item->pharmacist_instructions)
                                            <p
                                                class="text-[9px] text-gray-500 italic mt-0.5 border-l border-gray-300 pl-2 ml-1">
                                                To Rx: {{ $item->pharmacist_instructions }}</p>
                                        @endif
                                        @if ($item->patient_instructions)
                                            <p
                                                class="text-[9px] text-blue-600 italic mt-0.5 border-l border-blue-200 pl-2 ml-1">
                                                To Pt: {{ $item->patient_instructions }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="text-xs text-gray-400 italic">No medications prescribed yet.</div>
                            @endif

                            <div class="flex-1"></div>

                            @if ($rx && ($rx->general_instructions || $rx->next_appointment_date))
                                <div class="pt-3 border-t border-gray-200 border-dashed">
                                    @if ($rx->general_instructions)
                                        <div class="mb-2">
                                            <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">
                                                Additional Instructions:</p>
                                            <p class="text-[11px] font-serif text-gray-800 mt-0.5 italic">
                                                {{ $rx->general_instructions }}</p>
                                        </div>
                                    @endif
                                    @if ($rx->next_appointment_date)
                                        <div>
                                            <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Next
                                                Appointment:</p>
                                            <p class="text-[11px] font-serif text-gray-900 mt-0.5 font-bold">
                                                {{ \Carbon\Carbon::parse($rx->next_appointment_date)->format('M d, Y') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-100 shrink-0">
                            <div class="flex justify-between items-end">

                                @if ($rx)
                                    <div
                                        class="w-20 h-20 bg-white p-1 border border-gray-200 flex flex-col items-center justify-center shrink-0">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size200x200&data={{ $rx->id }}"
                                            alt="SecuRx QR" class="w-full h-full object-contain">
                                    </div>
                                @else
                                    <div
                                        class="w-20 h-20 bg-gray-50 border border-gray-200 flex flex-col items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                            </path>
                                        </svg>
                                        <span class="text-[6px] text-gray-400 mt-1 font-sans">NO RX</span>
                                    </div>
                                @endif

                                <div class="text-left w-[170px] ml-auto flex flex-col font-serif">
                                    <div class="relative z-0 space-y-1 text-[11px]">
                                        <div class="relative">
                                            <span class="text-gray-400 tracking-tighter">____________________, MD</span>
                                            <span
                                                class="absolute left-0.5 bottom-0.5 font-sans font-bold text-blue-800 uppercase opacity-90">{{ auth()->user()->name }}</span>
                                        </div>
                                        <div class="relative">
                                            <span class="text-gray-400">Lic. _________________</span>
                                            <span
                                                class="absolute left-5 bottom-0.5 font-sans font-bold text-blue-800 opacity-90">{{ $doctorProfile->prc_number ?? 'N/A' }}</span>
                                        </div>
                                        <div class="relative">
                                            <span class="text-gray-400">PTR _________________</span>
                                            <span
                                                class="absolute left-6 bottom-0.5 font-sans font-bold text-blue-800 opacity-90">{{ $doctorProfile->ptr_number ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-center text-gray-400 mt-4 print:hidden">This is a digital preview of the printable
                    document.</p>
            </div>

    @if ($errors->any())
        <div class="fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative z-50"
            role="alert">
            <span class="block sm:inline font-bold">{{ $errors->first() }}</span>
        </div>
    @endif
    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative z-50"
            role="alert">
            <span class="block sm:inline font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if ($rx && $rx->status === 'active')
        <div x-show="showRevokeModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div x-show="showRevokeModal" x-transition.opacity
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                @click="showRevokeModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showRevokeModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-red-100">

                    <div class="bg-red-50/50 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-red-100">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-black leading-6 text-red-800">Revoke Prescription</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-red-700 font-medium">You are about to permanently invalidate
                                        the QR code for prescription <span
                                            class="font-bold text-red-900">{{ substr($rx->id, 0, 8) }}</span>. If the
                                        patient presents this at a pharmacy, it will immediately flag as revoked.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('doctor.history.revoke', $rx->id) }}">
                        @csrf
                        <div class="px-4 py-5 sm:p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Reason
                                    for Revocation</label>
                                <select name="reason" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-red-500 focus:border-red-500 font-medium text-gray-700">
                                    <option value="">Select a clinical reason...</option>
                                    <option value="Clinical Error / Incorrect Dosage">Clinical Error / Incorrect Dosage
                                    </option>
                                    <option value="Patient reported adverse reaction">Patient reported adverse reaction
                                    </option>
                                    <option value="Therapy changed before dispensing">Therapy changed before dispensing
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Security
                                    Authorization</label>
                                <input type="password" name="password" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-red-500 focus:border-red-500"
                                    placeholder="Enter your account password to confirm">
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-200">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition-colors">
                                Confirm Revocation
                            </button>
                            <button type="button" @click="showRevokeModal = false"
                                class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    </div>

    <style>
        @media print {
            body {
                background: white;
            }

            aside,
            header,
            .print\:hidden {
                display: none !important;
            }

            #prescription-paper {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: none !important;
            }
        }
    </style>
@endsection
