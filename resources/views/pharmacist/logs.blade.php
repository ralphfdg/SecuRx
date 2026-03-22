@extends('layouts.pharmacist')

@section('page_title', 'Dispensary Ledger & Audit')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="p-6 bg-slate-800 border border-slate-700 rounded-2xl shadow-lg flex flex-col md:flex-row items-center justify-between gap-5 text-slate-200">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-500/10 rounded-full flex items-center justify-center text-emerald-500 border border-emerald-500/20 flex-shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-white tracking-tight">Shift Dispensing Ledger</h2>
                <p class="text-sm text-slate-400 mt-1">
                    Immutable record of all cryptographic keys decrypted and medications dispensed during your shift.
                </p>
            </div>
        </div>
        <button class="bg-slate-700 hover:bg-slate-600 border border-slate-500 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Shift Report
        </button>
    </div>

    <div class="flex overflow-x-auto border-b border-slate-300 pb-px hide-scrollbar">
        <button onclick="switchLogTab('standard')" id="tab-standard" class="log-tab-btn px-6 py-3 text-sm font-bold border-b-2 border-emerald-500 text-emerald-600 whitespace-nowrap transition-colors">
            Standard Dispenses
        </button>
        <button onclick="switchLogTab('overrides')" id="tab-overrides" class="log-tab-btn px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap transition-colors flex items-center gap-2">
            DUR Overrides (Legal Log)
            <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">2</span>
        </button>
    </div>

    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-0 shadow-lg overflow-hidden min-h-[400px]">

        <div id="content-standard" class="log-tab-content block">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 text-xs text-slate-400 uppercase tracking-wider border-b border-slate-700">
                            <th class="p-4 font-bold">Timestamp</th>
                            <th class="p-4 font-bold">Patient</th>
                            <th class="p-4 font-bold">Dispensed Item</th>
                            <th class="p-4 font-bold">UUID / Lot No.</th>
                            <th class="p-4 font-bold text-right">Verification</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-300 divide-y divide-slate-700/50">
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="p-4">Today, 10:42 AM</td>
                            <td class="p-4 font-bold text-white">Ralph De Guzman</td>
                            <td class="p-4">Amoxicillin 500mg <span class="text-xs text-slate-500 block">Qty: 21</span></td>
                            <td class="p-4 font-mono text-slate-500 text-xs">8F92A-4B7C1<br>LOT-4929</td>
                            <td class="p-4 text-right">
                                <span class="inline-flex items-center gap-1 text-emerald-400 font-bold text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Clean
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="p-4">Today, 09:15 AM</td>
                            <td class="p-4 font-bold text-white">Maria Clara</td>
                            <td class="p-4">Lisinopril 10mg <span class="text-xs text-slate-500 block">Qty: 30</span></td>
                            <td class="p-4 font-mono text-slate-500 text-xs">2C44F-9A1B2<br>LOT-8821</td>
                            <td class="p-4 text-right">
                                <span class="inline-flex items-center gap-1 text-emerald-400 font-bold text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Clean
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="content-overrides" class="log-tab-content hidden p-6 space-y-4">
            
            <div class="bg-slate-900/50 border border-securx-gold/30 rounded-xl p-5 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-securx-gold"></div>
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="text-white font-bold text-lg">Juan Dela Cruz</h4>
                        <p class="text-sm text-slate-400">Atorvastatin 20mg (UUID: 9X77D-3P2M1)</p>
                    </div>
                    <span class="text-xs text-slate-500 font-mono bg-slate-800 px-2 py-1 rounded border border-slate-700">Today, 08:30 AM</span>
                </div>
                
                <div class="bg-slate-800 rounded-lg p-4 mt-3 border border-slate-700">
                    <p class="text-xs font-bold text-securx-gold uppercase tracking-wider mb-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        System Warning
                    </p>
                    <p class="text-sm text-slate-300 mb-3">Patient currently active on Gemfibrozil. Co-administration increases risk of myopathy.</p>
                    
                    <p class="text-xs font-bold text-emerald-400 uppercase tracking-wider mb-1">Pharmacist Justification</p>
                    <p class="text-sm text-white font-medium italic">"Consulted with Dr. Reyes via phone. Dosage of Atorvastatin is low, and patient has been on this combination previously with no adverse effects. Educated patient on signs of muscle pain."</p>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    function switchLogTab(tabId) {
        document.querySelectorAll('.log-tab-content').forEach(el => {
            el.classList.remove('block');
            el.classList.add('hidden');
        });

        document.getElementById('content-' + tabId).classList.remove('hidden');
        document.getElementById('content-' + tabId).classList.add('block');

        document.querySelectorAll('.log-tab-btn').forEach(btn => {
            btn.classList.remove('border-emerald-500', 'text-emerald-600');
            btn.classList.add('border-transparent', 'text-slate-500');
        });

        const activeBtn = document.getElementById('tab-' + tabId);
        activeBtn.classList.remove('border-transparent', 'text-slate-500');
        activeBtn.classList.add('border-emerald-500', 'text-emerald-600');
    }
</script>
@endsection