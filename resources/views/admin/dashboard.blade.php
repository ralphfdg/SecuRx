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

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between border-l-4 border-l-securx-cyan">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-securx-cyan text-sm font-bold uppercase tracking-wider">Doctors</h3>
                <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Active</span>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ $stats['total_doctors'] }}</p>
                <p class="text-sm font-medium text-gray-500 mt-2">Verified Practitioners</p>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between border-l-4 border-l-securx-gold">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-securx-gold text-sm font-bold uppercase tracking-wider">Pharmacists</h3>
                <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Active</span>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ $stats['total_pharmacists'] }}</p>
                <p class="text-sm font-medium text-gray-500 mt-2">Verified Dispensers</p>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between border-l-4 border-l-purple-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-purple-500 text-sm font-bold uppercase tracking-wider">Patients</h3>
                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Onboarded</span>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ $stats['total_patients'] }}</p>
                <p class="text-sm font-medium text-gray-500 mt-2">Registered Users</p>
            </div>
        </div>

        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between border-l-4 border-l-green-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-green-500 text-sm font-bold uppercase tracking-wider">Prescriptions</h3>
                <span class="px-2.5 py-1 bg-securx-gold/20 text-securx-gold text-xs font-bold rounded-full">Pending</span>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-securx-navy">{{ number_format($stats['active_prescriptions']) }}</p>
                <p class="text-sm font-medium text-gray-500 mt-2">Awaiting Dispensation</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 border-b border-gray-200/60 pb-3">
                    <h3 class="text-gray-700 text-sm font-bold uppercase tracking-wider">Clinical Drug Database</h3>
                    <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">DPRI Verified</span>
                </div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-full bg-securx-cyan/10 flex items-center justify-center text-securx-cyan shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-securx-navy">{{ number_format($stats['total_medications']) }}</p>
                        <p class="text-gray-500 text-xs font-medium">Registered generic medications.</p>
                    </div>
                </div>
                
                <div class="space-y-2 mb-4">
                    @forelse($recentMedications as $med)
                    <div class="flex justify-between items-center bg-gray-50 p-2 rounded-lg border border-gray-100">
                        <span class="text-xs font-bold text-securx-navy">{{ $med->generic_name }} <span class="text-gray-400 font-normal">({{ $med->form }})</span></span>
                        <span class="text-xs font-bold text-securx-cyan">₱{{ number_format($med->estimated_price, 2) }}</span>
                    </div>
                    @empty
                    <p class="text-xs text-gray-500 text-center py-2">No medications found.</p>
                    @endforelse
                </div>
            </div>
            
            <a href="{{ route('admin.dataset') }}" class="w-full block text-center py-2 px-4 bg-securx-cyan/10 hover:bg-securx-cyan text-securx-cyan hover:text-white text-sm font-bold rounded-xl transition-colors">
                Manage Dataset
            </a>
        </div>

        <div class="glass-panel p-6 bg-white/60 hover:bg-white transition flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 border-b border-gray-200/60 pb-3">
                    <h3 class="text-gray-700 text-sm font-bold uppercase tracking-wider">Recent System Events</h3>
                    <span class="px-2.5 py-1 bg-securx-navy/10 text-securx-navy text-xs font-bold rounded-full">
                        <span class="w-1.5 h-1.5 inline-block bg-green-500 rounded-full mr-1 animate-pulse"></span>Live Ledger
                    </span>
                </div>
                
                <div class="space-y-3 mb-4">
                    @forelse($recentLogs as $log)
                    <div class="flex items-start gap-3 border-b border-gray-100 pb-2 last:border-0 last:pb-0">
                        @php
                            $actionLower = strtolower($log->action_type ?? '');
                            $badgeColor = 'bg-gray-100 text-gray-700'; // default
                            
                            if(str_contains($actionLower, 'login') || str_contains($actionLower, 'approve') || str_contains($actionLower, 'import')) {
                                $badgeColor = 'bg-green-100 text-green-700';
                            } elseif (str_contains($actionLower, 'delete') || str_contains($actionLower, 'reject') || str_contains($actionLower, 'failed')) {
                                $badgeColor = 'bg-red-100 text-red-700';
                            } elseif (str_contains($actionLower, 'update') || str_contains($actionLower, 'edit') || str_contains($actionLower, 'export')) {
                                $badgeColor = 'bg-securx-cyan/20 text-securx-navy';
                            }
                        @endphp
                        <div class="mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider shrink-0 {{ $badgeColor }}">
                            {{ $log->action_type ?? 'Event' }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-securx-navy font-medium truncate" title="{{ $log->description }}">{{ $log->description }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-500 text-center py-4">No recent system events.</p>
                    @endforelse
                </div>
            </div>
            
            <a href="{{ route('admin.logs') }}" class="w-full block text-center py-2 px-4 bg-securx-navy/10 hover:bg-securx-navy text-securx-navy hover:text-white text-sm font-bold rounded-xl transition-colors mt-auto">
                View Full Audit Ledger
            </a>
        </div>
        
    </div>
</div>
@endsection