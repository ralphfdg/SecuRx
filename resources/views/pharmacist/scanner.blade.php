@extends('layouts.pharmacist')

@section('page_title', 'Secure QR Decryption')

@section('content')
    <div class="max-w-7xl mx-auto h-[calc(100vh-10rem)]">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 h-full">

            <div class="lg:col-span-4 flex flex-col h-full space-y-4">

                <div class="glass-panel p-5 bg-white/90 rounded-2xl shadow-sm border border-gray-200 h-full flex flex-col">
                    <div class="flex justify-between items-center mb-4 shrink-0">
                        <h2 class="text-lg font-extrabold text-securx-navy">Optical Scanner</h2>
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Active
                        </span>
                    </div>

                    <p class="text-xs text-gray-500 mb-6 shrink-0">Align the patient's SecuRx QR code within the frame to
                        decrypt the cryptographic payload.</p>

                    <div class="relative w-full flex-1 min-h-[250px] bg-slate-900 rounded-xl overflow-hidden shadow-inner flex items-center justify-center group cursor-pointer mb-6"
                        onclick="simulateScan()">

                        <div
                            class="absolute w-full h-0.5 bg-securx-cyan shadow-[0_0_15px_rgba(28,181,209,0.8)] z-10 scan-line">
                        </div>

                        <div
                            class="absolute inset-8 border-2 border-white/10 rounded-xl transition-all duration-300 group-hover:border-white/30">
                            <div
                                class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-securx-cyan rounded-tl-xl transition-all duration-300 group-hover:w-12 group-hover:h-12">
                            </div>
                            <div
                                class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-securx-cyan rounded-tr-xl transition-all duration-300 group-hover:w-12 group-hover:h-12">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-securx-cyan rounded-bl-xl transition-all duration-300 group-hover:w-12 group-hover:h-12">
                            </div>
                            <div
                                class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-securx-cyan rounded-br-xl transition-all duration-300 group-hover:w-12 group-hover:h-12">
                            </div>
                        </div>

                        <p class="text-white/40 font-bold text-xs z-0 group-hover:text-securx-cyan transition-colors">Click
                            frame to simulate successful scan</p>
                    </div>

                    <div class="shrink-0 pt-4 border-t border-gray-100">
                        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Manual Override</h3>
                        <div class="flex gap-2">
                            <input type="text" placeholder="UUID e.g. ENCTR-8F92A"
                                class="w-full bg-slate-50 border border-gray-200 rounded-lg p-2.5 text-sm font-mono focus:ring-securx-cyan focus:border-securx-cyan uppercase">
                            <button type="button"
                                class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2.5 px-4 rounded-lg transition-colors text-xs">Decrypt</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 flex flex-col h-full relative" x-data="{ showPatientName: true, generalInstructions: 'Avoid strenuous activities.', nextAppointment: '2026-05-05' }">

                <div id="scan-empty"
                    class="absolute inset-0 bg-white/60 backdrop-blur-sm border border-gray-200 rounded-2xl shadow-sm flex flex-col items-center justify-center text-center transition-all duration-500 z-20">
                    <div
                        class="w-24 h-24 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-gray-300 mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-securx-navy mb-2">Awaiting Verification</h3>
                    <p class="text-sm text-gray-500 max-w-sm">Scan a patient's SecuRx QR code to instantly verify
                        authenticity, load the digital prescription, and trigger DUR safety checks.</p>
                </div>

                <div id="scan-populated"
                    class="absolute inset-0 bg-slate-50 border border-gray-200 rounded-2xl shadow-lg overflow-hidden flex flex-col transition-all duration-500 opacity-0 pointer-events-none translate-y-4 z-10">

                    <div
                        class="p-5 border-b border-gray-200 bg-white flex justify-between items-center shrink-0 shadow-sm z-10">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 border border-emerald-100 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-black text-emerald-700 leading-tight">Signature Authenticated</h2>
                                <p
                                    class="text-[10px] text-gray-500 font-mono font-bold mt-0.5 bg-slate-100 px-1.5 py-0.5 rounded inline-block">
                                    UUID: ENCTR-0992X</p>
                            </div>
                        </div>
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Originating
                                Physician</p>
                            <p class="text-sm font-black text-securx-navy">Dr. Juan V. Santos, MD</p>
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col md:flex-row overflow-hidden">

                        <div
                            class="w-full md:w-1/2 p-6 overflow-y-auto custom-scrollbar border-r border-gray-200 bg-white/50">

                            <div class="bg-red-50 border-l-4 border-red-500 rounded-r-xl p-4 shadow-sm mb-6">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-black text-red-800">DUR Warning: Known Allergy</h4>
                                        <p class="text-xs text-red-700 mt-1 font-medium leading-relaxed">System flags
                                            potential cross-reactivity. Patient profile indicates a severe verified allergy
                                            to <span class="font-bold underline">Penicillin</span>. Proceed with extreme
                                            caution.</p>
                                    </div>
                                </div>
                            </div>

                            <h4
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-200 pb-2">
                                Patient Demographics</h4>

                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-black text-lg shadow-inner border border-blue-200 shrink-0">
                                    MC</div>
                                <div>
                                    <p class="text-base font-black text-securx-navy">Maria Clara Reyes</p>

                                </div>
                            </div>

                            <h4
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 border-b border-gray-200 pb-2">
                                Extracted Pharmacy Notes</h4>
                            <div
                                class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm font-medium text-blue-800 italic">
                                "Dispense exact brand only. Do not substitute with generics per patient request."
                            </div>
                        </div>

                        <div
                            class="w-full md:w-1/2 bg-slate-100 p-6 overflow-y-auto custom-scrollbar flex justify-center items-start">

                            <div
                                class="bg-white shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 aspect-[1/1.414] relative flex flex-col w-full rounded-sm overflow-hidden">

                                <div class="h-2 w-full bg-securx-navy shrink-0"></div>

                                <div class="p-6 flex-1 flex flex-col relative z-10">

                                    <div class="text-center border-b-2 border-gray-800 pb-4 mb-4 flex flex-col items-center">
                            <div class="flex items-center justify-center gap-2">
                                <a class="relative inline-block group pt-2 pb-1">
                                    <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                                        class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                                </a>
                            </div>
                        </div>

                                        <div
                                            class="grid grid-cols-4 gap-2 text-[10px] font-serif text-gray-800 mb-4 border-b border-gray-300 pb-3">
                                            <div class="col-span-2">
                                                <p class="text-[8px] font-bold text-gray-500 uppercase">Name:</p>
                                                <p class="font-bold border-b border-gray-300 border-dotted"
                                                    :class="!showPatientName ? 'text-gray-400 italic' : 'text-gray-900'"
                                                    x-text="showPatientName ? 'Maria Clara Reyes' : '____________________'">
                                                </p>
                                            </div>
                                            <div class="col-span-1">
                                                <p class="text-[8px] font-bold text-gray-500 uppercase">Age/Sex:</p>
                                                <p class="font-bold border-b border-gray-300 border-dotted"
                                                    :class="!showPatientName ? 'text-gray-400 italic' : 'text-gray-900'"
                                                    x-text="showPatientName ? '45/F' : '__________'"></p>
                                            </div>
                                            <div class="col-span-1">
                                                <p class="text-[8px] font-bold text-gray-500 uppercase">Date:</p>
                                                <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">
                                                    {{ date('m/d/Y') }}</p>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <span
                                                class="text-4xl font-serif font-black text-gray-900 italic tracking-tighter">Rx</span>
                                        </div>

                                        <div
                                            class="flex-1 space-y-4 pl-2 font-serif overflow-y-auto custom-scrollbar pr-2 flex flex-col">

                                            <div class="relative group">
                                                <button
                                                    class="absolute -left-2 top-0 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition"><svg
                                                        class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                            clip-rule="evenodd"></path>
                                                    </svg></button>

                                                <p class="text-sm font-bold text-gray-900">1. Losartan Potassium 50mg tab
                                                </p>
                                                <div class="flex justify-between items-end mt-0.5">
                                                    <p class="text-xs text-gray-700 italic">Sig: Take 1 tab OD for 30 days.
                                                    </p>
                                                    <p class="text-xs font-bold text-gray-900">#30 tabs</p>
                                                </div>
                                                <p
                                                    class="text-[9px] text-gray-500 italic mt-0.5 border-l border-gray-300 pl-2 ml-1">
                                                    To Rx:
                                                    Exact brand only.</p>
                                                <p
                                                    class="text-[9px] text-blue-600 italic mt-0.5 border-l border-blue-200 pl-2 ml-1">
                                                    To Pt:
                                                    Take after breakfast.</p>
                                            </div>

                                            <div class="flex-1"></div>

                                            <div class="pt-3 border-t border-gray-200 border-dashed"
                                                x-show="generalInstructions || nextAppointment" style="display: none;">
                                                <div x-show="generalInstructions" class="mb-2">
                                                    <p
                                                        class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">
                                                        Additional
                                                        Instructions:</p>
                                                    <p class="text-[11px] font-serif text-gray-800 mt-0.5 italic"
                                                        x-text="generalInstructions"></p>
                                                </div>
                                                <div x-show="nextAppointment">
                                                    <p
                                                        class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">
                                                        Next
                                                        Appointment:</p>
                                                    <p class="text-[11px] font-serif text-gray-900 mt-0.5 font-bold"
                                                        x-text="nextAppointment"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-2 border-t border-gray-100 shrink-0">
                                            <div class="flex justify-between items-end">

                                                <div
                                                    class="w-16 h-16 bg-gray-50 border border-gray-200 flex flex-col items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6 text-gray-300" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                                        </path>
                                                    </svg>
                                                    <span class="text-[6px] text-gray-400 mt-1 font-sans">QR
                                                        VERIFIED</span>
                                                </div>

                                                <div class="text-left w-[170px] ml-auto flex flex-col font-serif">

                                                    <div class="relative z-0 space-y-1 text-[11px]">
                                                        <div class="relative">
                                                            <span
                                                                class="text-gray-400 tracking-tighter">____________________,
                                                                MD</span>
                                                            <span
                                                                class="absolute left-0.5 bottom-0.5 font-sans font-bold text-blue-800 uppercase opacity-90">Juan
                                                                V. Santos</span>
                                                        </div>

                                                        <div class="relative">
                                                            <span class="text-gray-400">Lic. _________________</span>
                                                            <span
                                                                class="absolute left-5 bottom-0.5 font-sans font-bold text-blue-800 opacity-90">0111111</span>
                                                        </div>

                                                        <div class="relative">
                                                            <span class="text-gray-400">PTR _________________</span>
                                                            <span
                                                                class="absolute left-6 bottom-0.5 font-sans font-bold text-blue-800 opacity-90">AC-1111111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div
                            class="p-5 border-t border-gray-200 bg-white flex justify-between gap-4 shrink-0 shadow-[0_-4px_10px_rgba(0,0,0,0.02)] z-10">
                            <button onclick="resetScanner()"
                                class="bg-white border border-gray-300 text-gray-700 font-bold py-2.5 px-6 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm">Cancel
                                Scan</button>
                            <a href="{{ route('pharmacist.dispense') ?? '#' }}"
                                class="bg-securx-navy hover:bg-blue-800 text-white font-bold rounded-xl shadow-[0_4px_14px_0_rgba(0,0,0,0.2)] py-2.5 px-8 transition-all duration-300 flex items-center gap-2 text-sm">
                                Verify & Proceed to Dispense
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <style>
            /* Custom Scrollbar for inner elements */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 20px;
            }

            /* Smooth CSS Animation for the Scanner Laser */
            @keyframes scan {

                0%,
                100% {
                    top: 5%;
                    opacity: 0;
                }

                10%,
                90% {
                    opacity: 1;
                }

                50% {
                    top: 95%;
                }
            }

            .scan-line {
                animation: scan 3s ease-in-out infinite;
            }
        </style>

        <script>
            function simulateScan() {
                // Play success beep
                const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
                audio.volume = 0.2;
                audio.play().catch(e => console.log("Audio play prevented"));

                const emptyState = document.getElementById('scan-empty');
                const popState = document.getElementById('scan-populated');

                // Fade out empty state
                emptyState.style.opacity = '0';

                setTimeout(() => {
                    emptyState.classList.add('hidden');
                    popState.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
                    popState.classList.add('opacity-100', 'translate-y-0');
                }, 300); // Wait for fade out
            }

            function resetScanner() {
                const emptyState = document.getElementById('scan-empty');
                const popState = document.getElementById('scan-populated');

                popState.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
                popState.classList.remove('opacity-100', 'translate-y-0');

                setTimeout(() => {
                    emptyState.classList.remove('hidden');
                    // Force reflow
                    void emptyState.offsetWidth;
                    emptyState.style.opacity = '1';
                }, 300);
            }
        </script>
    @endsection
