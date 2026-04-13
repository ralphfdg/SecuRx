@extends('layouts.patient')

@section('page_title', 'Live Prescription')

@section('content')
<div class="main-container max-w-3xl mx-auto space-y-6 pb-12 print:pb-0 print:space-y-0">
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

    <div class="w-full flex justify-center">
        <div id="prescription-paper" class="bg-white w-full max-w-[600px] shadow-[0_10px_40px_rgba(0,0,0,0.12)] border border-gray-200 aspect-[1/1.414] relative overflow-hidden flex flex-col">
            
            <div class="h-3 w-full bg-[#2B3B82] shrink-0"></div>

            <div class="p-8 flex-1 flex flex-col relative z-10">
                
                <div class="text-center mb-6">
                    <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx" class="h-12 mx-auto object-contain">
                </div>

                <div class="border-t border-gray-800 pt-4 pb-4 mb-6">
                    <div class="grid grid-cols-5 gap-4 text-xs font-serif text-gray-800">
                        <div class="col-span-2">
                            <p class="font-bold text-gray-500 uppercase text-[10px] mb-1">Name:</p>
                            <p class="font-bold text-sm border-b border-gray-400 border-dotted h-6">
                                {{ $prescription->print_patient_name ? $prescription->patient->name : '' }}
                            </p>
                        </div>
                        <div class="col-span-1">
                            <p class="font-bold text-gray-500 uppercase text-[10px] mb-1">Age/Sex:</p>
                            <p class="font-bold text-sm border-b border-gray-400 border-dotted h-6 text-center">
                                {{ $prescription->print_patient_name ? \Carbon\Carbon::parse($prescription->patient->dob)->age . '/' . substr($prescription->patient->gender, 0, 1) : '' }}
                            </p>
                        </div>
                        <div class="col-span-2">
                            <p class="font-bold text-gray-500 uppercase text-[10px] mb-1">Date:</p>
                            <p class="font-bold text-sm border-b border-gray-400 border-dotted h-6">
                                {{ $prescription->created_at->format('m/d/Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <span class="text-5xl font-serif font-black text-[#0f172a] italic tracking-tighter pr-2">Rx</span>
                </div>

                <div class="flex-1 space-y-6 font-serif overflow-y-auto print:overflow-hidden custom-scrollbar flex flex-col">
                    @foreach($prescription->items as $index => $item)
                        <div class="relative group">
                            <div class="flex justify-between items-start">
                                <p class="text-lg font-bold text-[#0f172a]">
                                    {{ $index + 1 }}. {{ $item->medication->brand_name ?? $item->medication->generic_name }} {{ $item->dose }}
                                </p>
                                <p class="text-base font-bold text-[#0f172a] whitespace-nowrap ml-4">
                                    #{{ $item->quantity }} {{ Str::plural($item->medication->form ?? 'tabs', $item->quantity) }}
                                </p>
                            </div>
                            <div class="mt-1">
                                <p class="text-sm text-gray-700 italic">
                                    Sig: @if($item->frequency && $item->duration) Take {{ $item->frequency }} for {{ $item->duration }}. @else {{ $item->sig }} @endif
                                </p>
                                
                                <div class="mt-1 space-y-0.5">
                                    @if($item->pharmacist_instructions)
                                        <p class="text-[13px] text-gray-500 italic pl-3 border-l-2 border-gray-300">
                                            To Rx: {{ $item->pharmacist_instructions }}
                                        </p>
                                    @endif
                                    @if($item->patient_instructions)
                                        <p class="text-[13px] text-blue-500 italic pl-3 border-l-2 border-blue-200">
                                            To Pt: {{ $item->patient_instructions }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-end shrink-0">
                    
                    <div class="w-24 h-24 bg-gray-50 border border-gray-200 flex flex-col items-center justify-center shrink-0 p-2">
                        @if($prescription->status === 'active' || $prescription->status === 'dispensed')
                            {!! QrCode::size(70)->generate($prescription->id) !!}
                        @else
                            <div class="text-[8px] text-gray-400 font-bold uppercase tracking-widest text-center mt-1">
                                <svg class="w-8 h-8 mx-auto mb-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                QR PENDING
                            </div>
                        @endif
                    </div>

                    <div class="font-serif text-sm">
                        <div class="flex items-end justify-end gap-1 mb-2">
                            <span class="font-bold text-[#2B3B82] uppercase border-b border-gray-400 min-w-[200px] text-center px-2 pb-0.5 tracking-wide">
                                {{ $prescription->doctor->first_name }} {{ $prescription->doctor->last_name }}
                            </span>
                            <span class="text-gray-500 font-bold text-xs pb-0.5">, MD</span>
                        </div>
                        <div class="flex flex-col items-end gap-1">
                            <div class="flex items-end justify-end gap-2 w-full">
                                <span class="text-gray-500 text-xs font-bold">Lic.</span>
                                <span class="font-bold text-[#2B3B82] border-b border-gray-400 w-[180px] text-center pb-0.5">
                                    {{ $prescription->doctor->doctorProfile?->prc_number ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="flex items-end justify-end gap-2 w-full">
                                <span class="text-gray-500 text-xs font-bold">PTR</span>
                                <span class="font-bold text-[#2B3B82] border-b border-gray-400 w-[180px] text-center pb-0.5">
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