@extends('layouts.doctor')

@section('page_title', 'Clinical Insights & Analytics')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-panel p-6 bg-white/80 border-l-4 border-l-securx-cyan">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Total Rx Issued (30 Days)</p>
            <div class="flex items-end gap-3">
                <h3 class="text-4xl font-extrabold text-securx-navy">342</h3>
                <span class="text-sm font-bold text-green-500 mb-1 flex items-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    12%
                </span>
            </div>
        </div>
        
        <div class="glass-panel p-6 bg-white/80 border-l-4 border-l-securx-gold">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Top Prescribed Class</p>
            <div class="flex items-end gap-3">
                <h3 class="text-2xl font-extrabold text-securx-navy">Antibiotics</h3>
            </div>
            <p class="text-xs text-gray-500 mt-1">Accounts for 45% of total volume</p>
        </div>

        <div class="glass-panel p-6 bg-white/80 border-l-4 border-l-red-400">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Revocation Rate</p>
            <div class="flex items-end gap-3">
                <h3 class="text-4xl font-extrabold text-securx-navy">0.8%</h3>
            </div>
            <p class="text-xs text-gray-500 mt-1">3 prescriptions revoked post-issuance</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="glass-panel p-8 bg-white/90 lg:col-span-2 flex flex-col">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-bold text-securx-navy">Prescription Volume (Last 6 Months)</h3>
                <select class="bg-gray-50 border border-gray-200 text-sm font-bold text-gray-600 rounded-lg py-1.5 px-3">
                    <option>2026</option>
                    <option>2025</option>
                </select>
            </div>
            
            <div class="relative h-64 w-full flex items-end justify-between px-2 pb-6 border-b border-gray-200 mt-auto">
                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-6">
                    <div class="w-full border-t border-gray-100 h-0"></div>
                    <div class="w-full border-t border-gray-100 h-0"></div>
                    <div class="w-full border-t border-gray-100 h-0"></div>
                    <div class="w-full border-t border-gray-100 h-0"></div>
                </div>

                <div class="relative w-12 bg-securx-cyan/20 hover:bg-securx-cyan/40 rounded-t-md transition-all h-[40%] group flex justify-center">
                    <span class="absolute -top-7 text-xs font-bold text-securx-navy opacity-0 group-hover:opacity-100 transition-opacity">120</span>
                    <div class="absolute -bottom-6 text-xs font-bold text-gray-400">Oct</div>
                </div>
                <div class="relative w-12 bg-securx-cyan/40 hover:bg-securx-cyan/60 rounded-t-md transition-all h-[65%] group flex justify-center">
                    <span class="absolute -top-7 text-xs font-bold text-securx-navy opacity-0 group-hover:opacity-100 transition-opacity">190</span>
                    <div class="absolute -bottom-6 text-xs font-bold text-gray-400">Nov</div>
                </div>
                <div class="relative w-12 bg-securx-cyan/60 hover:bg-securx-cyan/80 rounded-t-md transition-all h-[50%] group flex justify-center">
                    <span class="absolute -top-7 text-xs font-bold text-securx-navy opacity-0 group-hover:opacity-100 transition-opacity">150</span>
                    <div class="absolute -bottom-6 text-xs font-bold text-gray-400">Dec</div>
                </div>
                <div class="relative w-12 bg-securx-cyan hover:bg-cyan-500 rounded-t-md transition-all h-[80%] group flex justify-center shadow-[0_0_15px_rgba(28,181,209,0.4)]">
                    <span class="absolute -top-7 text-xs font-bold text-securx-navy opacity-0 group-hover:opacity-100 transition-opacity">240</span>
                    <div class="absolute -bottom-6 text-xs font-bold text-gray-400">Jan</div>
                </div>
                <div class="relative w-12 bg-securx-cyan hover:bg-cyan-500 rounded-t-md transition-all h-[95%] group flex justify-center shadow-[0_0_15px_rgba(28,181,209,0.4)]">
                    <span class="absolute -top-7 text-xs font-bold text-securx-navy opacity-0 group-hover:opacity-100 transition-opacity">285</span>
                    <div class="absolute -bottom-6 text-xs font-bold text-gray-400">Feb</div>
                </div>
                <div class="relative w-12 bg-securx-cyan/80 hover:bg-securx-cyan rounded-t-md transition-all h-[75%] group flex justify-center">
                    <span class="absolute -top-7 text-xs font-bold text-securx-navy opacity-0 group-hover:opacity-100 transition-opacity">225</span>
                    <div class="absolute -bottom-6 text-xs font-bold text-securx-navy">Mar</div>
                </div>
            </div>
        </div>

        <div class="glass-panel p-8 bg-white/90">
            <h3 class="text-lg font-bold text-securx-navy mb-6">Top Medications</h3>
            
            <div class="space-y-5">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-700">Amoxicillin</span>
                        <span class="font-bold text-securx-navy">35%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-securx-cyan h-2 rounded-full" style="width: 35%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-700">Lisinopril</span>
                        <span class="font-bold text-securx-navy">28%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-securx-navy h-2 rounded-full opacity-80" style="width: 28%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-700">Metformin</span>
                        <span class="font-bold text-securx-navy">20%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-securx-gold h-2 rounded-full" style="width: 20%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-700">Atorvastatin</span>
                        <span class="font-bold text-securx-navy">12%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-gray-400 h-2 rounded-full" style="width: 12%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection