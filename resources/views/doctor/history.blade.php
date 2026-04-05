@extends('layouts.doctor')

@section('page_title', 'Consultation History & Revocation')

@section('content')
    <div x-data="{ showRevokeModal: false, activeRx: '' }" class="max-w-7xl mx-auto space-y-6 pb-12 relative">

        <div
            class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Consultation History</h2>
                <p class="text-sm text-gray-500 mt-1">Review past encounters and manage active prescriptions.</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button
                    class="bg-white border border-gray-300 text-gray-600 hover:text-blue-600 hover:border-blue-300 font-bold py-2.5 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export CSV
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2 relative">
                <input type="text"
                    class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3.5 pl-11 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition"
                    placeholder="Search by patient name, ID, or diagnosis...">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <select
                    class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition text-gray-600 font-medium">
                    <option>Filter by Status: All</option>
                    <option>Status: Active (Unscanned)</option>
                    <option>Status: Dispensed</option>
                    <option>Status: Revoked</option>
                </select>
            </div>
            <div>
                <input type="date"
                    class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition text-gray-600 font-medium">
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-gray-200 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="p-4 pl-6">Date & Time</th>
                            <th class="p-4">Patient Information</th>
                            <th class="p-4">Diagnosis / Notes</th>
                            <th class="p-4 text-center">Rx Status</th>
                            <th class="p-4 pr-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">

                        <tr class="hover:bg-slate-50 transition group">
                            <td class="p-4 pl-6 align-top">
                                <p class="font-bold text-securx-navy">Today</p>
                                <p class="text-xs text-gray-500 mt-0.5">10:45 AM</p>
                            </td>
                            <td class="p-4 align-top">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        MC</div>
                                    <div>
                                        <p class="font-bold text-securx-navy">Reyes, Maria Clara</p>
                                        <p class="text-[11px] text-gray-500 font-mono mt-0.5">ID: 019D57-X</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 align-top max-w-[250px] truncate">
                                <p class="font-bold text-securx-navy truncate">Uncomplicated viral URI</p>
                                <p class="text-xs text-gray-500 mt-0.5 truncate">Advised rest and hydration...</p>
                            </td>
                            <td class="p-4 align-top text-center">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black bg-blue-50 text-blue-600 uppercase tracking-widest border border-blue-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                    Active
                                </span>
                            </td>
                            <td class="p-4 pr-6 align-top text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('doctor.history.show', ['id' => 'ENCTR-0992X']) }}"
                                        class="px-3 py-1.5 bg-white border border-gray-200 text-xs font-bold text-gray-600 rounded-lg hover:border-blue-300 hover:text-blue-600 transition shadow-sm inline-block">
                                        View
                                    </a>
                                    <button @click="showRevokeModal = true; activeRx = 'ENCTR-0992X'"
                                        class="px-3 py-1.5 bg-red-50 border border-red-100 text-xs font-bold text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        Revoke
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50 transition group">
                            <td class="p-4 pl-6 align-top">
                                <p class="font-bold text-securx-navy">Apr 04, 2026</p>
                                <p class="text-xs text-gray-500 mt-0.5">02:15 PM</p>
                            </td>
                            <td class="p-4 align-top">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-100 text-gray-500 flex items-center justify-center font-bold text-xs shrink-0">
                                        JD</div>
                                    <div>
                                        <p class="font-bold text-securx-navy">Dela Cruz, Juan</p>
                                        <p class="text-[11px] text-gray-500 font-mono mt-0.5">ID: 882X-P</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 align-top max-w-[250px] truncate">
                                <p class="font-bold text-securx-navy truncate">Essential Hypertension</p>
                                <p class="text-xs text-gray-500 mt-0.5 truncate">Refill for Losartan 50mg...</p>
                            </td>
                            <td class="p-4 align-top text-center">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black bg-emerald-50 text-emerald-600 uppercase tracking-widest border border-emerald-100">
                                    Dispensed
                                </span>
                            </td>
                            <td class="p-4 pr-6 align-top text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('doctor.history.show', ['id' => 'ENCTR-882XP']) }}"
                                        class="px-3 py-1.5 bg-white border border-gray-200 text-xs font-bold text-gray-600 rounded-lg hover:border-blue-300 hover:text-blue-600 transition shadow-sm inline-block">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <tr class="bg-red-50/30 hover:bg-red-50/50 transition group">
                            <td class="p-4 pl-6 align-top">
                                <p class="font-bold text-red-800">Mar 28, 2026</p>
                                <p class="text-xs text-red-400 mt-0.5">09:30 AM</p>
                            </td>
                            <td class="p-4 align-top">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        AS</div>
                                    <div>
                                        <p class="font-bold text-red-800">Santos, Arlene</p>
                                        <p class="text-[11px] text-red-400 font-mono mt-0.5">ID: 334Q-T</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 align-top max-w-[250px] truncate">
                                <p class="font-bold text-red-800 truncate line-through opacity-70">Acute Bronchitis</p>
                                <p class="text-xs text-red-500 mt-0.5 font-bold flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    Rx Cancelled
                                </p>
                            </td>
                            <td class="p-4 align-top text-center">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black bg-red-100 text-red-700 uppercase tracking-widest border border-red-200">
                                    Revoked
                                </span>
                            </td>
                            <td class="p-4 pr-6 align-top text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('doctor.history.show', ['id' => 'ENCTR-334QT']) }}"
                                        class="px-3 py-1.5 bg-white border border-gray-200 text-xs font-bold text-gray-600 rounded-lg hover:border-red-300 hover:text-red-600 transition shadow-sm inline-block">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div
                class="p-4 border-t border-gray-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500 font-medium">Showing <span class="font-bold text-securx-navy">1</span> to
                    <span class="font-bold text-securx-navy">3</span> of <span
                        class="font-bold text-securx-navy">156</span> encounters</p>
                <div class="flex items-center gap-1">
                    <button disabled
                        class="px-3 py-1 text-xs font-bold text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">Prev</button>
                    <button class="px-3 py-1 text-xs font-bold text-white bg-blue-600 rounded-lg">1</button>
                    <button
                        class="px-3 py-1 text-xs font-bold text-gray-600 hover:bg-blue-50 transition rounded-lg">2</button>
                    <button
                        class="px-3 py-1 text-xs font-bold text-gray-600 hover:bg-white border border-gray-200 transition rounded-lg">Next</button>
                </div>
            </div>
        </div>

        <div x-show="showRevokeModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div x-show="showRevokeModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                @click="showRevokeModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showRevokeModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
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
                                    <p class="text-sm text-red-700 font-medium">You are about to permanently invalidate the
                                        QR code for prescription <span class="font-bold text-red-900"
                                            x-text="activeRx"></span>. If the patient presents this at a pharmacy, it will
                                        immediately flag as revoked.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Reason for
                                Revocation (Required)</label>
                            <select
                                class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-red-500 focus:border-red-500 font-medium text-gray-700">
                                <option>Select a clinical reason...</option>
                                <option>Clinical Error / Incorrect Dosage</option>
                                <option>Patient reported adverse reaction</option>
                                <option>Therapy changed before dispensing</option>
                                <option>Suspected fraud or loss</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Security
                                Authorization</label>
                            <input type="password"
                                class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-red-500 focus:border-red-500"
                                placeholder="Enter your account password to confirm">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-200">
                        <button type="button"
                            class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition-colors">
                            Confirm Revocation
                        </button>
                        <button @click="showRevokeModal = false" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
