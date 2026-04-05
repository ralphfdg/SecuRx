@extends('layouts.admin')

@section('page_title', 'Global Settings')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden flex justify-between items-center">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1 flex items-center gap-2">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Global Platform Settings
            </h1>
            <p class="text-gray-600 font-medium text-sm">Manage system-wide variables, security thresholds, and network operations.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="glass-panel p-4 bg-green-50/80 border border-green-200 text-green-700 rounded-xl shadow-sm relative">
            <span class="font-bold">Success!</span> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-l-4 border-l-securx-cyan">
            <div class="p-5 border-b border-gray-200/60 bg-gray-50/50">
                <h3 class="text-lg font-bold text-securx-navy">Security & Access Thresholds</h3>
                <p class="text-xs text-gray-500 mt-1">Configure HIPAA/DPA compliance rules for system timeouts and login attempts.</p>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Session Idle Timeout (Minutes)</label>
                    <div class="relative">
                        <input type="number" name="session_timeout" value="{{ $settings['session_timeout'] }}" required min="5" max="120" class="w-full bg-white border border-gray-200 rounded-xl text-gray-800 focus:border-securx-cyan focus:ring-securx-cyan shadow-sm pl-10 p-2.5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Auto-logout users after period of inactivity.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Maximum Failed Login Attempts</label>
                    <div class="relative">
                        <input type="number" name="max_login_attempts" value="{{ $settings['max_login_attempts'] }}" required min="3" max="10" class="w-full bg-white border border-gray-200 rounded-xl text-gray-800 focus:border-securx-cyan focus:ring-securx-cyan shadow-sm pl-10 p-2.5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Locks account temporarily after threshold is reached.</p>
                </div>
            </div>
        </div>

        <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-l-4 border-l-securx-gold">
            <div class="p-5 border-b border-gray-200/60 bg-gray-50/50">
                <h3 class="text-lg font-bold text-securx-navy">Clinical Network Operations</h3>
                <p class="text-xs text-gray-500 mt-1">Manage global variables governing prescription generation and scanning.</p>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Default Prescription QR Validity (Days)</label>
                    <div class="relative">
                        <input type="number" name="prescription_validity" value="{{ $settings['prescription_validity'] }}" required min="1" max="365" class="w-full bg-white border border-gray-200 rounded-xl text-gray-800 focus:border-securx-gold focus:ring-securx-gold shadow-sm pl-10 p-2.5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Number of days before a non-maintenance prescription expires.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">System Maintenance Mode</label>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="maintenance_mode" value="0">
                        <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer" {{ $settings['maintenance_mode'] ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500"></div>
                        <span class="ml-3 text-sm font-bold text-gray-600 peer-checked:text-red-600">Restrict network to Admins only</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="py-3 px-8 bg-securx-navy hover:bg-gray-800 text-white font-bold rounded-xl shadow-md transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Apply System Updates
            </button>
        </div>

    </form>
</div>
@endsection