@extends('layouts.patient')

@section('page_title', 'My Prescriptions')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <div class="glass-panel p-6 bg-white/80 flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        <div>
            <h2 class="text-2xl font-extrabold text-securx-navy">Prescription History</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your active prescriptions and view your live QR codes.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative hidden md:block">
                <input type="text" placeholder="Search medications..." class="py-2 pl-10 pr-4 bg-white/50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-securx-cyan outline-none w-64">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        
        <div class="w-full lg:w-5/12 xl:w-1/2 space-y-4 max-h-[700px] overflow-y-auto pr-2 custom-scrollbar">
            @forelse($prescriptions as $prescription)
                <div class="glass-panel bg-white/60 p-6 flex flex-col gap-4 hover:shadow-lg hover:bg-white transition-all border-l-4 {{ $prescription->status === 'active' ? 'border-green-500' : ($prescription->status === 'dispensed' ? 'border-securx-gold' : 'border-gray-400') }}">
                    
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-securx-navy mb-1">
                                {{ $prescription->items->first()->medication->generic_name ?? 'Confidential Medication' }}
                                @if ($prescription->items->count() > 1)
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full ml-2">+{{ $prescription->items->count() - 1 }} more</span>
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500">
                                Prescribed by <span class="font-medium">Dr. {{ $prescription->doctor->last_name }}</span>
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Date: {{ $prescription->created_at->format('M d, Y') }}</p>
                        </div>
                        
                        @if ($prescription->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-500/10 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>Active
                            </span>
                        @elseif($prescription->status === 'dispensed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-securx-gold/10 text-securx-gold">Dispensed</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">{{ ucfirst($prescription->status) }}</span>
                        @endif
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-gray-100 text-sm">
                        <h4 class="font-bold text-gray-700 mb-2">Instructions</h4>
                        <p class="text-gray-600 line-clamp-2">{{ $prescription->items->first()->dosage ?? 'Take as directed by physician.' }}</p>
                    </div>

                    <div class="flex items-center gap-3 mt-2">
                        <button onclick="loadLivePrescription('{{ route('patient.qr-live', $prescription->id) }}')" 
                                class="flex-1 bg-securx-cyan hover:bg-securx-navy text-white py-2.5 rounded-xl text-sm font-bold transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            Show Live QR
                        </button>
                        <a href="#" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-bold transition-colors">
                            Details
                        </a>
                    </div>
                    
                </div>
            @empty
                <div class="glass-panel bg-white/50 border-dashed border-2 border-gray-300 flex flex-col items-center justify-center py-20 px-4 text-center rounded-2xl">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-200">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-securx-navy mb-2">No prescriptions yet</h3>
                    <p class="text-gray-500 max-w-sm text-sm">Your secure digital prescriptions will appear here once your doctor issues them.</p>
                </div>
            @endforelse
            
            @if ($prescriptions->hasPages())
                <div class="mt-6">
                    {{ $prescriptions->links() }}
                </div>
            @endif
        </div>

        <div class="w-full lg:w-7/12 xl:w-1/2">
            <div class="sticky top-6 h-[700px] glass-panel bg-white/80 rounded-2xl overflow-hidden border border-gray-200 shadow-sm relative">
                
                <div id="live-rx-placeholder" class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center bg-slate-50 z-10 transition-opacity duration-300">
                    <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center mb-6 border border-gray-100">
                        <svg class="w-12 h-12 text-securx-cyan/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-securx-navy mb-2">Live Prescription Viewer</h3>
                    <p class="text-gray-500 text-sm max-w-sm">Click "Show Live QR" on any prescription from the list to load the secure dispensing code here.</p>
                </div>

                <iframe id="live-rx-frame" src="" class="w-full h-full border-0 absolute inset-0 z-0 bg-white" title="Live Prescription"></iframe>
            </div>
        </div>
        
    </div>
</div>

@vite(['resources/js/prescriptions.js'])
@endsection