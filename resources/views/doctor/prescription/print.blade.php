<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecuRx Prescription - {{ substr($prescription->id, 0, 8) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Force standard A5 medical pad size */
        @page {
            size: A5 portrait;
            margin: 10mm;
        }
        
        /* Print-specific overrides to preserve Tailwind colors */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; margin: 0; padding: 0; display: block; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .print-canvas { box-shadow: none !important; border: none !important; margin: 0 auto !important; }
        }
    </style>
</head>
<body class="bg-slate-100 flex justify-center items-start min-h-screen py-8 font-sans">

    <div class="fixed top-6 right-6 flex gap-3 no-print z-50">
        <button onclick="window.close()" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2 px-5 rounded-xl shadow-sm transition text-sm">
            Close
        </button>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl shadow-lg flex items-center gap-2 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print / Save PDF
        </button>
    </div>

    <div class="print-canvas bg-white shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 relative flex flex-col w-full max-w-[148mm] min-h-[210mm] rounded-sm overflow-hidden">
        
        <div class="h-2 w-full bg-securx-navy shrink-0"></div>

        <div class="p-5 flex-1 flex flex-col relative z-10 min-h-0">
            
            <div class="w-full flex justify-center mb-3 shrink-0">
                <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx" class="h-3 w-auto">
            </div>

            <div class="flex flex-row items-center gap-3 border-b-2 border-gray-800 pb-3 mb-3 shrink-0">
                <div class="w-12 h-12 bg-white border border-gray-200 rounded-lg flex flex-col items-center justify-center shrink-0 overflow-hidden">
                    @if(!empty($prescription->doctor->doctorProfile->clinic->clinic_logo))
                        <img src="{{ asset('storage/' . $prescription->doctor->doctorProfile->clinic->clinic_logo) }}" alt="Clinic Logo" class="w-full h-full object-contain p-1">
                    @else
                        <svg class="w-6 h-6 text-blue-800 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    @endif
                </div>

                <div class="flex-1 flex flex-col min-w-0">
                    <h1 class="text-base sm:text-lg font-serif font-black text-gray-900 tracking-wide uppercase text-center mb-1 leading-tight">
                        {{ $prescription->doctor->doctorProfile->clinic->clinic_name ?? 'MEDICAL CLINIC INC.' }}
                    </h1>
                    <div class="flex flex-row justify-between items-start gap-1 w-full">
                        <p class="text-[9px] sm:text-[10px] font-serif text-gray-600 leading-snug flex-1 text-left">
                            {{ $prescription->doctor->doctorProfile->clinic->clinic_address ?? '123 Health Avenue, Medical District, City' }}
                        </p>
                        <p class="text-[9px] sm:text-[10px] font-serif text-gray-800 font-bold shrink-0 text-right whitespace-nowrap">
                            Tel: {{ $prescription->doctor->doctorProfile->clinic->contact_number ?? '(000) 123-4567' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-2 text-[9px] font-serif text-gray-800 mb-3 border-b border-gray-300 pb-2 shrink-0">
                <div class="col-span-2">
                    <p class="text-[7px] font-bold text-gray-500 uppercase">Name:</p>
                    <p class="font-bold border-b border-gray-300 border-dotted truncate {{ !$prescription->print_patient_name ? 'text-gray-400 italic' : 'text-gray-900' }}">
                        {{ $prescription->print_patient_name ? ($prescription->patient->name ?? 'Unknown') : '____________________' }}
                    </p>
                </div>
                <div class="col-span-1">
                    <p class="text-[7px] font-bold text-gray-500 uppercase">Age/Sex:</p>
                    <p class="font-bold border-b border-gray-300 border-dotted {{ !$prescription->print_patient_name ? 'text-gray-400 italic' : 'text-gray-900' }}">
                        @if($prescription->print_patient_name)
                            {{ $prescription->patient->dob ? \Carbon\Carbon::parse($prescription->patient->dob)->age : 'N/A' }}/{{ strtoupper(substr($prescription->patient->gender ?? 'U', 0, 1)) }}
                        @else
                            __________
                        @endif
                    </p>
                </div>
                <div class="col-span-1">
                    <p class="text-[7px] font-bold text-gray-500 uppercase">Date:</p>
                    <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">{{ $prescription->created_at->format('m/d/Y') }}</p>
                </div>
            </div>

            <div class="mb-1 shrink-0">
                <span class="text-3xl font-serif font-black text-gray-900 italic tracking-tighter">Rx</span>
            </div>

            <div class="flex-1 space-y-3 pl-1 font-serif pr-2 flex flex-col relative">
                @forelse($prescription->items as $index => $item)
                    <div class="relative group">
                        <p class="text-xs font-bold text-gray-900 flex items-center flex-wrap gap-1.5">
                            <span>{{ $index + 1 }}. {{ $item->medication->generic_name }}</span>
                            @if($item->medication->dosage_strength)
                                <span class="bg-red-100 text-red-700 border border-red-200 font-black px-1 py-0.5 rounded text-[9px] uppercase tracking-wider shadow-sm">{{ $item->medication->dosage_strength }}</span>
                            @endif
                            @if($item->medication->form)
                                <span class="text-[10px] text-gray-500 font-medium">{{ $item->medication->form }}</span>
                            @endif
                        </p>
                        <div class="flex justify-between items-end mt-0.5">
                            <p class="text-[11px] text-gray-700 italic">Sig: {{ $item->sig ?: 'Take as directed' }}</p>
                            <p class="text-[11px] font-bold text-gray-900">#{{ $item->quantity }}</p>
                        </div>
                        @if($item->pharmacist_instructions)
                            <p class="text-[8px] text-gray-500 italic mt-0.5 border-l border-gray-300 pl-2 ml-1">To Rx: {{ $item->pharmacist_instructions }}</p>
                        @endif
                        @if($item->patient_instructions)
                            <p class="text-[8px] text-blue-600 italic mt-0.5 border-l border-blue-200 pl-2 ml-1">To Pt: {{ $item->patient_instructions }}</p>
                        @endif
                    </div>
                @empty
                    <div class="text-xs text-gray-400 italic">No medications prescribed.</div>
                @endforelse
            </div>

            @if($prescription->general_instructions || ($prescription->encounter && $prescription->encounter->next_appointment_date))
                <div class="pt-2 border-t border-gray-200 border-dashed shrink-0 mt-4">
                    @if($prescription->general_instructions)
                        <div class="mb-1.5">
                            <p class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">Additional Instructions:</p>
                            <p class="text-[10px] font-serif text-gray-800 mt-0.5 italic">{{ $prescription->general_instructions }}</p>
                        </div>
                    @endif
                    @if($prescription->encounter && $prescription->encounter->next_appointment_date)
                        <div>
                            <p class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">Next Appointment:</p>
                            <p class="text-[10px] font-serif text-gray-900 mt-0.5 font-bold">{{ \Carbon\Carbon::parse($prescription->encounter->next_appointment_date)->format('F j, Y') }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <div class="mt-2 pt-2 border-t border-gray-100 shrink-0">
                <div class="flex justify-between items-end">
                    
                    <div class="w-32 h-32 bg-white border border-gray-200 p-1 flex flex-col items-center justify-center shrink-0 rounded">
                        {!! QrCode::size(112)->margin(0)->generate($prescription->id) !!}
                    </div>

                    <div class="text-left w-[140px] ml-auto flex flex-col font-serif">
                        <div class="relative z-0 space-y-1 text-[9px]">
                            <div class="relative">
                                <span class="text-gray-400 tracking-tighter">__________________, MD</span>
                                <span class="absolute left-0.5 bottom-0 font-sans font-bold text-blue-800 uppercase opacity-90 truncate max-w-[120px] inline-block">{{ $prescription->doctor->name }}</span>
                            </div>
                            <div class="relative">
                                <span class="text-gray-400">Lic. _______________</span>
                                <span class="absolute left-5 bottom-0 font-sans font-bold text-blue-800 opacity-90">{{ $prescription->doctor->doctorProfile->prc_number ?? 'N/A' }}</span>
                            </div>
                            <div class="relative">
                                <span class="text-gray-400">PTR _______________</span>
                                <span class="absolute left-6 bottom-0 font-sans font-bold text-blue-800 opacity-90">{{ $prescription->doctor->doctorProfile->ptr_number ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 800);
        };
    </script>
</body>
</html>