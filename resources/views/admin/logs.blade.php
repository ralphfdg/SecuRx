@extends('layouts.admin')

@section('page_title', 'Immutable Audit Logs')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden flex justify-between items-center">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1 flex items-center gap-2">
                <svg class="w-6 h-6 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Immutable Audit Logs
            </h1>
            <p class="text-gray-600 font-medium text-sm">A secure, read-only ledger tracking all critical system events and user actions.</p>
        </div>
        <div class="hidden md:block">
            <span class="px-4 py-2 bg-securx-navy/10 text-securx-navy font-bold text-xs rounded-full border border-securx-navy/20">
                <span class="w-2 h-2 inline-block bg-green-500 rounded-full mr-2 animate-pulse"></span>
                Logging Active
            </span>
        </div>
    </div>

    <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-t-4 border-t-securx-navy shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/90 backdrop-blur-sm">
                    <tr class="text-xs text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-bold border-b border-gray-200/60 w-48">Timestamp</th>
                        <th class="p-4 font-bold border-b border-gray-200/60 w-32">Action</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">Details</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">IP Address</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                    @forelse($logs as $log)
                    <tr class="hover:bg-white/60 transition group">
                        <td class="p-4 font-medium text-gray-500 whitespace-nowrap">
                            {{ $log->created_at->format('M d, Y') }}<br>
                            <span class="text-xs">{{ $log->created_at->format('h:i:s A') }}</span>
                        </td>
                        <td class="p-4">
                            @php
                                // Use 'action_type' based on the AuditLog Model!
                                $actionLower = strtolower($log->action_type ?? '');
                                $badgeColor = 'bg-gray-100 text-gray-700';
                                
                                if(str_contains($actionLower, 'login') || str_contains($actionLower, 'approve') || str_contains($actionLower, 'import')) {
                                    $badgeColor = 'bg-green-100 text-green-700';
                                } elseif (str_contains($actionLower, 'delete') || str_contains($actionLower, 'reject') || str_contains($actionLower, 'failed')) {
                                    $badgeColor = 'bg-red-100 text-red-700';
                                } elseif (str_contains($actionLower, 'update') || str_contains($actionLower, 'edit') || str_contains($actionLower, 'export')) {
                                    $badgeColor = 'bg-securx-cyan/20 text-securx-navy';
                                }
                            @endphp
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold capitalize {{ $badgeColor }}">
                                {{ $log->action_type ?? 'System Event' }}
                            </span>
                        </td>
                        <td class="p-4 text-securx-navy font-medium">
                            {{ $log->description ?? 'No details provided.' }}
                            @if($log->user_id)
                                <span class="block text-xs text-gray-400 mt-1">Initiated by User ID: {{ $log->user_id }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-xs font-mono text-gray-400">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10">
                            <div class="flex flex-col items-center justify-center text-center text-gray-400 font-medium">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                The ledger is currently empty. System events will appear here automatically.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="p-4 border-t border-gray-200/60 bg-white/50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection