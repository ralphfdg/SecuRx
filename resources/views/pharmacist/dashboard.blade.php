@extends('layouts.pharmacist')

@section('page_title', 'Shift Overview')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        <div
            class="glass-panel p-8 bg-white/80 flex flex-col md:flex-row items-center justify-between gap-6 border-t-4 border-t-emerald-500 shadow-sm rounded-2xl">
            <div>
                <h1 class="text-3xl font-extrabold text-securx-navy mb-1">Active Shift: {{ $pharmacyName }}</h1>
                <p class="text-gray-600 font-medium">You have successfully verified and dispensed
                    <span class="text-emerald-600 font-bold">{{ $totalDispensed ?? 0 }} prescriptions</span> today.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <a href="{{ route('pharmacist.scanner') }}"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] hover:-translate-y-0.5 transition-all duration-300 py-3 px-6 text-base flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                        </path>
                    </svg>
                    Scan QR
                </a>

                <button type="button"
                    class="bg-white hover:bg-gray-50 text-securx-navy border border-gray-200 font-bold rounded-lg shadow-sm hover:-translate-y-0.5 transition-all duration-300 py-3 px-6 text-base flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export Ledger
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div
                class="md:col-span-2 glass-panel p-6 bg-white/80 rounded-2xl border border-gray-200/60 flex flex-col justify-center">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Manual Prescription Lookup</h3>
                <form action="{{ route('pharmacist.api.scan') ?? '#' }}" method="POST" class="flex gap-3">
                    @csrf
                    <input type="text" name="uuid" placeholder="e.g. 8F92A-4B7C1"
                        class="flex-1 rounded-lg border-gray-300 bg-gray-50 text-securx-navy font-mono font-bold focus:border-emerald-500 focus:ring-emerald-500 shadow-sm"
                        required>
                    <button type="submit"
                        class="bg-securx-navy hover:bg-slate-800 text-white px-6 py-2 rounded-lg font-bold transition">
                        Verify
                    </button>
                </form>
                <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Use this if the patient's QR code cannot be scanned by the camera.
                </p>
            </div>

            <div class="glass-panel p-6 bg-securx-gold/5 rounded-2xl border border-securx-gold/30 flex flex-col">
                <h3 class="text-sm font-bold text-securx-gold uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-securx-gold animate-ping"></span>
                    System Alerts
                </h3>
                <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-3">
                    <div class="bg-white p-3 rounded-lg border border-securx-gold/20 shadow-sm">
                        <p class="text-xs font-bold text-securx-navy">DPRI Price Update</p>
                        <p class="text-[10px] text-gray-500 mt-1">DOH reference index for Amoxicillin updated. Check
                            pricing.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-panel p-6 bg-white/60 rounded-2xl flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-emerald-500/10 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500">Dispensed (Shift)</p>
                    <p class="text-2xl font-extrabold text-securx-navy">{{ $totalDispensed ?? 0 }}</p>
                </div>
            </div>
            <div class="glass-panel p-6 bg-white/60 rounded-2xl flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-securx-gold/10 text-securx-gold flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500">DUR Overrides</p>
                    <p class="text-2xl font-extrabold text-securx-navy">{{ $durOverrides ?? 0 }}</p>
                </div>
            </div>
            <div class="glass-panel p-6 bg-white/60 rounded-2xl flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500">Rejected / Blocked</p>
                    <p class="text-2xl font-extrabold text-securx-navy">{{ $rejectedCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="glass-panel overflow-hidden bg-white/80 rounded-2xl border border-gray-200/60">
            <div class="p-6 border-b border-gray-200/60 flex justify-between items-center">
                <h3 class="text-lg font-bold text-securx-navy">Recent Dispensed Prescriptions</h3>
                <a href="{{ route('pharmacist.logs') }}"
                    class="text-sm font-bold text-emerald-600 hover:text-emerald-700 transition">View Full Ledger &rarr;</a>
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
                        @forelse($recentLogs ?? [] as $log)
                            <tr class="hover:bg-white/40 transition">
                                <td class="p-4 text-gray-500 font-medium">
                                    {{ $log->dispensed_at ? $log->dispensed_at->format('h:i A') : 'N/A' }}
                                </td>

                                <td class="p-4 font-bold text-securx-navy">
                                    @if ($log->prescriptionItem && $log->prescriptionItem->prescription && $log->prescriptionItem->prescription->patient)
                                        {{ $log->prescriptionItem->prescription->patient->first_name }}
                                        {{ $log->prescriptionItem->prescription->patient->last_name }}
                                    @else
                                        {{ $log->receiver_name_snapshot ?? 'Walk-in / Unknown' }}
                                    @endif
                                </td>

                                <td class="p-4">
                                    {{ $log->actual_drug_dispensed }}
                                    <span class="text-xs text-gray-400 block">Qty: {{ $log->quantity_dispensed }}</span>
                                </td>

                                <td class="p-4 font-mono text-gray-500 text-xs">
                                    {{ strtoupper(substr($log->prescription_item_id, 0, 8)) }}
                                </td>

                                <td class="p-4 text-right">
                                    <span
                                        class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 border border-emerald-200 px-2.5 py-1 rounded-md text-xs font-bold">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Dispensed
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 font-medium">
                                    No dispensing activity yet for this shift.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($recentLogs->hasPages())
                <div class="p-4 border-t border-gray-200/60 bg-slate-50/50">
                    {{ $recentLogs->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
