@extends('layouts.pharmacist')

@section('page_title', 'Shift Overview')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        <div
            class="glass-panel p-8 bg-white/80 flex flex-col md:flex-row items-center justify-between gap-6 border-t-4 border-t-emerald-500">
            <div>
                <h1 class="text-3xl font-extrabold text-securx-navy mb-1">Active Shift: Mercury Drug</h1>
                <p class="text-gray-600 font-medium">You have successfully verified and dispensed <span
                        class="text-emerald-600 font-bold">42 prescriptions</span> today.</p>
            </div>

            <a href="#"
                class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] hover:-translate-y-0.5 transition-all duration-300 py-4 px-10 text-lg flex items-center justify-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                    </path>
                </svg>
                Launch QR Scanner
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-panel p-6 bg-white/60 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500">Dispensed (Shift)</p>
                    <p class="text-2xl font-extrabold text-securx-navy">42</p>
                </div>
            </div>
            <div class="glass-panel p-6 bg-white/60 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-securx-gold/10 text-securx-gold flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500">DUR Overrides</p>
                    <p class="text-2xl font-extrabold text-securx-navy">2</p>
                </div>
            </div>
            <div class="glass-panel p-6 bg-white/60 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500">Rejected / Blocked</p>
                    <p class="text-2xl font-extrabold text-securx-navy">1</p>
                </div>
            </div>
        </div>

        <div class="glass-panel overflow-hidden bg-white/80">
            <div class="p-6 border-b border-gray-200/60 flex justify-between items-center">
                <h3 class="text-lg font-bold text-securx-navy">Recent Shift Activity</h3>
                <a href="#" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 transition">View Full
                    Ledger &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="p-4 font-bold">Time</th>
                            <th class="p-4 font-bold">Patient Name</th>
                            <th class="p-4 font-bold">Medication Dispensed</th>
                            <th class="p-4 font-bold">UUID</th>
                            <th class="p-4 font-bold text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                        <tr class="hover:bg-white/40 transition">
                            <td class="p-4 text-gray-500 font-medium">10:42 AM</td>
                            <td class="p-4 font-bold text-securx-navy">Ralph De Guzman</td>
                            <td class="p-4">Amoxicillin 500mg <span class="text-xs text-gray-400 block">Qty: 21</span>
                            </td>
                            <td class="p-4 font-mono text-gray-500 text-xs">8F92A-4B7C1</td>
                            <td class="p-4 text-right">
                                <span
                                    class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 border border-emerald-200 px-2.5 py-1 rounded-md text-xs font-bold">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg> Success
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/40 transition">
                            <td class="p-4 text-gray-500 font-medium">09:15 AM</td>
                            <td class="p-4 font-bold text-securx-navy">Maria Clara</td>
                            <td class="p-4">Lisinopril 10mg <span class="text-xs text-gray-400 block">Qty: 30</span></td>
                            <td class="p-4 font-mono text-gray-500 text-xs">2C44F-9A1B2</td>
                            <td class="p-4 text-right">
                                <span
                                    class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 border border-emerald-200 px-2.5 py-1 rounded-md text-xs font-bold">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg> Success
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/40 transition bg-securx-gold/5">
                            <td class="p-4 text-gray-500 font-medium">08:30 AM</td>
                            <td class="p-4 font-bold text-securx-navy">Juan Dela Cruz</td>
                            <td class="p-4">Atorvastatin 20mg <span class="text-xs text-gray-400 block">Qty: 30</span>
                            </td>
                            <td class="p-4 font-mono text-gray-500 text-xs">9X77D-3P2M1</td>
                            <td class="p-4 text-right">
                                <span
                                    class="inline-flex items-center gap-1 bg-orange-50 text-orange-600 border border-orange-200 px-2.5 py-1 rounded-md text-xs font-bold">
                                    Warning Overridden
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
