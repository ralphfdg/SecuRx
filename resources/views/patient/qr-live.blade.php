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

    <div class="w-full max-w-[600px] mx-auto print:hidden">
        <button id="pharmacyModeBtn" onclick="togglePharmacyMode()" class="w-full flex items-center justify-center gap-2 bg-[#2B3B82] text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:bg-blue-800 transition-all duration-300 ring-2 ring-transparent ring-offset-2 active:ring-blue-500 select-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
            </svg>
            Ready to Scan (Pharmacy Mode)
        </button>
    </div>

    <div class="w-full flex justify-center">
        <div id="prescription-paper" class="bg-white w-full max-w-[600px] shadow-[0_10px_40px_rgba(0,0,0,0.12)] border border-gray-200 aspect-[1/1.414] relative overflow-hidden flex flex-col text-gray-900">
            
            <div class="h-2 sm:h-3 w-full bg-[#2B3B82] shrink-0"></div>

            <div class="p-5 sm:p-6 flex-1 flex flex-col relative z-10 min-h-0">
                
                <div class="w-full flex justify-center mb-4 shrink-0">
                    <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx" class="h-4 sm:h-5 w-auto object-contain">
                </div>

                <div class="flex flex-row items-center gap-3 sm:gap-4 border-b-2 border-gray-800 pb-3 mb-4 shrink-0">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white border border-gray-200 rounded-lg flex flex-col items-center justify-center shrink-0 overflow-hidden shadow-sm">
                        @if (!empty($prescription->doctor->doctorProfile?->clinic->clinic_logo))
                            <img src="{{ asset('storage/' . $prescription->doctor->doctorProfile->clinic->clinic_logo) }}"
                                alt="Clinic Logo" class="w-full h-full object-contain p-1">
                        @else
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-800 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        @endif
                    </div>

                    <div class="flex-1 flex flex-col min-w-0">
                        <h1 class="text-[13px] sm:text-lg font-serif font-black text-gray-900 tracking-wide uppercase mb-0.5 leading-tight text-center">
                            {{ $prescription->doctor->doctorProfile?->clinic->clinic_name ?? 'MEDICAL CLINIC INC.' }}
                        </h1>
                        
                        <div class="flex flex-row justify-between items-start gap-2 w-full mt-0.5">
                            <p class="text-[9px] sm:text-[11px] font-serif text-gray-600 leading-snug flex-1 text-left">
                                {{ $prescription->doctor->doctorProfile?->clinic->clinic_address ?? '123 Health Avenue, Medical District, City' }}
                            </p>
                            <p class="text-[9px] sm:text-[11px] font-serif text-gray-800 font-bold shrink-0 text-right whitespace-nowrap mt-0.5">
                                Tel: {{ $prescription->doctor->doctorProfile?->clinic->contact_number ?? '(000) 123-4567' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-5 sm:grid-cols-4 gap-2 text-[10px] sm:text-xs font-serif text-gray-800 mb-4 border-b border-gray-300 pb-3 shrink-0">
                    <div class="col-span-2">
                        <p class="text-[8px] sm:text-[9px] font-bold text-gray-500 uppercase">Name:</p>
                        <p class="font-bold border-b border-gray-300 border-dotted truncate text-gray-900 h-5 sm:h-6 flex items-end"
                           @if(!$prescription->print_patient_name) class="text-gray-400 italic" @endif>
                            {{ $prescription->print_patient_name ? $prescription->patient->name : '____________________' }}
                        </p>
                    </div>
                    <div class="col-span-1">
                        <p class="text-[8px] sm:text-[9px] font-bold text-gray-500 uppercase">Age/Sex:</p>
                        <p class="font-bold border-b border-gray-300 border-dotted text-gray-900 text-center h-5 sm:h-6 flex justify-center items-end"
                           @if(!$prescription->print_patient_name) class="text-gray-400 italic" @endif>
                            {{ $prescription->print_patient_name ? \Carbon\Carbon::parse($prescription->patient->dob)->age . '/' . strtoupper(substr($prescription->patient->gender ?? 'U', 0, 1)) : '__________' }}
                        </p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-[8px] sm:text-[9px] font-bold text-gray-500 uppercase">Date:</p>
                        <p class="font-bold border-b border-gray-300 border-dotted text-gray-900 text-center sm:text-right h-5 sm:h-6 flex justify-center sm:justify-end items-end">
                            {{ $prescription->created_at->format('m/d/Y') }}
                        </p>
                    </div>
                </div>

                <div class="mb-3 shrink-0">
                    <span class="text-4xl sm:text-5xl font-serif font-black text-gray-900 italic tracking-tighter pr-2">Rx</span>
                </div>

                <div class="flex-1 space-y-5 font-serif overflow-y-auto print:overflow-hidden custom-scrollbar flex flex-col pr-1 min-h-0">
                    @foreach($prescription->items as $index => $item)
                        <div class="relative group">
                            <div class="flex justify-between items-start">
                                <p class="text-[14px] sm:text-[16px] font-bold text-gray-900">
                                    {{ $index + 1 }}. {{ $item->medication->brand_name ?? $item->medication->generic_name }} {{ $item->dose }}
                                </p>
                                <div class="text-right ml-4">
                                    <p class="text-[13px] sm:text-sm font-bold text-gray-900 whitespace-nowrap">
                                        #{{ $item->quantity }} {{ Str::plural($item->medication->form ?? 'tabs', $item->quantity) }}
                                    </p>
                                    
                                    @if($item->medication && $item->medication->latestDpriRecord && $item->medication->latestDpriRecord->median_price)
                                        <div class="mt-0.5 flex justify-end items-center gap-1.5 cursor-pointer group print:hidden" 
                                             onclick="let priceText = document.getElementById('dpri-price-{{ $index }}'); 
                                                      let iconOpen = document.getElementById('eye-open-{{ $index }}');
                                                      let iconClosed = document.getElementById('eye-closed-{{ $index }}');
                                                      if(priceText.classList.contains('blur-[4px]')) {
                                                          priceText.classList.remove('blur-[4px]', 'select-none');
                                                          iconClosed.classList.add('hidden');
                                                          iconOpen.classList.remove('hidden');
                                                      } else {
                                                          priceText.classList.add('blur-[4px]', 'select-none');
                                                          iconOpen.classList.add('hidden');
                                                          iconClosed.classList.remove('hidden');
                                                      }">
                                            
                                            <svg id="eye-closed-{{ $index }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-gray-400 group-hover:text-green-600 transition-colors">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>

                                            <svg id="eye-open-{{ $index }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-green-600 hidden transition-colors">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>

                                            <p id="dpri-price-{{ $index }}" class="sensitive-doh-price text-[10px] sm:text-[11px] text-green-700 font-sans font-semibold tracking-wide blur-[4px] select-none transition-all duration-300 ease-in-out">
                                                DOH Est. Price: ₱{{ number_format($item->medication->latestDpriRecord->median_price, 2) }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-0.5">
                                <p class="text-[12px] sm:text-sm text-gray-700 italic">
                                    Sig: @if($item->frequency && $item->duration) Take {{ $item->frequency }} for {{ $item->duration }}. @else {{ $item->sig }} @endif
                                </p>
                                
                                <div class="mt-1 space-y-0.5">
                                    @if($item->pharmacist_instructions)
                                        <p class="text-[11px] sm:text-[12px] text-gray-500 italic pl-2 border-l border-gray-300 ml-1">
                                            To Rx: {{ $item->pharmacist_instructions }}
                                        </p>
                                    @endif
                                    @if($item->patient_instructions)
                                        <p class="text-[11px] sm:text-[12px] text-blue-600 italic pl-2 border-l border-blue-200 ml-1 print:border-gray-300 print:text-gray-600">
                                            To Pt: {{ $item->patient_instructions }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 shrink-0">
                    
                    @if($prescription->general_instructions || $prescription->next_appointment)
                    <div class="mb-4 text-[11px] sm:text-xs text-gray-700 italic border-l-2 border-gray-300 pl-3">
                        @if($prescription->general_instructions)
                            <p class="mb-1"><span class="font-bold text-gray-900 not-italic">Notes:</span> {{ $prescription->general_instructions }}</p>
                        @endif
                        @if($prescription->next_appointment)
                            <p><span class="font-bold text-gray-900 not-italic">Next Visit:</span> {{ \Carbon\Carbon::parse($prescription->next_appointment)->format('F d, Y') }}</p>
                        @endif
                    </div>
                    @endif

                    <div class="flex justify-between items-end">
                        
                        <div id="qr-code-wrapper" class="w-[85px] h-[85px] sm:w-[90px] sm:h-[90px] bg-white border border-gray-200 flex flex-col items-center justify-center shrink-0 p-1.5 shadow-sm transition-all duration-500 ease-in-out transform origin-bottom-left">
                            @if($prescription->status === 'active' || $prescription->status === 'dispensed')
                                {!! QrCode::size(75)->generate($prescription->id) !!}
                            @else
                                <div class="text-[7px] text-gray-400 font-bold uppercase tracking-widest text-center mt-1">
                                    <svg class="w-6 h-6 mx-auto mb-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    QR PENDING
                                </div>
                            @endif
                        </div>

                        <div class="text-left w-[160px] sm:w-[200px] ml-auto flex flex-col font-serif">
                            <div class="relative z-0 space-y-1.5 text-[10px] sm:text-xs">
                                <div class="relative">
                                    <span class="text-gray-400 tracking-tighter flex">________________________, MD</span>
                                    <span class="absolute left-0.5 bottom-0.5 font-sans font-bold text-[#2B3B82] uppercase opacity-90 truncate max-w-[140px] sm:max-w-[180px] inline-block tracking-wide">
                                        {{ $prescription->doctor->first_name }} {{ $prescription->doctor->last_name }}
                                    </span>
                                </div>
                                <div class="relative">
                                    <span class="text-gray-400 flex">Lic. ____________________</span>
                                    <span class="absolute left-6 bottom-0.5 font-sans font-bold text-[#2B3B82] opacity-90">
                                        {{ $prescription->doctor->doctorProfile?->prc_number ?? 'N/A' }}
                                    </span>
                                </div>
                                <div class="relative">
                                    <span class="text-gray-400 flex">PTR ____________________</span>
                                    <span class="absolute left-7 bottom-0.5 font-sans font-bold text-[#2B3B82] opacity-90">
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
</div>

<script>
    let isPharmacyMode = false;
    let wakeLock = null;

    async function togglePharmacyMode() {
        isPharmacyMode = !isPharmacyMode;
        
        const btn = document.getElementById('pharmacyModeBtn');
        const prices = document.querySelectorAll('.sensitive-doh-price');
        const qrWrapper = document.getElementById('qr-code-wrapper');
        
        if (isPharmacyMode) {
            btn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                Exit Pharmacy Mode
            `;
            btn.classList.replace('bg-[#2B3B82]', 'bg-red-600');
            btn.classList.replace('hover:bg-blue-800', 'hover:bg-red-700');
            btn.classList.replace('active:ring-blue-500', 'active:ring-red-500');

            prices.forEach(p => {
                p.parentElement.style.opacity = '0';
                setTimeout(() => { p.parentElement.style.display = 'none'; }, 300);
            });

            qrWrapper.classList.add('scale-[1.35]', 'mb-2', 'ml-4'); 

            try {
                if ('wakeLock' in navigator) {
                    wakeLock = await navigator.wakeLock.request('screen');
                    console.log('SecuRx: Wake Lock active.');
                }
            } catch (err) {}

        } else {
            btn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" /></svg>
                Ready to Scan (Pharmacy Mode)
            `;
            
            btn.classList.replace('bg-red-600', 'bg-[#2B3B82]');
            btn.classList.replace('hover:bg-red-700', 'hover:bg-blue-800');
            btn.classList.replace('active:ring-red-500', 'active:ring-blue-500');

            prices.forEach(p => {
                p.parentElement.style.display = 'flex';
                setTimeout(() => { p.parentElement.style.opacity = '1'; }, 10); 
            });

            qrWrapper.classList.remove('scale-[1.35]', 'mb-2', 'ml-4');

            if (wakeLock !== null) {
                wakeLock.release();
                wakeLock = null;
            }
        }
    }

    document.addEventListener('visibilitychange', async () => {
        if (wakeLock !== null && document.visibilityState === 'visible') {
            try { wakeLock = await navigator.wakeLock.request('screen'); } catch (err) {}
        }
    });
</script>
@endsection