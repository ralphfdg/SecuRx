@extends('layouts.pharmacist')

@section('page_title', 'Dispensing Ledger & Audit Logs')

@section('content')
    <div x-data="{ showLogDrawer: false, activeLog: {} }" class="max-w-7xl mx-auto space-y-6 pb-12 relative overflow-hidden">

        <div class="bg-white/60 backdrop-blur-md border border-gray-200/50 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-securx-navy">Shift Dispensing Ledger</h2>
                <p class="text-sm text-gray-500 mt-1 font-medium">Review and audit all cryptographically verified transactions.</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button type="button" class="bg-white border border-gray-300 text-gray-700 hover:text-emerald-600 hover:border-emerald-300 font-bold py-2.5 px-5 rounded-xl transition shadow-sm flex items-center gap-2 text-sm w-full md:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Shift Report (PDF/CSV)
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-6 relative">
                <input type="text" id="searchInput"
                    class="w-full bg-white/80 border border-gray-200 text-sm rounded-xl p-3.5 pl-11 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition font-medium text-securx-navy"
                    placeholder="Search by Patient Name, Drug, or Rx UUID...">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="md:col-span-3">
                <input type="date" id="dateInput"
                    class="w-full bg-white/80 border border-gray-200 text-sm rounded-xl p-3.5 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition font-medium text-gray-600"
                    value="{{ request('date', \Carbon\Carbon::today()->format('Y-m-d')) }}">
            </div>

            <div class="md:col-span-3">
                <select id="statusInput" class="w-full bg-white/80 border border-gray-200 text-sm rounded-xl p-3.5 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition font-medium text-gray-600 h-full">
                    <option value="">All Transactions</option>
                    <option value="standard">Standard Dispense</option>
                    <option value="override">DUR Overrides</option>
                </select>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-gray-200 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="p-4 pl-6">Time & UUID</th>
                            <th class="p-4">Patient</th>
                            <th class="p-4">Drug Dispensed</th>
                            <th class="p-4">Prescriber</th>
                            <th class="p-4 text-center">Status / Audit</th>
                            <th class="p-4 pr-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody id="logsTableBody" data-route="{{ route('pharmacist.logs') }}" class="divide-y divide-gray-100 text-sm">
                        @include('pharmacist.partials._log_rows')
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="showLogDrawer" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40" x-transition.opacity @click="showLogDrawer = false" style="display: none;"></div>

        <div x-show="showLogDrawer"
            class="fixed inset-y-0 right-0 z-50 w-full max-w-xl bg-white shadow-2xl flex flex-col border-l border-gray-200"
            x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
            x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" 
            style="display: none;">

            <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center shrink-0">
                <div>
                    <h2 class="text-xl font-black text-securx-navy">Transaction Receipt</h2>
                    <p class="text-[10px] text-gray-500 font-mono font-bold mt-0.5" x-text="`UUID: ${activeLog.uuid || ''}`"></p>
                </div>
                <button @click="showLogDrawer = false" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar">
                
                <div class="grid grid-cols-2 gap-4 text-sm bg-slate-50 p-4 rounded-xl border border-gray-100">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Timestamp</p>
                        <p class="font-bold text-securx-navy" x-text="activeLog.time"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Patient / Receiver</p>
                        <p class="font-bold text-securx-navy" x-text="activeLog.patient"></p>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-emerald-600 uppercase tracking-widest border-b border-emerald-100 pb-2 mb-4">Inventory Dispensed</h3>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-black text-gray-900 text-lg" x-text="activeLog.drug"></h4>
                                <p class="text-xs font-bold text-gray-500 mt-0.5" x-text="activeLog.prescriber"></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Qty</p>
                                <p class="text-xl font-black text-securx-navy" x-text="activeLog.qty"></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="p-4 border-t border-gray-200 bg-slate-50 flex gap-3 shrink-0">
                <button @click="showLogDrawer = false" class="flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 px-4 rounded-xl transition shadow-sm text-sm">
                    Close
                </button>
                <button class="flex-1 bg-securx-navy hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-xl transition shadow-[0_4px_14px_0_rgba(0,0,0,0.2)] flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Receipt
                </button>
            </div>
        </div>

    </div>

    @vite(['resources/js/pharmacist-logs.js'])

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
    </style>
@endsection