@extends('layouts.doctor')

@section('page_title', 'Encounter Details')

@section('content')
<div x-data="{ showRevokeModal: false }" class="max-w-7xl mx-auto space-y-6 pb-12">

    <div class="bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl p-5 flex flex-col md:flex-row md:items-center justify-between shadow-sm">
        <div class="flex items-center gap-5">
            <a href="{{ route('doctor.history') ?? '#' }}" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition border border-gray-100" title="Back to History">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h2 class="text-xl font-black text-securx-navy leading-none">Consultation Record</h2>
                    <span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-widest flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                        Status: Active (Unscanned)
                    </span>
                </div>
                <p class="text-sm text-gray-500 font-medium">Date: Today, 10:45 AM • Ref: ENCTR-0992X</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3 mt-4 md:mt-0">
            <button onclick="window.print()" class="bg-white border border-gray-300 text-gray-600 hover:border-blue-300 hover:text-blue-600 font-bold py-2 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print PDF
            </button>
            <button @click="showRevokeModal = true" class="bg-red-50 border border-red-100 text-red-600 hover:bg-red-600 hover:text-white font-bold py-2 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Revoke Rx
            </button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <div class="w-full lg:w-1/2 xl:w-5/12 space-y-6">
            
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Patient Profile</h3>
                <div class="flex items-center gap-4 mb-4 border-b border-gray-100 pb-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xl shrink-0">MC</div>
                    <div>
                        <p class="font-black text-securx-navy text-lg leading-none">Reyes, Maria Clara</p>
                        <p class="text-sm text-gray-500 font-medium mt-1">ID: 019D57-X • 45 yrs • Female</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 bg-slate-50 p-3 rounded-xl border border-gray-100">
                    <div><p class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">BP</p><p class="text-sm font-black text-red-500">140/90</p></div>
                    <div><p class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">Temp</p><p class="text-sm font-black text-securx-navy">37.2°C</p></div>
                    <div><p class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">Weight</p><p class="text-sm font-black text-securx-navy">65kg</p></div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-slate-50/50">
                    <h3 class="text-sm font-black text-securx-navy">Clinical Notes (SOAP)</h3>
                </div>
                <div class="p-5 space-y-4">
                    
                    <div>
                        <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider mb-1">Subjective</p>
                        <div class="bg-slate-50 border border-gray-100 p-3 rounded-lg text-sm text-gray-700 font-medium leading-relaxed">
                            Patient presents with persistent dry cough and mild sore throat lasting for 3 days. Denies any fever or chills. Reports mild chest discomfort secondary to coughing.
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider mb-1">Objective</p>
                        <div class="bg-slate-50 border border-gray-100 p-3 rounded-lg text-sm text-gray-700 font-medium leading-relaxed">
                            Vitals checked. Lungs are clear to auscultation bilaterally. No wheezing or rales. Throat is mildly erythematous, no exudates.
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-purple-600 uppercase tracking-wider mb-1">Assessment</p>
                        <div class="bg-slate-50 border border-gray-100 p-3 rounded-lg text-sm text-gray-700 font-medium leading-relaxed">
                            Uncomplicated viral upper respiratory infection (URI).
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-amber-600 uppercase tracking-wider mb-1">Plan</p>
                        <div class="bg-slate-50 border border-gray-100 p-3 rounded-lg text-sm text-gray-700 font-medium leading-relaxed">
                            Advised oral hydration and rest. Prescribed Losartan for maintaining BP. Warned patient to return if symptoms worsen or fever develops.
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 xl:w-7/12 print:w-full print:m-0 flex justify-center">
            
            <div id="prescription-paper" class="bg-white w-full max-w-[600px] shadow-[0_10px_40px_rgba(0,0,0,0.12)] border border-gray-200 aspect-[1/1.414] relative overflow-hidden flex flex-col print:shadow-none print:border-none">
                
                <div class="h-3 w-full bg-securx-navy shrink-0"></div>

                <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none z-0">
                    <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                </div>

                <div class="p-8 flex-1 flex flex-col relative z-10">
                    
                    <div class="text-center border-b-2 border-gray-800 pb-4 mb-4">
                        <h1 class="text-2xl font-serif font-black text-gray-900 tracking-wide">DR. ROBERTO SANTOS, MD</h1>
                        <p class="text-sm font-serif text-gray-600">Internal Medicine • License No: 0019283</p>
                        <p class="text-xs text-gray-500 mt-1">St. Luke's Medical Center, Room 402 • (02) 8-723-0101</p>
                    </div>

                    <div class="grid grid-cols-4 gap-2 text-xs font-serif text-gray-800 mb-6 border-b border-gray-300 pb-4">
                        <div class="col-span-2">
                            <p><span class="font-bold text-gray-500 uppercase text-[10px]">Patient Name:</span></p>
                            <p class="font-bold text-sm border-b border-gray-300 border-dotted mt-1">Maria Clara Reyes</p>
                        </div>
                        <div class="col-span-1">
                            <p><span class="font-bold text-gray-500 uppercase text-[10px]">Age/Sex:</span></p>
                            <p class="font-bold text-sm border-b border-gray-300 border-dotted mt-1">45 / F</p>
                        </div>
                        <div class="col-span-1">
                            <p><span class="font-bold text-gray-500 uppercase text-[10px]">Date:</span></p>
                            <p class="font-bold text-sm border-b border-gray-300 border-dotted mt-1">{{ date('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="text-6xl font-serif font-black text-gray-900 italic tracking-tighter pr-2">Rx</span>
                    </div>

                    <div class="flex-1 space-y-6 pl-4 font-serif">
                        <div>
                            <p class="text-base font-bold text-gray-900">1. Losartan Potassium 50mg tablet</p>
                            <div class="flex justify-between items-end pr-4 mt-1">
                                <p class="text-sm text-gray-700 italic">Sig: Take one (1) tablet orally once a day.</p>
                                <p class="text-sm font-bold text-gray-900">#30 (Thirty) tabs</p>
                            </div>
                            <p class="text-xs text-gray-500 italic mt-1 pl-4 border-l-2 border-gray-300">Note: Must dispense exact brand, no generic allowed.</p>
                        </div>
                    </div>

                    <div class="mt-8 pt-4 flex justify-between items-end shrink-0">
                        
                        <div class="flex gap-4 items-center">
                            <div class="w-24 h-24 bg-white p-1 border border-gray-300 flex items-center justify-center shrink-0">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=SECURX-{{ Str::random(12) }}" alt="SecuRx Encrypted Payload" class="w-full h-full object-contain">
                            </div>
                            <div class="font-sans">
                                <p class="text-[10px] font-black text-securx-navy uppercase tracking-widest flex items-center gap-1">
                                    <svg class="w-3 h-3 text-securx-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                                    SecuRx Verified
                                </p>
                                <p class="text-[9px] text-gray-500 leading-tight mt-1 max-w-[120px]">
                                    Scan QR code to verify cryptographic signature and digital authenticity.
                                </p>
                                <p class="text-[8px] text-gray-400 font-mono mt-1">ID: {{ Str::upper(Str::uuid()->toString()) }}</p>
                            </div>
                        </div>

                        <div class="text-center w-48">
                            <div class="border-b border-gray-800 pb-1 mb-1 relative">
                                <p class="font-[Brush_Script_MT,cursive] text-3xl text-blue-900 absolute bottom-1 w-full text-center opacity-80 -rotate-3">R. Santos</p>
                                <div class="h-8"></div>
                            </div>
                            <p class="text-xs font-serif font-bold text-gray-900">Dr. Roberto Santos, MD</p>
                            <p class="text-[10px] font-serif text-gray-600">Lic No: 0019283 • PTR: 99120</p>
                        </div>

                    </div>
                </div>
            </div>
            
            <p class="text-xs text-center text-gray-400 mt-4 print:hidden">This is a digital preview of the printable document.</p>
        </div>

    </div>

    <div x-show="showRevokeModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showRevokeModal" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="showRevokeModal = false"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="showRevokeModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-red-100">
                
                <div class="bg-red-50/50 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-red-100">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-black leading-6 text-red-800">Revoke Prescription</h3>
                            <div class="mt-2">
                                <p class="text-sm text-red-700 font-medium">You are about to permanently invalidate this QR code. If the patient presents this at a pharmacy, it will immediately flag as revoked.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-5 sm:p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Reason for Revocation (Required)</label>
                        <select class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-red-500 focus:border-red-500 font-medium text-gray-700">
                            <option>Select a clinical reason...</option>
                            <option>Clinical Error / Incorrect Dosage</option>
                            <option>Patient reported adverse reaction</option>
                            <option>Therapy changed before dispensing</option>
                        </select>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-200">
                    <button type="button" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition-colors">
                        Confirm Revocation
                    </button>
                    <button @click="showRevokeModal = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    @media print {
        body { background: white; }
        aside, header, .print\:hidden { display: none !important; }
        #prescription-paper { 
            box-shadow: none !important; 
            border: none !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: none !important;
        }
    }
</style>
@endsection