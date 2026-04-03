@extends('layouts.patient')

@section('page_title', 'My Prescriptions')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        <div class="glass-panel p-6 bg-white/80 flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Prescription History</h2>
                <p class="text-sm text-gray-500 mt-1">Select a prescription from the list below to generate its secure QR
                    code.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Search medications..."
                        class="py-2 pl-10 pr-4 bg-white/50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-securx-cyan outline-none w-64">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="space-y-3">

            @forelse($prescriptions as $prescription)
                <div onclick="window.location='{{ route('patient.qr-live', ['id' => $prescription->id]) }}'"
                    class="glass-panel bg-white/60 p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:shadow-lg hover:bg-white transition-all cursor-pointer border-l-4 {{ $prescription->status === 'active' ? 'border-green-500' : ($prescription->status === 'dispensed' ? 'border-securx-gold' : 'border-gray-400') }} group">

                    <div class="flex items-center gap-5">
                        <div
                            class="w-12 h-12 rounded-full hidden sm:flex items-center justify-center shrink-0 {{ $prescription->status === 'active' ? 'bg-green-50 text-green-500' : 'bg-gray-100 text-gray-400' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                </path>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-securx-navy group-hover:text-securx-cyan transition-colors">
                                {{ $prescription->items->first()->medication->generic_name ?? 'Confidential Medication' }}
                                @if ($prescription->items->count() > 1)
                                    <span
                                        class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full ml-2">+{{ $prescription->items->count() - 1 }}
                                        more</span>
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Prescribed by <span class="font-medium">Dr. {{ $prescription->doctor->last_name }}</span>
                                &bull; {{ $prescription->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between md:justify-end gap-6 w-full md:w-auto mt-2 md:mt-0 pt-3 md:pt-0 border-t border-gray-100 md:border-0">

                        @if ($prescription->status === 'active')
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-500/10 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>Active
                            </span>
                        @elseif($prescription->status === 'dispensed')
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-securx-gold/10 text-securx-gold">Dispensed</span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">{{ ucfirst($prescription->status) }}</span>
                        @endif

                        <div
                            class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-securx-cyan group-hover:text-white text-gray-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

            @empty
                <div
                    class="glass-panel bg-white/50 border-dashed border-2 border-gray-300 flex flex-col items-center justify-center py-20 px-4 text-center rounded-2xl">
                    <div
                        class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-200">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-securx-navy mb-2">No prescriptions yet</h3>
                    <p class="text-gray-500 max-w-sm text-sm">Your secure digital prescriptions will appear here once your
                        doctor issues them.</p>
                </div>
            @endforelse

        </div>

        @if ($prescriptions->hasPages())
            <div class="mt-6">
                {{ $prescriptions->links() }}
            </div>
        @endif

    </div>
@endsection
