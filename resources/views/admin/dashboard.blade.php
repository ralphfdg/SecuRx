@extends('layouts.admin')

@section('page_title', 'Command Center')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <div class="glass-panel p-8 bg-white/80 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="absolute top-0 right-0 w-64 h-64 bg-securx-gold/10 rounded-bl-full pointer-events-none -z-10"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold text-securx-navy mb-2">Admin Command Center</h1>
            <p class="text-gray-600 font-medium">Manage users, oversee network activity, and update the drug database.</p>
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
            <h3 class="text-securx-cyan text-sm font-bold uppercase tracking-wider mb-2">System Users</h3>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ $stats['total_doctors'] }} <span class="text-sm font-medium text-gray-500">Doctors</span></p>
                <p class="text-2xl font-bold text-gray-600 mt-1">{{ $stats['total_pharmacists'] }} <span class="text-sm font-medium text-gray-500">Pharmacists</span></p>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between">
            <h3 class="text-securx-gold text-sm font-bold uppercase tracking-wider mb-2">Drug Database</h3>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ $stats['total_medications'] }}</p>
                <p class="text-gray-500 text-sm mt-1 font-medium">Registered Medications</p>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between">
            <h3 class="text-green-500 text-sm font-bold uppercase tracking-wider mb-2">Active Network</h3>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ $stats['active_prescriptions'] }}</p>
                <p class="text-gray-500 text-sm mt-1 font-medium">Pending Prescriptions</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="glass-panel p-6 bg-white/80 flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-securx-navy mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Dataset Import Engine
                </h3>
                <p class="text-sm text-gray-500 mb-4">Upload the latest DOH DPRI pricing and interaction datasets. This will automatically replace and update the medication inventory via CSV.</p>
            </div>
            
            <form action="{{ route('admin.dataset.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="dataset-upload-form">
                @csrf
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-securx-cyan border-dashed rounded-xl cursor-pointer bg-securx-cyan/5 hover:bg-securx-cyan/10 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-securx-cyan" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">CSV files only (Max 10MB)</p>
                        </div>
                        <input id="dropzone-file" type="file" name="dataset" class="hidden" accept=".csv" required />
                    </label>
                </div>
                <p id="file-name-display" class="text-xs font-bold text-center text-securx-navy hidden"></p>

                <button type="submit" class="w-full py-3 px-4 bg-securx-cyan hover:bg-securx-navy text-white font-bold rounded-xl shadow-md transition-colors flex justify-center items-center gap-2">
                    Initialize Import Pipeline
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <a href="#" class="glass-panel p-6 bg-white/60 hover:bg-white hover:shadow-md transition group flex flex-col items-center text-center justify-center gap-3">
                <div class="p-3 bg-securx-cyan/10 text-securx-cyan rounded-full group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-securx-navy">User Management</h4>
                    <p class="text-xs text-gray-500 mt-1">Verify or reject medical staff registrations.</p>
                </div>
            </a>

            <a href="#" class="glass-panel p-6 bg-white/60 hover:bg-white hover:shadow-md transition group flex flex-col items-center text-center justify-center gap-3">
                <div class="p-3 bg-securx-navy/10 text-securx-navy rounded-full group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-securx-navy">Immutable Audit Logs</h4>
                    <p class="text-xs text-gray-500 mt-1">Read-only ledger tracking all system events.</p>
                </div>
            </a>

            <a href="#" class="glass-panel p-6 bg-white/60 hover:bg-white hover:shadow-md transition group flex flex-col items-center text-center justify-center gap-3">
                <div class="p-3 bg-securx-gold/10 text-securx-gold rounded-full group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-securx-navy">System Backup</h4>
                    <p class="text-xs text-gray-500 mt-1">Download secure .csv or .sql backups.</p>
                </div>
            </a>

            <a href="#" class="glass-panel p-6 bg-white/60 hover:bg-white hover:shadow-md transition group flex flex-col items-center text-center justify-center gap-3">
                <div class="p-3 bg-gray-500/10 text-gray-600 rounded-full group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-securx-navy">Global Settings</h4>
                    <p class="text-xs text-gray-500 mt-1">System-wide variable controls.</p>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection