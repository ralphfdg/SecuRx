@extends('layouts.doctor')

@section('page_title', 'Consultation Console')

@section('content')
<div x-data="consultationConsole()" class="max-w-7xl mx-auto space-y-6 pb-12 relative">

    <div class="bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl p-5 flex flex-col xl:flex-row xl:items-center justify-between shadow-sm sticky top-0 z-30">
        
        <div class="flex items-center gap-5">
            <a href="{{ route('doctor.queue') ?? '#' }}" class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition border border-gray-100" title="Back to Queue">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h2 class="text-2xl font-black text-securx-navy leading-none">Reyes, Maria Clara</h2>
                    <span class="bg-blue-100 text-blue-700 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-widest">Active File</span>
                </div>
                <div class="flex items-center gap-3 text-sm font-medium text-gray-500 mt-1">
                    <span>ID: 019D57-X</span> <span class="text-gray-300">•</span> <span>45 yrs</span> <span class="text-gray-300">•</span> <span>Female</span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-4 mt-4 xl:mt-0 flex-wrap">
            <div class="hidden md:flex items-center gap-5 bg-slate-50 px-4 py-2 rounded-xl border border-gray-100 mr-2">
                <div><p class="text-[10px] font-bold text-gray-400 uppercase">BP</p><p class="text-sm font-black text-red-500">140/90</p></div>
                <div class="w-px h-6 bg-gray-200"></div>
                <div><p class="text-[10px] font-bold text-gray-400 uppercase">Temp</p><p class="text-sm font-black text-securx-navy">37.2°C</p></div>
            </div>

            <button @click="showDurDrawer = true" class="relative p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition border border-amber-200 shadow-sm tooltip-trigger" title="Safety Alerts">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-black text-white shadow-md animate-bounce">1</span>
            </button>

            <button @click="showTemplatesDrawer = true" class="bg-white border-2 border-gray-200 text-gray-600 hover:border-blue-600 hover:text-blue-600 font-bold py-2.5 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                SOAP Templates
            </button>

            <button @click="showRecordsDrawer = true" class="bg-white border-2 border-securx-navy text-securx-navy hover:bg-securx-navy hover:text-white font-bold py-2.5 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                View Full Records
            </button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 items-start">

        <div class="w-full lg:w-7/12 xl:w-2/3 space-y-6">
            
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-slate-50/50">
                    <h3 class="text-base font-black text-securx-navy flex items-center gap-2">
                        <span class="bg-blue-600 text-white w-6 h-6 rounded-md flex items-center justify-center text-xs">1</span>
                        Clinical Notes (SOAP)
                    </h3>
                </div>

                <div class="p-6 space-y-6">
                    <div class="relative group">
                        <label class="block text-[11px] font-bold text-blue-600 uppercase tracking-wider mb-1.5">Subjective (Patient's Story)</label>
                        <div class="relative flex items-start bg-slate-50 border border-gray-200 rounded-xl focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all overflow-hidden">
                            <textarea @input="resizeTextarea" class="w-full bg-transparent border-0 focus:ring-0 p-4 text-sm text-gray-800 placeholder-gray-400 min-h-[120px] resize-none" placeholder="What is the chief complaint?"></textarea>
                            <button @click="toggleMic('subjective')" :class="activeMic === 'subjective' ? 'text-red-500 animate-pulse' : 'text-gray-400 hover:text-blue-600'" class="p-3 transition self-end">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="relative group">
                        <label class="block text-[11px] font-bold text-emerald-600 uppercase tracking-wider mb-1.5">Objective (Observations)</label>
                        <div class="relative flex items-start bg-slate-50 border border-gray-200 rounded-xl focus-within:border-emerald-500 focus-within:ring-1 focus-within:ring-emerald-500 transition-all overflow-hidden">
                            <textarea @input="resizeTextarea" class="w-full bg-transparent border-0 focus:ring-0 p-4 text-sm text-gray-800 placeholder-gray-400 min-h-[120px] resize-none" placeholder="Physical exam findings..."></textarea>
                            <button @click="toggleMic('objective')" :class="activeMic === 'objective' ? 'text-red-500 animate-pulse' : 'text-gray-400 hover:text-emerald-600'" class="p-3 transition self-end">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="relative group">
                        <label class="block text-[11px] font-bold text-purple-600 uppercase tracking-wider mb-1.5">Assessment (Diagnosis)</label>
                        <div class="relative flex items-start bg-slate-50 border border-gray-200 rounded-xl focus-within:border-purple-500 focus-within:ring-1 focus-within:ring-purple-500 transition-all overflow-hidden">
                            <textarea @input="resizeTextarea" class="w-full bg-transparent border-0 focus:ring-0 p-4 text-sm text-gray-800 placeholder-gray-400 min-h-[100px] resize-none" placeholder="Medical diagnosis..."></textarea>
                            <button @click="toggleMic('assessment')" :class="activeMic === 'assessment' ? 'text-red-500 animate-pulse' : 'text-gray-400 hover:text-purple-600'" class="p-3 transition self-end">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="relative group">
                        <label class="block text-[11px] font-bold text-amber-600 uppercase tracking-wider mb-1.5">Plan (Treatment)</label>
                        <div class="relative flex items-start bg-slate-50 border border-gray-200 rounded-xl focus-within:border-amber-500 focus-within:ring-1 focus-within:ring-amber-500 transition-all overflow-hidden">
                            <textarea @input="resizeTextarea" class="w-full bg-transparent border-0 focus:ring-0 p-4 text-sm text-gray-800 placeholder-gray-400 min-h-[100px] resize-none" placeholder="Next steps and advice..."></textarea>
                            <button @click="toggleMic('plan')" :class="activeMic === 'plan' ? 'text-red-500 animate-pulse' : 'text-gray-400 hover:text-amber-600'" class="p-3 transition self-end">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-visible z-10 relative">
                <div class="p-5 border-b border-gray-100 bg-slate-50/50">
                    <h3 class="text-base font-black text-securx-navy flex items-center gap-2">
                        <span class="bg-blue-600 text-white w-6 h-6 rounded-md flex items-center justify-center text-xs">2</span>
                        Medication & Instructions
                    </h3>
                </div>

                <div class="p-6 flex flex-col gap-5">
                    <div class="relative">
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">RxNorm Smart Search</label>
                        <input @focus="showDropdown = true" @click.away="showDropdown = false" type="text" class="w-full bg-slate-50 border border-gray-200 text-securx-navy text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block pl-12 p-3.5 font-bold shadow-inner" placeholder="Search drug generic or brand name..." value="Amox">
                        <div class="absolute bottom-0 left-0 h-[52px] flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-gray-100 pt-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Dose</label>
                            <input type="text" class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. 1 cap">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Frequency</label>
                            <select class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500">
                                <option>TID (3x a day)</option>
                                <option>BID (2x a day)</option>
                                <option>OD (Once a day)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Duration</label>
                            <input type="text" class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500" placeholder="7 days">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Instructions to Pharmacist</label>
                            <input type="text" class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500 italic placeholder-gray-400" placeholder="e.g. Dispense exact brand only">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Instructions to Patient</label>
                            <input type="text" class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500 italic placeholder-gray-400" placeholder="e.g. Take with a full meal">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button class="w-full bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-600 hover:text-white font-black py-3 px-8 rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add to Prescription
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-visible z-0 relative">
                <div class="p-5 border-b border-gray-100 bg-slate-50/50">
                    <h3 class="text-base font-black text-securx-navy flex items-center gap-2">
                        <span class="bg-blue-600 text-white w-6 h-6 rounded-md flex items-center justify-center text-xs">3</span>
                        Final Details & Sign-off
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    
                    <label class="flex items-center gap-3 cursor-pointer p-4 border border-blue-100 bg-blue-50/50 rounded-xl hover:bg-blue-50 transition">
                        <input type="checkbox" x-model="showPatientName" class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500 border-gray-300 shadow-sm">
                        <div>
                            <span class="block text-sm font-bold text-securx-navy">Print Patient Name on Prescription</span>
                            <span class="block text-[10px] text-gray-500 mt-0.5">Leave unchecked for visual anonymity (Data remains inside encrypted QR)</span>
                        </div>
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">General Rx Instructions</label>
                            <textarea x-model="generalInstructions" class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500 resize-none h-[50px] custom-scrollbar" placeholder="e.g. Avoid strenuous activities..."></textarea>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Next Appointment Date</label>
                            <input type="date" x-model="nextAppointment" class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="w-full lg:w-5/12 xl:w-1/3 sticky top-28">
            
            <div class="flex items-center gap-2 mb-3 px-1">
                <span class="bg-emerald-600 text-white w-6 h-6 rounded-md flex items-center justify-center text-xs font-black">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </span>
                <h3 class="text-base font-black text-securx-navy">Review & Sign</h3>
                <span class="ml-auto text-xs font-bold text-gray-400 uppercase">Live Preview</span>
            </div>

            <div class="bg-white shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 aspect-[1/1.414] relative flex flex-col w-full rounded-sm overflow-hidden">
                
                <div class="h-2 w-full bg-securx-navy shrink-0"></div>

                <div class="p-6 flex-1 flex flex-col relative z-10">
                    
                    <div class="text-center border-b-2 border-gray-800 pb-4 mb-4 flex flex-col items-center">
                        <div class="flex items-center justify-center gap-2">
                            <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo" class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-2 text-[10px] font-serif text-gray-800 mb-4 border-b border-gray-300 pb-3">
                        <div class="col-span-2">
                            <p class="text-[8px] font-bold text-gray-500 uppercase">Name:</p>
                            <p class="font-bold border-b border-gray-300 border-dotted" 
                               :class="!showPatientName ? 'text-gray-400 italic' : 'text-gray-900'"
                               x-text="showPatientName ? 'Maria Clara Reyes' : '______________________'"></p>
                        </div>
                        <div class="col-span-1">
                            <p class="text-[8px] font-bold text-gray-500 uppercase">Age / Sex:</p>
                            <p class="font-bold border-b border-gray-300 border-dotted" 
                               :class="!showPatientName ? 'text-gray-400 italic' : 'text-gray-900'"
                               x-text="showPatientName ? '45/F' : '_________'"></p>
                        </div>
                        <div class="col-span-1">
                            <p class="text-[8px] font-bold text-gray-500 uppercase">Date:</p>
                            <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">{{ date('m/d/Y') }}</p>
                        </div>
                    </div>

                    <div class="mb-2">
                        <span class="text-4xl font-serif font-black text-gray-900 italic tracking-tighter">Rx</span>
                    </div>

                    <div class="flex-1 space-y-4 pl-2 font-serif overflow-y-auto custom-scrollbar pr-2 flex flex-col">
                        
                        <div class="relative group">
                            <button class="absolute -left-2 top-0 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg></button>
                            
                            <p class="text-sm font-bold text-gray-900">1. Losartan Potassium 50mg tab</p>
                            <div class="flex justify-between items-end mt-0.5">
                                <p class="text-xs text-gray-700 italic">Sig: Take 1 tab OD for 30 days.</p>
                                <p class="text-xs font-bold text-gray-900">#30 tabs</p>
                            </div>
                            <p class="text-[9px] text-gray-500 italic mt-0.5 border-l border-gray-300 pl-2 ml-1">To Rx: Exact brand only.</p>
                            <p class="text-[9px] text-blue-600 italic mt-0.5 border-l border-blue-200 pl-2 ml-1">To Pt: Take after breakfast.</p>
                        </div>

                        <div class="flex-1"></div>

                        <div class="pt-3 border-t border-gray-200 border-dashed" x-show="generalInstructions || nextAppointment" style="display: none;">
                            <div x-show="generalInstructions" class="mb-2">
                                <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Additional Instructions:</p>
                                <p class="text-[11px] font-serif text-gray-800 mt-0.5 italic" x-text="generalInstructions"></p>
                            </div>
                            <div x-show="nextAppointment">
                                <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Next Appointment:</p>
                                <p class="text-[11px] font-serif text-gray-900 mt-0.5 font-bold" x-text="nextAppointment"></p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2 border-t border-gray-100 shrink-0">
                        <div class="flex justify-between items-end">
                            
                            <div class="w-16 h-16 bg-gray-50 border border-gray-200 flex flex-col items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                <span class="text-[6px] text-gray-400 mt-1 font-sans">QR PENDING</span>
                            </div>

                            <div class="text-left w-48 ml-auto">
                                <div class="border-b border-gray-800 h-10 relative mb-1">
                                    <p class="font-[Brush_Script_MT,cursive] text-3xl text-blue-900 absolute bottom-1 w-full text-center opacity-80 -rotate-3">R. Santos</p>
                                </div>
                                <p class="text-xs font-serif font-black text-gray-900 uppercase">DR. ROBERTO SANTOS, MD</p>
                                <p class="text-[9px] font-serif text-gray-600 mt-0.5">License Num: 0019283</p>
                                <p class="text-[9px] font-serif text-gray-600">PTR: 99120</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <button class="w-full mt-4 bg-securx-navy hover:bg-blue-700 text-white font-black py-4 px-4 rounded-xl transition-all duration-300 shadow-lg flex items-center justify-center gap-2 text-sm">
                <svg class="w-5 h-5 text-securx-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Sign & Generate SecuRx
            </button>
        </div>
    </div>

    <div x-show="showRecordsDrawer || showTemplatesDrawer || showDurDrawer" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40" x-transition.opacity @click="closeAllDrawers()" style="display: none;"></div>

    <div x-show="showDurDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-sm bg-white shadow-2xl flex flex-col border-l border-amber-200"
         x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" style="display: none;">
        <div class="px-6 py-4 bg-amber-50 border-b border-amber-200 flex justify-between items-center">
            <h2 class="text-lg font-black text-amber-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                DUR Safety Alerts
            </h2>
            <button @click="showDurDrawer = false" class="text-amber-600 hover:text-red-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <div class="p-6 overflow-y-auto">
            <div class="bg-white border border-red-200 rounded-xl p-4 shadow-sm relative">
                <div class="absolute top-0 left-0 w-1 h-full bg-red-500 rounded-l-xl"></div>
                <p class="text-xs font-bold text-red-600 uppercase mb-1">Known Allergy</p>
                <p class="text-sm text-gray-700 font-medium">Patient has a verified allergy to <span class="font-bold text-red-600">Penicillin</span>. System will block Beta-lactam entries.</p>
            </div>
        </div>
    </div>

    <div x-show="showTemplatesDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-sm bg-white shadow-2xl flex flex-col border-l border-gray-200"
         x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" style="display: none;">
        <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-black text-securx-navy">Select a Template</h2>
            <button @click="showTemplatesDrawer = false" class="text-gray-400 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <div class="p-4 overflow-y-auto space-y-3">
            <button class="w-full text-left bg-white border border-gray-200 p-4 rounded-xl hover:border-blue-500 hover:shadow-md transition group">
                <p class="font-bold text-securx-navy group-hover:text-blue-600">Normal URI (Cold/Flu)</p>
                <p class="text-xs text-gray-500 mt-1 line-clamp-1">Fills S.O.A.P for uncomplicated viral upper respiratory infection.</p>
            </button>
            <button class="w-full text-left bg-white border border-gray-200 p-4 rounded-xl hover:border-blue-500 hover:shadow-md transition group">
                <p class="font-bold text-securx-navy group-hover:text-blue-600">HTN Follow-up</p>
                <p class="text-xs text-gray-500 mt-1 line-clamp-1">Standard checkup for controlled Essential Hypertension.</p>
            </button>
        </div>
    </div>

    <div x-show="showRecordsDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-2xl bg-slate-50 shadow-2xl flex flex-col border-l border-gray-200"
         x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" style="display: none;">
         <div class="px-6 py-4 bg-white border-b border-gray-200 flex justify-between items-center">
             <h2 class="text-xl font-black text-securx-navy">Medical Records</h2>
             <button @click="showRecordsDrawer = false" class="text-gray-400 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
         </div>
         <div class="flex-1 p-6 flex items-center justify-center text-gray-400 italic">
             (Records Timeline loads here)
         </div>
    </div>

</div>


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('consultationConsole', () => ({
            activeMic: null,
            showRecordsDrawer: false,
            showTemplatesDrawer: false,
            showDurDrawer: false,
            
            // New State Variables
            showPatientName: false,
            nextAppointment: '',
            generalInstructions: '',
            
            toggleMic(section) {
                this.activeMic = (this.activeMic === section) ? null : section;
            },

            closeAllDrawers() {
                this.showRecordsDrawer = false;
                this.showTemplatesDrawer = false;
                this.showDurDrawer = false;
            },

            resizeTextarea(e) {
                let el = e.target;
                el.style.height = 'auto';
                el.style.height = el.scrollHeight + 'px';
            }
        }))
    })
</script>

@endsection
