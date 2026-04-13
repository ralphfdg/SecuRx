@extends('layouts.patient')

@section('page_title', 'Live Prescription')

@section('content')
<style>
    @media print {
        @page {
            size: portrait;
            margin: 0.5cm; /* Prevents overflow to a second page */
        }
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            background-color: white !important;
        }
        /* Ensures nothing else forces a page break */
        nav, aside, footer { display: none !important; }
    }
</style>

<div class="max-w-3xl mx-auto space-y-6 pb-12">
    <!-- Header / Navigation -->
    <div class="flex items-center justify-between print:hidden">
        <a href="{{ route('patient.prescriptions') }}" class="text-securx-cyan hover:text-securx-navy font-bold text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Prescriptions
        </a>
        
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="text-xs font-bold text-white bg-securx-cyan hover:bg-cyan-500 px-4 py-1.5 rounded-full flex items-center gap-2 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download PDF
            </button>
            <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider
                {{ $prescription->status === 'active' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                {{ $prescription->status }}
            </span>
        </div>
    </div>

    <!-- The Prescription Canvas -->
    <div class="bg-white shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 aspect-[1/1.414] relative flex flex-col w-full max-w-lg mx-auto rounded-sm overflow-hidden print:shadow-none print:border-none print:max-w-2xl print:aspect-auto print:h-auto print:overflow-visible print:pb-8">

        <div class="h-2 w-full bg-securx-navy shrink-0 print:hidden"></div>

        <div class="p-6 md:p-8 flex-1 flex flex-col relative z-10">

            <div class="text-center border-b-2 border-gray-800 pb-4 mb-4 flex flex-col items-center">
                <div class="flex items-center justify-center gap-2">
                    <a class="relative inline-block group pt-2 pb-1">
                        <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                            class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>
            </div>

            <div
                class="grid grid-cols-4 gap-2 text-xs font-serif text-gray-800 mb-4 border-b border-gray-300 pb-3">
                <div class="col-span-2">
                    <p class="text-[9px] font-bold text-gray-500 uppercase">Name:</p>
                    <p class="font-bold border-b border-gray-300 border-dotted {{ !$prescription->print_patient_name ? 'text-gray-400 italic' : 'text-gray-900' }}">
                        {{ $prescription->print_patient_name ? $prescription->patient->name : 'Confidential' }}
                    </p>
                </div>
                <div class="col-span-1">
                    <p class="text-[9px] font-bold text-gray-500 uppercase">Age/Sex:</p>
                    <p class="font-bold border-b border-gray-300 border-dotted {{ !$prescription->print_patient_name ? 'text-gray-400 italic' : 'text-gray-900' }}">
                        {{ $prescription->print_patient_name ? \Carbon\Carbon::parse($prescription->patient->dob)->age . '/' . substr($prescription->patient->gender, 0, 1) : '__________' }}
                    </p>
                </div>
                <div class="col-span-1">
                    <p class="text-[9px] font-bold text-gray-500 uppercase">Date:</p>
                    <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">
                        {{ $prescription->created_at->format('m/d/Y') }}
                    </p>
                </div>
            </div>

            <div class="mb-3">
                <span class="text-5xl font-serif font-black text-gray-900 italic tracking-tighter">Rx</span>
            </div>

        <div class="flex-1 space-y-5 pl-2 font-serif overflow-y-auto print:overflow-visible custom-scrollbar pr-2 flex flex-col">
                @foreach($prescription->items as $index => $item)
                    <div class="relative group">
                        <p class="text-base font-bold text-gray-900">
                            {{ $index + 1 }}. {{ $item->medication->brand_name ?? $item->medication->generic_name }} {{ $item->dose }}
                        </p>
                        <div class="flex justify-between items-end mt-0.5">
                            <p class="text-sm text-gray-700 italic">
                                Sig: @if($item->frequency && $item->duration) Take {{ $item->frequency }} for {{ $item->duration }}. @else {{ $item->sig }} @endif
                            </p>
                            <p class="text-sm font-bold text-gray-900">#{{ $item->quantity }} {{ Str::plural($item->medication->form ?? 'unit', $item->quantity) }}</p>
                        </div>
                        @if($item->pharmacist_instructions)
                            <p class="text-xs text-gray-500 italic mt-0.5 border-l border-gray-300 pl-2 ml-1">
                                To Rx: {{ $item->pharmacist_instructions }}
                            </p>
                        @endif
                        @if($item->patient_instructions)
                            <p class="text-xs text-blue-600 italic mt-0.5 border-l border-blue-200 pl-2 ml-1">
                                To Pt: {{ $item->patient_instructions }}
                            </p>
                        @endif
                    </div>
                @endforeach

            <div class="flex-1 print:min-h-[2rem]"></div>

                @if($prescription->general_instructions || $prescription->encounter?->next_appointment_date)
                    <div class="pt-3 border-t border-gray-200 border-dashed">
                        @if($prescription->general_instructions)
                            <div class="mb-2">
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Additional Instructions:</p>
                                <p class="text-xs font-serif text-gray-800 mt-0.5 italic">
                                    {{ $prescription->general_instructions }}
                                </p>
                            </div>
                        @endif
                        @if($prescription->encounter?->next_appointment_date)
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Next Appointment:</p>
                                <p class="text-xs font-serif text-gray-900 mt-0.5 font-bold">
                                    {{ \Carbon\Carbon::parse($prescription->encounter->next_appointment_date)->format('m/d/Y') }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 shrink-0">
                <div class="flex justify-between items-end">
                    
                    <div class="text-center flex flex-col items-center shrink-0 border border-gray-200 bg-gray-50 p-2 rounded-lg">
                        {!! QrCode::size(80)->style('round')->generate($prescription->id) !!}
                        <span class="text-[8px] text-gray-400 mt-1.5 font-sans font-bold tracking-wider uppercase">Scan to Verify</span>
                    </div>

                <div class="text-left w-[240px] ml-auto flex flex-col font-serif">
                    <div class="relative z-0 space-y-2 text-xs">
                        <div class="text-center border-b border-gray-800 pb-1">
                            <span class="font-sans font-bold text-blue-800 uppercase opacity-90 text-sm">
                                {{ $prescription->doctor->first_name }} {{ $prescription->doctor->last_name }}, MD
                            </span>
                        </div>

                        <div class="flex items-end">
                            <span class="text-gray-500 font-bold mr-2 uppercase tracking-wide">Lic:</span>
                            <span class="flex-1 border-b border-gray-400 font-sans font-bold text-blue-800 opacity-90 text-center pb-0.5">
                                {{ $prescription->doctor->doctorProfile?->prc_number ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="flex items-end">
                            <span class="text-gray-500 font-bold mr-2 uppercase tracking-wide">PTR:</span>
                            <span class="flex-1 border-b border-gray-400 font-sans font-bold text-blue-800 opacity-90 text-center pb-0.5">
                                {{ $prescription->doctor->doctorProfile?->ptr_number ?? 'N/A' }}
                            </span>
                        </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
