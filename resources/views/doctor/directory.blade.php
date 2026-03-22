@extends('layouts.doctor')

@section('page_title', 'Patient Directory')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="glass-panel p-6 bg-white/80 flex flex-col md:flex-row items-center justify-between gap-4 border-t-4 border-t-securx-cyan">
        <div>
            <h2 class="text-2xl font-extrabold text-securx-navy">Clinical Directory</h2>
            <p class="text-sm text-gray-500 mt-1">Search the SecuRx network for registered patients to review their medical history or issue new prescriptions.</p>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Search by name, DOB, or UUID..." class="glass-input w-full py-2.5 pl-10 pr-4">
            </div>
            <button class="glass-btn-primary py-2.5 px-6 shadow-sm">
                Search
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="glass-panel p-6 bg-white/90 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-securx-navy text-white flex items-center justify-center font-bold text-lg shadow-inner">
                        RD
                    </div>
                    <div>
                        <h3 class="font-bold text-securx-navy text-lg leading-tight">Ralph De Guzman</h3>
                        <p class="text-xs text-gray-500 font-mono">ID: 8F92A-4B7C1</p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-2 mb-6">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 font-medium">Date of Birth:</span>
                    <span class="text-gray-800 font-bold">Jan 15, 2005 (21)</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 font-medium">Blood Type:</span>
                    <span class="text-red-500 font-bold">O+</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 font-medium">DUR Consent:</span>
                    <span class="text-green-600 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Granted
                    </span>
                </div>
            </div>

            <div class="flex gap-2 border-t border-gray-100 pt-4">
                <button class="w-1/2 glass-btn-secondary py-2 text-xs">View Profile</button>
                <button class="w-1/2 glass-btn-primary py-2 text-xs">Prescribe</button>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/90 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-securx-cyan/20 text-securx-cyan flex items-center justify-center font-bold text-lg shadow-inner border border-securx-cyan/30">
                        MC
                    </div>
                    <div>
                        <h3 class="font-bold text-securx-navy text-lg leading-tight">Maria Clara</h3>
                        <p class="text-xs text-gray-500 font-mono">ID: 2C44F-9A1B2</p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-2 mb-6">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 font-medium">Date of Birth:</span>
                    <span class="text-gray-800 font-bold">Oct 02, 1990 (35)</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 font-medium">Blood Type:</span>
                    <span class="text-red-500 font-bold">A-</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 font-medium">DUR Consent:</span>
                    <span class="text-green-600 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Granted
                    </span>
                </div>
            </div>

            <div class="flex gap-2 border-t border-gray-100 pt-4">
                <button class="w-1/2 glass-btn-secondary py-2 text-xs">View Profile</button>
                <button class="w-1/2 glass-btn-primary py-2 text-xs">Prescribe</button>
            </div>
        </div>

        <div class="glass-panel p-6 bg-gray-50/80 border-dashed border-2 border-gray-200 opacity-75">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-lg shadow-inner">
                        JD
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-600 text-lg leading-tight">Juan Dela Cruz</h3>
                        <p class="text-xs text-gray-400 font-mono">ID: 9X77D-3P2M1</p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-2 mb-6 opacity-50 blur-[2px] select-none">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Date of Birth:</span>
                    <span class="text-gray-800 font-bold">Hidden</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Blood Type:</span>
                    <span class="text-red-500 font-bold">Hidden</span>
                </div>
            </div>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/40 backdrop-blur-[1px] rounded-2xl">
                 <div class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-bold border border-red-200 flex items-center gap-1 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Consent Revoked
                </div>
            </div>
        </div>

    </div>
</div>
@endsection