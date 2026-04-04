@extends('layouts.admin')

@section('page_title', 'Health & Metrics')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <div class="glass-panel p-8 bg-white/80 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="absolute top-0 right-0 w-64 h-64 bg-securx-gold/10 rounded-bl-full pointer-events-none -z-10"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold text-securx-navy mb-2">System Health & Metrics</h1>
            <p class="text-gray-600 font-medium">High-level overview of network activity, user distribution, and database status.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="glass-panel p-4 bg-green-50/80 border border-green-200 text-green-700 rounded-xl shadow-sm relative" id="success-alert">
            <span class="font-bold">Success!</span> {{ session('success') }}
            <button type="button" class="absolute top-4 right-4 text-green-700 hover:text-green-900" id="close-alert-btn">
                &times;
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-securx-cyan text-sm font-bold uppercase tracking-wider">System Users</h3>
                <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Online</span>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ $stats['total_doctors'] }} <span class="text-sm font-medium text-gray-500">Doctors</span></p>
                <p class="text-2xl font-bold text-gray-600 mt-1">{{ $stats['total_pharmacists'] }} <span class="text-sm font-medium text-gray-500">Pharmacists</span></p>
                <p class="text-sm font-medium text-gray-400 mt-2">Total Patients: {{ $stats['total_patients'] }}</p>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-securx-gold text-sm font-bold uppercase tracking-wider">Drug Database</h3>
                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Stable</span>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ number_format($stats['total_medications']) }}</p>
                <p class="text-gray-500 text-sm mt-1 font-medium">Registered Medications</p>
                <p class="text-sm font-medium text-gray-400 mt-2">Source: DPRI Verified</p>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-green-500 text-sm font-bold uppercase tracking-wider">Active Network</h3>
                <span class="px-2.5 py-1 bg-securx-gold/20 text-securx-gold text-xs font-bold rounded-full">Live</span>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ number_format($stats['active_prescriptions']) }}</p>
                <p class="text-gray-500 text-sm mt-1 font-medium">Pending Prescriptions</p>
                <p class="text-sm font-medium text-gray-400 mt-2">Awaiting Dispensation</p>
            </div>
        </div>
    </div>
</div>
@endsection