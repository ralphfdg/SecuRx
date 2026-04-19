@extends('layouts.pharmacist')

@section('page_title', 'Secure QR Decryption')

@section('content')
    <div x-data="scannerController()" class="max-w-7xl mx-auto h-[calc(100vh-10rem)]">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 h-full">

            <div class="lg:col-span-4 flex flex-col h-full space-y-4">
                <div class="glass-panel p-5 bg-white/90 rounded-2xl shadow-sm border border-gray-200 h-full flex flex-col">
                    <div class="flex justify-between items-center mb-4 shrink-0">
                        <h2 class="text-lg font-extrabold text-securx-navy">Optical Scanner</h2>
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full animate-pulse"
                                :class="isScanning ? 'bg-amber-500' : 'bg-emerald-500'"></span>
                            <span x-text="isScanning ? 'Decrypting...' : 'Active'"></span>
                        </span>
                    </div>

                    <div
                        class="relative w-full flex-1 min-h-[250px] bg-slate-900 rounded-xl overflow-hidden shadow-inner flex items-center justify-center group mb-6">
                        <div
                            class="absolute w-full h-0.5 bg-securx-cyan shadow-[0_0_15px_rgba(28,181,209,0.8)] z-10 scan-line">
                        </div>
                        <p class="text-white/40 font-bold text-xs z-0"
                            x-text="isScanning ? 'Processing...' : 'Awaiting Scan'"></p>
                    </div>

                    <div class="shrink-0 pt-4 border-t border-gray-100">
                        <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-2">Manual Override</h3>
                        <form @submit.prevent="processDecryptedUUID(manualUuid)" class="flex gap-2">
                            <input type="text" x-model="manualUuid" placeholder="UUID"
                                class="w-full bg-slate-50 border border-gray-200 rounded-lg p-2.5 text-sm font-mono focus:ring-securx-cyan uppercase">
                            <button type="submit" :disabled="isScanning || !manualUuid"
                                class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2.5 px-4 rounded-lg text-xs disabled:opacity-50">Decrypt</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 flex flex-col h-full relative">

                <div id="scan-empty" x-show="!hasData"
                    class="absolute inset-0 bg-white/60 backdrop-blur-sm border border-gray-200 rounded-2xl flex flex-col items-center justify-center z-20">
                    <h3 class="text-xl font-black text-securx-navy mb-2">Awaiting Verification</h3>
                    <p class="text-sm text-gray-500">Scan a SecuRx QR code to verify.</p>
                </div>

                <div id="scan-populated" x-show="hasData" style="display: none;"
                    class="absolute inset-0 bg-slate-50 border border-gray-200 rounded-2xl flex flex-col z-10 overflow-hidden">
                    <div class="p-5 border-b border-gray-200 bg-white flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-black text-emerald-700">Authenticated</h2>
                            <p class="text-[10px] text-gray-500 font-mono" x-text="prescriptionId"></p>
                        </div>
                    </div>

                    <div class="flex-1 flex overflow-hidden p-6 gap-6">
                        <div class="w-1/2">
                            <template x-for="warning in durWarnings" :key="warning.message">
                                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                                    <h4 class="text-sm font-black text-red-800" x-text="'DUR: ' + warning.type"></h4>
                                    <p class="text-xs text-red-700" x-text="warning.message"></p>
                                </div>
                            </template>
                            <h4 class="font-bold text-gray-400 uppercase tracking-widest text-xs">Patient</h4>
                            <p class="font-black text-lg" x-text="patient.name"></p>
                            <p class="text-gray-500 text-sm" x-text="patient.age + ' yrs • ' + patient.sex"></p>
                        </div>
                        <div
                            class="w-1/2 bg-white shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 relative flex flex-col rounded-sm overflow-hidden min-h-0">
                            <div class="h-2 w-full bg-securx-navy shrink-0"></div>

                            <div class="p-4 sm:p-5 flex-1 flex flex-col relative z-10 min-h-0">
                                <div class="w-full flex justify-center mb-3 shrink-0">
                                    <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx" class="h-3 w-auto">
                                </div>

                                <div class="flex flex-row items-center gap-3 border-b-2 border-gray-800 pb-3 mb-3 shrink-0">
                                    <div
                                        class="w-12 h-12 bg-white border border-gray-200 rounded-lg flex flex-col items-center justify-center shrink-0 overflow-hidden">
                                        <svg class="w-6 h-6 text-blue-800 opacity-80" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 flex flex-col min-w-0">
                                        <h1 class="text-base sm:text-lg font-serif font-black text-gray-900 tracking-wide uppercase text-center mb-1 leading-tight"
                                            x-text="doctor.clinic_name"></h1>
                                        <div
                                            class="flex flex-col xl:flex-row justify-between items-center xl:items-start gap-1 w-full">
                                            <p class="text-[9px] sm:text-[10px] font-serif text-gray-600 leading-snug flex-1 text-center xl:text-left"
                                                x-text="doctor.clinic_address"></p>
                                            <p class="text-[9px] sm:text-[10px] font-serif text-gray-800 font-bold shrink-0 text-center xl:text-right whitespace-nowrap mt-0.5 xl:mt-0"
                                                x-text="'Tel: ' + doctor.contact_number"></p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-[9px] font-serif text-gray-800 mb-3 border-b border-gray-300 pb-2 shrink-0">
                                    <div class="col-span-2">
                                        <p class="text-[7px] font-bold text-gray-500 uppercase">Name:</p>
                                        <p class="font-bold border-b border-gray-300 border-dotted truncate text-gray-900"
                                            x-text="patient.name"></p>
                                    </div>
                                    <div class="col-span-1">
                                        <p class="text-[7px] font-bold text-gray-500 uppercase">Age/Sex:</p>
                                        <p class="font-bold border-b border-gray-300 border-dotted text-gray-900"
                                            x-text="patient.age + '/' + patient.sex"></p>
                                    </div>
                                    <div class="col-span-1">
                                        <p class="text-[7px] font-bold text-gray-500 uppercase">Date:</p>
                                        <p class="font-bold border-b border-gray-300 border-dotted text-gray-900"
                                            x-text="date"></p>
                                    </div>
                                </div>

                                <div class="mb-1 shrink-0">
                                    <span
                                        class="text-3xl font-serif font-black text-gray-900 italic tracking-tighter">Rx</span>
                                </div>

                                <div
                                    class="flex-1 space-y-3 pl-1 font-serif overflow-y-auto custom-scrollbar pr-2 flex flex-col min-h-0 relative">
                                    <template x-for="(item, index) in prescriptionItems" :key="item.item_id">
                                        <div class="relative group border-b border-gray-100 pb-2">
                                            <p class="text-xs font-bold text-gray-900 flex items-center flex-wrap gap-1.5">
                                                <span x-text="`${index + 1}. ${item.generic_name}`"></span>
                                                <span x-show="item.dosage"
                                                    class="bg-red-100 text-red-700 border border-red-200 font-black px-1 py-0.5 rounded text-[9px] uppercase tracking-wider shadow-sm"
                                                    x-text="item.dosage"></span>
                                                <span class="text-[10px] text-gray-500 font-medium"
                                                    x-text="`(${item.brand_name})`"></span>
                                            </p>
                                            <div class="flex justify-between items-end mt-0.5">
                                                <p class="text-[11px] text-gray-700 italic" x-text="`Sig: ${item.sig}`">
                                                </p>
                                                <p class="text-[11px] font-bold text-gray-900"
                                                    x-text="`#${item.quantity}`"></p>
                                            </div>
                                            <p x-show="item.dispense_as_written"
                                                class="text-[8px] text-red-600 font-bold italic mt-1 border-l-2 border-red-200 pl-2 ml-1"
                                                x-text="`To Rx: ${item.dispense_as_written}`"></p>
                                        </div>
                                    </template>
                                </div>

                                <div class="mt-2 pt-2 border-t border-gray-100 shrink-0">
                                    <div class="flex justify-between items-end">
                                        <div
                                            class="w-12 h-12 bg-gray-50 border border-gray-200 flex flex-col items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span
                                                class="text-[5px] text-emerald-600 mt-1 font-sans font-bold tracking-wider">VERIFIED</span>
                                        </div>
                                        <div class="text-left w-[140px] ml-auto flex flex-col font-serif">
                                            <div class="relative z-0 space-y-1 text-[9px]">
                                                <div class="relative">
                                                    <span class="text-gray-400 tracking-tighter">__________________,
                                                        MD</span>
                                                    <span
                                                        class="absolute left-0.5 bottom-0 font-sans font-bold text-blue-800 uppercase opacity-90 truncate max-w-[120px] inline-block"
                                                        x-text="doctor.name"></span>
                                                </div>
                                                <div class="relative">
                                                    <span class="text-gray-400">Lic. _______________</span>
                                                    <span
                                                        class="absolute left-5 bottom-0 font-sans font-bold text-blue-800 opacity-90"
                                                        x-text="doctor.prc_license"></span>
                                                </div>
                                                <div class="relative">
                                                    <span class="text-gray-400">PTR _______________</span>
                                                    <span
                                                        class="absolute left-6 bottom-0 font-sans font-bold text-blue-800 opacity-90"
                                                        x-text="doctor.ptr_number"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 border-t bg-white flex justify-between">
                        <button @click="resetScanner()" class="bg-gray-100 font-bold py-2 px-6 rounded-xl">Cancel</button>
                        <a :href="'/pharmacist/dispense/' + prescriptionId"
                            class="bg-securx-navy text-white font-bold py-2 px-8 rounded-xl">Proceed to Dispense</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .scan-line { animation: scan 3s ease-in-out infinite; } 
        @keyframes scan { 
            0%, 100% { top: 5%; opacity: 0; } 
            50% { top: 95%; opacity: 1; } 
        }
    </style>
    @vite(['resources/js/pharmacist-scanner.js'])
@endpush
