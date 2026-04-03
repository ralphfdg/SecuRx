@extends('layouts.patient')

@section('page_title', 'Live QR Code')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="mb-6">
            <a href="{{ route('patient.prescriptions') }}"
                class="text-sm font-bold text-gray-500 hover:text-securx-cyan flex items-center gap-2 transition w-max px-3 py-1.5 rounded-lg hover:bg-white/50">
                &larr; Back to Prescriptions
            </a>
        </div>

        <div class="glass-panel p-8 md:p-12 bg-white/80 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-securx-cyan/10 rounded-bl-full -z-10"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-securx-gold/10 rounded-tr-full -z-10"></div>

            <h2 class="text-2xl md:text-3xl font-extrabold text-securx-navy mb-2">Your Secure Digital Prescription</h2>
            <p class="text-gray-500 text-sm mb-10 max-w-lg mx-auto">Present this QR code to any partnered or guest
                pharmacist. It contains a cryptographic signature verifying its authenticity.</p>

            <div
                class="inline-flex flex-col items-center justify-center p-6 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100 mb-10 relative group">

                @if ($prescription->status === 'active')
                    <div
                        class="absolute -top-3 -right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md flex items-center gap-1.5 border-2 border-white z-20">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Active
                    </div>
                @else
                    <div
                        class="absolute -top-3 -right-3 bg-securx-gold text-white text-xs font-bold px-3 py-1 rounded-full shadow-md flex items-center gap-1.5 border-2 border-white z-20">
                        {{ ucfirst($prescription->status) }}
                    </div>
                @endif

                <div
                    class="p-4 bg-white rounded-xl {{ $prescription->status !== 'active' ? 'opacity-20 blur-[2px]' : '' }} transition-all">
                    {!! QrCode::size(250)->margin(1)->style('round')->generate($prescription->id) !!}
                </div>

                @if ($prescription->status !== 'active')
                    <div class="absolute inset-0 flex items-center justify-center z-10">
                        <div
                            class="bg-slate-800 text-white px-5 py-3 rounded-xl font-bold shadow-2xl flex items-center gap-2 border border-slate-700">
                            <svg class="w-5 h-5 text-securx-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Locked ({{ ucfirst($prescription->status) }})
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-slate-50/50 border border-gray-100 rounded-2xl p-6 text-left max-w-lg mx-auto shadow-sm">
                <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-200">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Prescribed By</p>
                        <p class="font-bold text-securx-navy">Dr. {{ $prescription->doctor->last_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Date Issued</p>
                        <p class="font-medium text-gray-700">{{ $prescription->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <ul class="space-y-3">
                    @foreach ($prescription->items as $item)
                        <li class="flex items-center justify-between text-sm">
                            <span class="font-bold text-gray-700 flex items-center gap-2">
                                <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $item->medication->generic_name ?? 'Medication' }}
                            </span>
                            <span class="text-gray-500 font-bold bg-white px-2 py-1 rounded border border-gray-100">Qty:
                                {{ $item->quantity }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection
