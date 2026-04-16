@extends('layouts.doctor')

@section('page_title', 'Consultation Console')

@section('content')
    <div x-data="consultationConsole({
        patientId: '{{ $appointment->patient->id ?? '' }}',
        csrfToken: '{{ csrf_token() }}',
        storeRoute: '{{ route('doctor.consultation.store', $appointment->id ?? '') }}'
    })" class="max-w-7xl mx-auto space-y-6 pb-12">

        <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col gap-5 shadow-sm relative z-20">

            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">

                <div class="flex items-center gap-5">
                    <a href="{{ route('doctor.queue') ?? '#' }}"
                        class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition border border-gray-100"
                        title="Back to Queue">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h2 class="text-2xl font-black text-securx-navy leading-none">
                                {{ $appointment->patient->name ?? 'Unknown Patient' }}</h2>
                            <span
                                class="bg-blue-100 text-blue-700 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-widest">Active
                                File</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm font-medium text-gray-500 mt-1">
                            <span>ID: {{ substr($appointment->patient?->id ?? '00000000', 0, 8) }}</span>
                            <span class="text-gray-300">•</span>
                            <span>{{ $appointment->patient->dob ? \Carbon\Carbon::parse($appointment->patient->dob)->age : '--' }}
                                yrs</span>
                            <span class="text-gray-300">•</span>
                            <span class="capitalize">{{ $appointment->patient->gender ?? 'Unknown' }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <button @click="showDurDrawer = true"
                        class="relative p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition border border-amber-200 shadow-sm tooltip-trigger"
                        title="Safety Alerts">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <span x-show="durAlerts.length > 0" x-text="durAlerts.length" x-cloak
                            class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-black text-white shadow-md animate-bounce">
                        </span>
                    </button>
                    <button @click="showTemplatesDrawer = true"
                        class="bg-white border-2 border-gray-200 text-gray-600 hover:border-blue-600 hover:text-blue-600 font-bold py-2 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        SOAP Templates
                    </button>
                    <button @click="showRecordsDrawer = true"
                        class="bg-white border-2 border-securx-navy text-securx-navy hover:bg-securx-navy hover:text-white font-bold py-2 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        View Full Records
                    </button>
                </div>
            </div>

            <div
                class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 bg-slate-50 border border-gray-100 rounded-xl p-4 overflow-hidden w-full">

                <div class="flex flex-col gap-1.5 flex-1 min-w-0 w-full">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Reason / Triage Note</p>

                    <div class="text-sm text-gray-700 leading-snug break-words">
                        <p><span class="text-blue-600 font-black">Rx:</span> <span
                                class="italic">"{{ $appointment->reason_for_visit ?? 'No reason provided.' }}"</span></p>
                        <p><span class="text-emerald-600 font-black">Triage:</span> <span
                                class="italic">"{{ $triageVitals['notes'] ?? 'No notes logged.' }}"</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-5 flex-wrap shrink-0">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">BP</p>
                        <p class="text-sm font-black text-red-500">{{ $triageVitals['blood_pressure'] ?? '--' }}</p>
                    </div>
                    <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">HR</p>
                        <p class="text-sm font-black text-rose-500">
                            {{ $triageVitals['heart_rate'] ?? '--' }}{{ isset($triageVitals['heart_rate']) ? ' bpm' : '' }}
                        </p>
                    </div>
                    <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Temp</p>
                        <p class="text-sm font-black text-securx-navy">
                            {{ $triageVitals['temperature'] ?? '--' }}{{ isset($triageVitals['temperature']) ? '°C' : '' }}
                        </p>
                    </div>
                    <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Wt</p>
                        <p class="text-sm font-black text-securx-navy">
                            {{ $triageVitals['weight'] ?? ($appointment->patient->patientProfile->weight ?? '--') }}{{ isset($triageVitals['weight']) || isset($appointment->patient->patientProfile->weight) ? 'kg' : '' }}
                        </p>
                    </div>
                    <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Ht</p>
                        <p class="text-sm font-black text-securx-navy">
                            {{ $appointment->patient->patientProfile->height ?? '--' }}{{ isset($appointment->patient->patientProfile->height) ? 'cm' : '' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start w-full">

            <div class="lg:col-span-7 xl:col-span-8 space-y-6 min-w-0">

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-slate-50/50">
                        <h3 class="text-base font-black text-securx-navy flex items-center gap-2">
                            <span
                                class="bg-blue-600 text-white w-6 h-6 rounded-md flex items-center justify-center text-xs">1</span>
                            Clinical Notes (SOAP)
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="relative group">
                            <label
                                class="block text-[11px] font-bold text-blue-600 uppercase tracking-wider mb-1.5">Subjective</label>
                            <div
                                class="relative flex items-start bg-slate-50 border border-gray-200 rounded-xl focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all overflow-hidden">
                                <textarea @input="resizeTextarea" x-model="subjective_note"
                                    class="w-full bg-transparent border-0 focus:ring-0 p-4 text-sm text-gray-800 placeholder-gray-400 min-h-[120px] resize-none"
                                    placeholder="What is the chief complaint?"></textarea>
                                <button @click="toggleMic('subjective')"
                                    :class="activeMic === 'subjective' ? 'text-red-500 animate-pulse' :
                                        'text-gray-400 hover:text-blue-600'"
                                    class="p-3 transition self-end">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="relative group">
                            <label
                                class="block text-[11px] font-bold text-emerald-600 uppercase tracking-wider mb-1.5">Objective</label>
                            <div
                                class="relative flex items-start bg-slate-50 border border-gray-200 rounded-xl focus-within:border-emerald-500 focus-within:ring-1 focus-within:ring-emerald-500 transition-all overflow-hidden">
                                <textarea @input="resizeTextarea" x-model="objective_note"
                                    class="w-full bg-transparent border-0 focus:ring-0 p-4 text-sm text-gray-800 placeholder-gray-400 min-h-[120px] resize-none"
                                    placeholder="Physical exam findings..."></textarea>
                                <button @click="toggleMic('objective')"
                                    :class="activeMic === 'objective' ? 'text-red-500 animate-pulse' :
                                        'text-gray-400 hover:text-emerald-600'"
                                    class="p-3 transition self-end">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="relative group">
                            <label
                                class="block text-[11px] font-bold text-purple-600 uppercase tracking-wider mb-1.5">Assessment</label>
                            <div
                                class="relative flex items-start bg-slate-50 border border-gray-200 rounded-xl focus-within:border-purple-500 focus-within:ring-1 focus-within:ring-purple-500 transition-all overflow-hidden">
                                <textarea @input="resizeTextarea" x-model="assessment_note"
                                    class="w-full bg-transparent border-0 focus:ring-0 p-4 text-sm text-gray-800 placeholder-gray-400 min-h-[100px] resize-none"
                                    placeholder="Medical diagnosis..."></textarea>
                                <button @click="toggleMic('assessment')"
                                    :class="activeMic === 'assessment' ? 'text-red-500 animate-pulse' :
                                        'text-gray-400 hover:text-purple-600'"
                                    class="p-3 transition self-end">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="relative group">
                            <label
                                class="block text-[11px] font-bold text-amber-600 uppercase tracking-wider mb-1.5">Plan</label>
                            <div
                                class="relative flex items-start bg-slate-50 border border-gray-200 rounded-xl focus-within:border-amber-500 focus-within:ring-1 focus-within:ring-amber-500 transition-all overflow-hidden">
                                <textarea @input="resizeTextarea" x-model="plan_note"
                                    class="w-full bg-transparent border-0 focus:ring-0 p-4 text-sm text-gray-800 placeholder-gray-400 min-h-[100px] resize-none"
                                    placeholder="Next steps and advice..."></textarea>
                                <button @click="toggleMic('plan')"
                                    :class="activeMic === 'plan' ? 'text-red-500 animate-pulse' :
                                        'text-gray-400 hover:text-amber-600'"
                                    class="p-3 transition self-end">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-visible z-10 relative">
                    <div class="p-5 border-b border-gray-100 bg-slate-50/50">
                        <h3 class="text-base font-black text-securx-navy flex items-center gap-2">
                            <span
                                class="bg-blue-600 text-white w-6 h-6 rounded-md flex items-center justify-center text-xs">2</span>
                            Medication & Instructions
                        </h3>
                    </div>
                    <div class="p-6 flex flex-col gap-5">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="relative flex-grow" wire:ignore>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">OpenFDA
                                    Smart Search</label>
                                <select x-ref="rxnormSearch"
                                    class="w-full bg-slate-50 border border-gray-200 text-securx-navy text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block font-bold shadow-inner"
                                    placeholder="Search drug generic or brand name..."></select>

                                <div x-show="newMed.name"
                                    class="mt-2 flex items-center gap-2 p-2 bg-blue-50 border border-blue-100 rounded-lg"
                                    style="display: none;">
                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-black text-securx-navy" x-text="newMed.name"></span>
                                    <span x-show="newMed.dosage_strength"
                                        class="bg-red-100 text-red-700 border border-red-200 font-black px-1.5 py-0.5 rounded text-[10px] uppercase tracking-wider shadow-sm"
                                        x-text="newMed.dosage_strength"></span>
                                    <span x-show="newMed.form" class="text-xs text-gray-500 font-medium"
                                        x-text="newMed.form"></span>
                                </div>
                            </div>
                            <div class="w-full sm:w-32 shrink-0">
                                <label class="block text-[11px] font-bold text-emerald-600 uppercase tracking-wider mb-1.5"
                                    title="Department of Health Drug Price Reference Index">Est. Price</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold">₱</span>
                                    <input type="number" step="0.01" x-model="newMed.est_price" readonly
                                        class="w-full bg-emerald-50/30 border border-emerald-200 text-emerald-700 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-7 p-3.5 font-bold placeholder-emerald-300"
                                        placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 border-t border-gray-100 pt-5">
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Dose</label>
                                <input type="text" list="dose-options" x-model="newMed.dose"
                                    @input="calculateSigAndQty()"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="e.g. 1 cap">
                                <datalist id="dose-options">
                                    <option value="1 cap">
                                    <option value="1 tab">
                                    <option value="2 caps">
                                    <option value="5 mL">
                                    <option value="10 mL">
                                    <option value="1 sachet">
                                </datalist>
                            </div>

                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Frequency</label>
                                <input type="text" list="freq-options" x-model="newMed.frequency"
                                    @input="calculateSigAndQty()"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="e.g. TID">
                                <datalist id="freq-options">
                                    <option value="OD">
                                    <option value="BID">
                                    <option value="TID">
                                    <option value="QID">
                                    <option value="Q4H">
                                    <option value="As needed (PRN)">
                                </datalist>
                            </div>

                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Duration</label>
                                <input type="number" list="duration-options" x-model="newMed.duration"
                                    @input="calculateSigAndQty()"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Days">
                                <datalist id="duration-options">
                                    <option value="3">
                                    <option value="5">
                                    <option value="7">
                                    <option value="14">
                                    <option value="30">
                                </datalist>
                            </div>

                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Qty</label>
                                <input type="number" x-model="newMed.quantity"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="0">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <div class="flex justify-between items-end mb-1.5">
                                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Sig
                                        (Directions)</label>
                                    <button type="button" @click="calculateSigAndQty()"
                                        class="text-[9px] text-blue-600 hover:text-blue-800 font-black uppercase tracking-wider transition">
                                        Auto-Fill
                                    </button>
                                </div>
                                <input type="text" x-model="newMed.sig"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500 italic placeholder-gray-400"
                                    placeholder="e.g. Take 1 tab OD">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">To
                                    Pharmacist</label>
                                <input type="text" x-model="newMed.pharmacist_instructions"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500 italic placeholder-gray-400"
                                    placeholder="e.g. Exact brand only">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">To
                                    Patient</label>
                                <input type="text" x-model="newMed.patient_instructions"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500 italic placeholder-gray-400"
                                    placeholder="e.g. Take with meal">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button @click="addMedication()" type="button"
                                class="w-full bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-600 hover:text-white font-black py-3 px-8 rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add to Prescription
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-visible z-0 relative">
                    <div class="p-5 border-b border-gray-100 bg-slate-50/50">
                        <h3 class="text-base font-black text-securx-navy flex items-center gap-2">
                            <span
                                class="bg-blue-600 text-white w-6 h-6 rounded-md flex items-center justify-center text-xs">3</span>
                            Final Details & Sign-off
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <label
                            class="flex items-center gap-3 cursor-pointer p-4 border border-blue-100 bg-blue-50/50 rounded-xl hover:bg-blue-50 transition">
                            <input type="checkbox" x-model="showPatientName"
                                class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500 border-gray-300 shadow-sm">
                            <div>
                                <span class="block text-sm font-bold text-securx-navy">Print Patient Name on
                                    Prescription</span>
                                <span class="block text-[10px] text-gray-500 mt-0.5">Leave unchecked for visual anonymity
                                    (Data remains inside encrypted QR)</span>
                            </div>
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">General
                                    Rx Instructions</label>
                                <textarea x-model="generalInstructions"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500 resize-none h-[50px] custom-scrollbar"
                                    placeholder="e.g. Avoid strenuous activities..."></textarea>
                            </div>
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Next
                                    Appointment Date</label>
                                <input type="date" x-model="nextAppointment"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 xl:col-span-4 sticky top-6 min-w-0 flex flex-col h-[calc(100vh-3rem)]">
                <div class="flex items-center gap-2 mb-3 px-1 shrink-0">
                    <span
                        class="bg-emerald-600 text-white w-6 h-6 rounded-md flex items-center justify-center text-xs font-black">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </span>
                    <h3 class="text-base font-black text-securx-navy">Review & Sign</h3>
                    <span class="ml-auto text-xs font-bold text-gray-400 uppercase">Live Preview</span>
                </div>

                <div
                    class="bg-white shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 relative flex flex-col w-full rounded-sm overflow-hidden flex-1 min-h-0">
                    <div class="h-2 w-full bg-securx-navy shrink-0"></div>

                    <div class="p-4 sm:p-5 flex-1 flex flex-col relative z-10 min-h-0">

                        <div class="w-full flex justify-center mb-3 shrink-0">
                            <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx" class="h-3 w-auto">
                        </div>

                        <div class="flex flex-row items-center gap-3 border-b-2 border-gray-800 pb-3 mb-3 shrink-0">
                            <div
                                class="w-12 h-12 bg-white border border-gray-200 rounded-lg flex flex-col items-center justify-center shrink-0 overflow-hidden">
                                @if (!empty($doctorProfile->clinic->clinic_logo))
                                    <img src="{{ asset('storage/' . $doctorProfile->clinic->clinic_logo) }}"
                                        alt="Clinic Logo" class="w-full h-full object-contain p-1">
                                @else
                                    <svg class="w-6 h-6 text-blue-800 opacity-80" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                @endif
                            </div>

                            <div class="flex-1 flex flex-col min-w-0">
                                <h1
                                    class="text-base sm:text-lg font-serif font-black text-gray-900 tracking-wide uppercase text-center mb-1 leading-tight">
                                    {{ $doctorProfile->clinic->clinic_name ?? 'MEDICAL CLINIC INC.' }}
                                </h1>

                                <div
                                    class="flex flex-col xl:flex-row justify-between items-center xl:items-start gap-1 w-full">
                                    <p
                                        class="text-[9px] sm:text-[10px] font-serif text-gray-600 leading-snug flex-1 text-center xl:text-left">
                                        {{ $doctorProfile->clinic->clinic_address ?? '123 Health Avenue, Medical District, City' }}
                                    </p>
                                    <p
                                        class="text-[9px] sm:text-[10px] font-serif text-gray-800 font-bold shrink-0 text-center xl:text-right whitespace-nowrap mt-0.5 xl:mt-0">
                                        Tel: {{ $doctorProfile->clinic->contact_number ?? '(000) 123-4567' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-[9px] font-serif text-gray-800 mb-3 border-b border-gray-300 pb-2 shrink-0">
                            <div class="col-span-2">
                                <p class="text-[7px] font-bold text-gray-500 uppercase">Name:</p>
                                <p class="font-bold border-b border-gray-300 border-dotted truncate"
                                    :class="!showPatientName ? 'text-gray-400 italic' : 'text-gray-900'"
                                    x-text="showPatientName ? {{ Js::from($appointment->patient?->name ?? 'Unknown') }} : '____________________'">
                                </p>
                            </div>
                            <div class="col-span-1">
                                <p class="text-[7px] font-bold text-gray-500 uppercase">Age/Sex:</p>
                                <p class="font-bold border-b border-gray-300 border-dotted"
                                    :class="!showPatientName ? 'text-gray-400 italic' : 'text-gray-900'"
                                    x-text="showPatientName ? '{{ $appointment->patient->dob ? \Carbon\Carbon::parse($appointment->patient->dob)->age : 'N/A' }}/{{ strtoupper(substr($appointment->patient->gender ?? 'U', 0, 1)) }}' : '__________'">
                                </p>
                            </div>
                            <div class="col-span-1">
                                <p class="text-[7px] font-bold text-gray-500 uppercase">Date:</p>
                                <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">
                                    {{ date('m/d/Y') }}</p>
                            </div>
                        </div>

                        <div class="mb-1 shrink-0">
                            <span class="text-3xl font-serif font-black text-gray-900 italic tracking-tighter">Rx</span>
                        </div>

                        <div
                            class="flex-1 space-y-3 pl-1 font-serif overflow-y-auto custom-scrollbar pr-2 flex flex-col min-h-0 relative">
                            <template x-for="(med, index) in medications" :key="index">
                                <div class="relative group">
                                    <button @click="removeMedication(index)" type="button"
                                        class="absolute -left-2 top-0 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <p class="text-xs font-bold text-gray-900 flex items-center flex-wrap gap-1.5">
                                        <span x-text="`${index + 1}. ${med.name}`"></span>
                                        <span x-show="med.dosage_strength"
                                            class="bg-red-100 text-red-700 border border-red-200 font-black px-1 py-0.5 rounded text-[9px] uppercase tracking-wider shadow-sm"
                                            x-text="med.dosage_strength"></span>
                                        <span x-show="med.form" class="text-[10px] text-gray-500 font-medium"
                                            x-text="med.form"></span>
                                    </p>
                                    <div class="flex justify-between items-end mt-0.5">
                                        <p class="text-[11px] text-gray-700 italic"
                                            x-text="`Sig: ${med.sig || 'Take as directed'}`"></p>
                                        <p class="text-[11px] font-bold text-gray-900" x-text="`#${med.quantity || ''}`">
                                        </p>
                                    </div>
                                    <p x-show="med.pharmacist_instructions"
                                        class="text-[8px] text-gray-500 italic mt-0.5 border-l border-gray-300 pl-2 ml-1"
                                        x-text="`To Rx: ${med.pharmacist_instructions}`"></p>
                                    <p x-show="med.patient_instructions"
                                        class="text-[8px] text-blue-600 italic mt-0.5 border-l border-blue-200 pl-2 ml-1"
                                        x-text="`To Pt: ${med.patient_instructions}`"></p>
                                </div>
                            </template>
                            <div x-show="medications.length === 0" class="text-xs text-gray-400 italic">No medications
                                prescribed yet.</div>

                            <div class="pt-2 border-t border-gray-200 border-dashed shrink-0"
                                x-show="generalInstructions || nextAppointment" style="display: none;">
                                <div x-show="generalInstructions" class="mb-1.5">
                                    <p class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">Additional
                                        Instructions:</p>
                                    <p class="text-[10px] font-serif text-gray-800 mt-0.5 italic"
                                        x-text="generalInstructions"></p>
                                </div>
                                <div x-show="nextAppointment">
                                    <p class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">Next
                                        Appointment:</p>
                                    <p class="text-[10px] font-serif text-gray-900 mt-0.5 font-bold"
                                        x-text="nextAppointment"></p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 pt-2 border-t border-gray-100 shrink-0">
                            <div class="flex justify-between items-end">
                                <div x-show="!prescriptionId"
                                    class="w-12 h-12 bg-gray-50 border border-gray-200 flex flex-col items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                        </path>
                                    </svg>
                                    <span class="text-[5px] text-gray-400 mt-1 font-sans">QR PENDING</span>
                                </div>

                                <div x-show="prescriptionId" class="w-12 h-12 shrink-0" style="display: none;">
                                    <img :src="'/doctor/api/qr/' + prescriptionId" alt="Prescription QR"
                                        class="w-full h-full object-contain">
                                </div>

                                <div class="text-left w-[140px] ml-auto flex flex-col font-serif">
                                    <div class="relative z-0 space-y-1 text-[9px]">
                                        <div class="relative">
                                            <span class="text-gray-400 tracking-tighter">__________________, MD</span>
                                            <span
                                                class="absolute left-0.5 bottom-0 font-sans font-bold text-blue-800 uppercase opacity-90 truncate max-w-[120px] inline-block"
                                                title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</span>
                                        </div>
                                        <div class="relative">
                                            <span class="text-gray-400">Lic. _______________</span>
                                            <span
                                                class="absolute left-5 bottom-0 font-sans font-bold text-blue-800 opacity-90">{{ $doctorProfile->prc_number ?? 'N/A' }}</span>
                                        </div>
                                        <div class="relative">
                                            <span class="text-gray-400">PTR _______________</span>
                                            <span
                                                class="absolute left-6 bottom-0 font-sans font-bold text-blue-800 opacity-90">{{ $doctorProfile->ptr_number ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button @click="showGenerateModal = true"
                    class="w-full mt-4 shrink-0 bg-securx-navy hover:bg-blue-700 text-white font-black py-4 px-4 rounded-xl transition-all duration-300 shadow-lg flex items-center justify-center gap-2 text-sm">
                    <svg class="w-5 h-5 text-securx-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                    Sign & Generate SecuRx
                </button>
            </div>
        </div>
        <div x-show="showRecordsDrawer || showTemplatesDrawer || showDurDrawer"
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40" x-transition.opacity @click="closeAllDrawers()"
            style="display: none;"></div>

        <div x-show="showGenerateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div x-show="showGenerateModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                @click="!isGenerating && !isGenerated ? showGenerateModal = false : null"></div>
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div x-show="showGenerateModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-md border border-gray-200">
                    <div x-show="!isGenerating && !isGenerated">
                        <div class="bg-blue-50/50 px-6 py-5 border-b border-blue-100 flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-securx-navy">Generate Prescription?</h3>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">This will apply your cryptographic
                                    signature.</p>
                            </div>
                        </div>
                        <div class="px-6 py-6 text-center">
                            <div class="px-6 py-6 text-center">
                                <p class="text-sm text-gray-700 font-bold mb-2">Are you sure you want to finalize this
                                    document?</p>
                                <p class="text-xs text-red-500 font-medium">Once generated, it becomes legally binding and
                                    cannot be edited.</p>

                                <div x-show="medications.length === 0"
                                    class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-sm font-bold flex items-start gap-2 text-left">
                                    <svg class="w-5 h-5 shrink-0 text-amber-600 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <p>Warning: You are finalizing this encounter with NO prescribed medications. A "No Rx"
                                        encounter will be logged.</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex gap-3 border-t border-gray-100">
                            <button @click="showGenerateModal = false"
                                class="flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2.5 rounded-xl transition text-sm">Cancel</button>
                            <button @click="confirmGeneration()"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition shadow-md text-sm">Generate</button>
                        </div>
                    </div>

                    <div x-show="isGenerating" class="px-6 py-12 text-center flex flex-col items-center justify-center">
                        <svg class="animate-spin h-10 w-10 text-blue-600 mb-4" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-black text-securx-navy">Encrypting Document...</h3>
                    </div>

                    <div x-show="isGenerated" style="display: none;">
                        <div class="px-6 py-8 text-center border-b border-gray-100">
                            <div
                                class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-securx-navy">Prescription Ready!</h3>
                        </div>
                        <div class="bg-slate-50 px-6 py-5 flex gap-3">
                            <a :href="generatedPdfUrl" target="_blank" x-show="hasPrescription"
                                class="flex-1 bg-white border border-gray-300 text-gray-700 hover:border-blue-600 font-bold py-2.5 rounded-xl transition text-sm flex items-center justify-center gap-2">
                                Print PDF
                            </a>
                            <a href="{{ route('doctor.dashboard') }}"
                                class="flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2.5 rounded-xl transition text-sm text-center flex items-center justify-center">Done</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showDurDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-sm bg-white shadow-2xl flex flex-col"
            style="display: none;">
            <div class="px-6 py-4 bg-amber-50 border-b border-amber-200 flex justify-between items-center">
                <h2 class="text-lg font-black text-amber-800">DUR Alerts</h2>
                <button @click="showDurDrawer = false" class="text-amber-600"><svg class="w-6 h-6" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>
            <div class="p-6 overflow-y-auto space-y-4">
                <template x-for="(alert, index) in durAlerts" :key="index">
                    <div x-data="{ showFull: false }" class="p-4 rounded-xl border"
                        :class="alert.severity === 'high' ? 'bg-red-50 border-red-200 text-red-800' :
                            'bg-amber-50 border-amber-200 text-amber-800'">

                        <div class="flex items-center gap-2 font-bold mb-1.5">
                            <span class="uppercase text-[10px] tracking-wider" x-text="alert.type"></span>
                            <span x-show="alert.title"
                                class="text-[11px] font-black px-2 py-0.5 bg-white rounded-md shadow-sm"
                                x-text="alert.title"></span>
                        </div>

                        <div class="text-sm font-medium leading-snug">
                            <p x-show="!showFull && alert.message.length > 150"
                                x-text="alert.message.substring(0, 150) + '...'"></p>
                            <p x-show="showFull || alert.message.length <= 150" x-text="alert.message"></p>
                        </div>

                        <button type="button" x-show="alert.message.length > 150" @click="showFull = !showFull"
                            class="text-[10px] font-black mt-3 hover:underline uppercase tracking-wider flex items-center gap-1"
                            :class="alert.severity === 'high' ? 'text-red-600' : 'text-amber-600'">
                            <span x-text="showFull ? 'See less' : 'Read full FDA Warning'"></span>
                        </button>
                    </div>
                </template>
                <div x-show="durAlerts.length === 0" class="text-center text-sm text-gray-500 italic">No alerts found.
                </div>
            </div>
        </div>
        <div x-show="showTemplatesDrawer"
            class="fixed inset-y-0 right-0 z-50 w-full max-w-sm bg-white shadow-2xl flex flex-col" style="display: none;">
            <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-black text-securx-navy">Templates</h2>
                <button @click="showTemplatesDrawer = false" class="text-gray-400"><svg class="w-6 h-6" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>
            <div class="p-4 space-y-3">
                @forelse($soapTemplates ?? [] as $template)
                    <button type="button"
                        @click="
                subjective_note = `{{ addslashes($template->subjective_text) }}`;
                objective_note = `{{ addslashes($template->objective_text) }}`;
                assessment_note = `{{ addslashes($template->assessment_text) }}`;
                plan_note = `{{ addslashes($template->plan_text) }}`;
                showTemplatesDrawer = false;
            "
                        class="w-full text-left p-4 border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-300 transition shadow-sm">
                        <span class="block font-black text-securx-navy">{{ $template->template_name }}</span>
                        <span class="block text-xs text-gray-500 truncate mt-1">{{ $template->assessment_text }}</span>
                    </button>
                @empty
                    <p class="text-sm text-gray-500 italic text-center py-4">No templates found. Create them in your Doctor
                        Settings.</p>
                @endforelse
            </div>
        </div>
        <div x-show="showRecordsDrawer"
            class="fixed inset-y-0 right-0 z-50 w-full max-w-2xl bg-slate-50 shadow-2xl flex flex-col"
            style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-data="{ activeCategory: 'all' }">
            <div class="px-6 py-4 bg-white border-b border-gray-200 flex justify-between items-center shrink-0">
                <h2 class="text-xl font-black text-securx-navy uppercase tracking-tight">Full Medical History</h2>
                <button @click="showRecordsDrawer = false" class="text-gray-400 hover:text-red-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="bg-white border-b border-gray-200 px-6 pt-2 shrink-0 overflow-x-auto flex gap-6 custom-scrollbar">
                <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'border-securx-navy text-securx-navy' :
                        'border-transparent text-gray-500 hover:text-gray-800 hover:border-gray-300'"
                    class="py-3 border-b-2 font-bold text-sm transition whitespace-nowrap">All Records</button>

                <button @click="activeCategory = 'encounter'"
                    :class="activeCategory === 'encounter' ? 'border-blue-600 text-blue-600' :
                        'border-transparent text-gray-500 hover:text-gray-800 hover:border-gray-300'"
                    class="py-3 border-b-2 font-bold text-sm transition whitespace-nowrap">Encounters</button>

                <button @click="activeCategory = 'lab_result'"
                    :class="activeCategory === 'lab_result' ? 'border-purple-600 text-purple-600' :
                        'border-transparent text-gray-500 hover:text-gray-800 hover:border-gray-300'"
                    class="py-3 border-b-2 font-bold text-sm transition whitespace-nowrap">Labs</button>

                <button @click="activeCategory = 'document'"
                    :class="activeCategory === 'document' ? 'border-amber-600 text-amber-600' :
                        'border-transparent text-gray-500 hover:text-gray-800 hover:border-gray-300'"
                    class="py-3 border-b-2 font-bold text-sm transition whitespace-nowrap">Documents</button>

                <button @click="activeCategory = 'immunization'"
                    :class="activeCategory === 'immunization' ? 'border-emerald-600 text-emerald-600' :
                        'border-transparent text-gray-500 hover:text-gray-800 hover:border-gray-300'"
                    class="py-3 border-b-2 font-bold text-sm transition whitespace-nowrap">Immunizations</button>

                <button @click="activeCategory = 'allergy'"
                    :class="activeCategory === 'allergy' ? 'border-rose-600 text-rose-600' :
                        'border-transparent text-gray-500 hover:text-gray-800 hover:border-gray-300'"
                    class="py-3 border-b-2 font-bold text-sm transition whitespace-nowrap">Allergies</button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar">
                <div x-show="isFetchingRecords" class="text-center py-10 italic text-gray-400">Syncing encrypted
                    records...</div>

                <template
                    x-for="(record, index) in patientRecords.filter(r => activeCategory === 'all' || r.type === activeCategory)"
                    :key="record.id">
                    <div x-data="{ expanded: false }"
                        class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:border-blue-400">

                        <div @click="expanded = !expanded" class="p-4 flex items-center gap-4 cursor-pointer">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0"
                                :class="{
                                    'bg-blue-100 text-blue-600': record.type === 'encounter',
                                    'bg-purple-100 text-purple-600': record.type === 'lab_result',
                                    'bg-amber-100 text-amber-600': record.type === 'document',
                                    'bg-emerald-100 text-emerald-600': record.type === 'immunization',
                                    'bg-rose-100 text-rose-600': record.type === 'allergy'
                                }">
                                <svg x-show="record.type === 'encounter'" class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <svg x-show="record.type === 'allergy'" class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                                <svg x-show="['lab_result', 'document', 'immunization'].includes(record.type)"
                                    class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>

                            <div class="flex-1 truncate">
                                <h4 class="font-black text-securx-navy text-xs uppercase" x-text="record.title"></h4>
                                <p class="text-[10px] text-gray-400 font-bold"
                                    x-text="new Date(record.date).toLocaleDateString()"></p>
                            </div>

                            <div class="flex items-center gap-3">
                                <span x-show="record.is_verified == 0"
                                    class="text-[9px] font-black text-rose-500 bg-rose-50 px-2 py-0.5 rounded border border-rose-100">PENDING</span>
                                <span x-show="record.is_verified == 1"
                                    class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 uppercase">Verified</span>
                            </div>
                        </div>

                        <div x-show="expanded" x-collapse class="px-4 pb-4 pt-2 bg-slate-50 border-t border-gray-100">
                            <div class="space-y-3">
                                <template x-if="record.type === 'encounter'">
                                    <div class="grid grid-cols-2 gap-2 text-[11px]">
                                        <div class="bg-white p-2 rounded border border-gray-100"><span
                                                class="text-blue-500 font-black uppercase block">Subjective</span><span
                                                x-text="record.subjective_note"></span></div>
                                        <div class="bg-white p-2 rounded border border-gray-100"><span
                                                class="text-emerald-500 font-black uppercase block">Objective</span><span
                                                x-text="record.objective_note"></span></div>
                                        <div class="bg-white p-2 rounded border border-gray-100"><span
                                                class="text-purple-500 font-black uppercase block">Assessment</span><span
                                                x-text="record.assessment_note"></span></div>
                                        <div class="bg-white p-2 rounded border border-gray-100"><span
                                                class="text-amber-500 font-black uppercase block">Plan</span><span
                                                x-text="record.plan_note"></span></div>
                                    </div>
                                </template>

                                <template x-if="record.type === 'lab_result' || record.type === 'document'">
                                    <div>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Attached File</span>
                                        <div class="mt-1">
                                            <a :href="record.file_path ? '/storage/' + record.file_path : '#'"
                                                target="_blank"
                                                class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-medium bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition"
                                                x-show="record.file_path">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                    </path>
                                                </svg>
                                                View Attachment
                                            </a>
                                            <p x-show="!record.file_path" class="text-gray-500 italic text-xs">No file
                                                attached.</p>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="record.type === 'immunization'">
                                    <div class="grid grid-cols-2 gap-4 text-[11px]">
                                        <div><span class="text-[10px] font-bold text-gray-400 uppercase">Facility</span>
                                            <p class="mt-0.5 text-gray-800" x-text="record.facility || 'Not specified'">
                                            </p>
                                        </div>
                                        <div><span class="text-[10px] font-bold text-gray-400 uppercase">Valid Until</span>
                                            <p class="mt-0.5 text-gray-800"
                                                x-text="record.valid_until ? new Date(record.valid_until).toLocaleDateString() : 'Lifetime'">
                                            </p>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="record.type === 'allergy'">
                                    <p class="text-xs text-rose-700 font-bold">Reaction: <span class="font-normal"
                                            x-text="record.reaction || 'N/A'"></span></p>
                                </template>

                                <div x-show="record.is_verified == 0" class="flex justify-end pt-2">
                                    <button @click.stop="verifyRecord(record.id, record.type)"
                                        class="text-[10px] font-black bg-securx-navy text-white px-4 py-1.5 rounded-lg hover:bg-blue-600 transition">
                                        Officially Verify
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <p x-show="!isFetchingRecords && patientRecords && patientRecords.filter(r => activeCategory === 'all' || r.type === activeCategory).length === 0"
                    class="text-sm text-center text-gray-400 italic py-8">
                    No <span x-text="activeCategory === 'all' ? 'records' : activeCategory.replace('_', ' ')"></span> found
                    for this patient.
                </p>

            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
@endsection
