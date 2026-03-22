@extends('layouts.patient')

@section('page_title', 'Clinical Record')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        <div class="p-6 bg-slate-800 border border-slate-700 rounded-2xl shadow-lg flex items-center gap-5 text-slate-200">
            <div
                class="w-14 h-14 bg-securx-cyan/10 rounded-full flex items-center justify-center text-securx-cyan border border-securx-cyan/20 flex-shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-white tracking-tight">Comprehensive Medical Record</h2>
                <p class="text-sm text-slate-400 mt-1">
                    Maintain your baseline clinical data here. This information powers the SecuRx Intelligence Module to
                    alert pharmacists of potential contraindications.
                </p>
            </div>
        </div>

        <div class="flex overflow-x-auto border-b border-slate-300 pb-px hide-scrollbar">
            <button onclick="switchTab('encounters')" id="tab-encounters"
                class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-securx-cyan text-securx-cyan whitespace-nowrap transition-colors">
                Clinical Encounters
            </button>
            <button onclick="switchTab('allergies')" id="tab-allergies"
                class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap transition-colors">
                Allergies & Reactions
            </button>
            <button onclick="switchTab('immunizations')" id="tab-immunizations"
                class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap transition-colors">
                Immunizations
            </button>
            <button onclick="switchTab('labs')" id="tab-labs"
                class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap transition-colors">
                Lab Results
            </button>
            <button onclick="switchTab('documents')" id="tab-documents"
                class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap transition-colors">
                Documents
            </button>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg min-h-[400px]">

            <div id="content-encounters" class="tab-content block space-y-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-white">Recent Visits</h3>
                    <button
                        class="text-xs bg-slate-700 hover:bg-slate-600 border border-slate-600 text-white font-bold py-1.5 px-3 rounded-md transition-colors">+
                        Log Encounter</button>
                </div>

                <div class="p-4 bg-slate-900/50 border border-slate-700/50 rounded-xl">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-bold text-securx-cyan">General Consultation</p>
                            <p class="text-xs text-slate-400">Dr. Santos • Angeles Medical Center</p>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">Oct 24, 2026</span>
                    </div>
                    <p class="text-sm text-slate-300 mt-2">Patient presented with acute bronchitis symptoms. Prescribed
                        Amoxicillin and advised rest.</p>
                </div>
            </div>

            <div id="content-allergies" class="tab-content hidden space-y-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-400"></span> Known Allergies
                    </h3>
                    <button
                        class="text-xs bg-slate-700 hover:bg-slate-600 border border-slate-600 text-white font-bold py-1.5 px-3 rounded-md transition-colors">+
                        Add Allergy</button>
                </div>

                <div class="p-4 bg-red-900/20 border border-red-500/30 rounded-xl flex justify-between items-center">
                    <div>
                        <p class="font-bold text-red-400">Penicillin</p>
                        <p class="text-xs text-slate-400">Reaction: Severe Hives / Anaphylaxis risk</p>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-red-500/20 text-red-300 text-xs font-bold rounded-full border border-red-500/20">High
                        Severity</span>
                </div>
            </div>

            <div id="content-immunizations" class="tab-content hidden space-y-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-white">Vaccination History</h3>
                    <button
                        class="text-xs bg-slate-700 hover:bg-slate-600 border border-slate-600 text-white font-bold py-1.5 px-3 rounded-md transition-colors">+
                        Add Record</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-900/50 border border-slate-700/50 rounded-xl">
                        <p class="font-bold text-white mb-1">Influenza (Flu)</p>
                        <p class="text-xs text-slate-400">Administered: Nov 01, 2025</p>
                        <p class="text-xs text-slate-500 mt-1">Facility: AUF Medical Center</p>
                    </div>
                    <div class="p-4 bg-slate-900/50 border border-slate-700/50 rounded-xl">
                        <p class="font-bold text-white mb-1">Tetanus Booster</p>
                        <p class="text-xs text-slate-400">Administered: May 12, 2023</p>
                        <p class="text-xs text-slate-500 mt-1">Valid until: May 2033</p>
                    </div>
                </div>
            </div>

            <div id="content-labs" class="tab-content hidden space-y-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-white">Laboratory Diagnostics</h3>
                    <button
                        class="text-xs bg-slate-700 hover:bg-slate-600 border border-slate-600 text-white font-bold py-1.5 px-3 rounded-md transition-colors">+
                        Upload Lab File</button>
                </div>

                <div class="p-4 bg-slate-900/50 border border-slate-700/50 rounded-xl flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-slate-800 border border-slate-600 rounded-lg flex items-center justify-center text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-white">Complete Blood Count (CBC)</p>
                            <p class="text-xs text-slate-400">Tested on Oct 20, 2026</p>
                        </div>
                    </div>
                    <button class="text-securx-cyan text-sm font-bold hover:text-cyan-400 transition-colors">View
                        PDF</button>
                </div>
            </div>

            <div id="content-documents" class="tab-content hidden space-y-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-white">Medical Certificates & Files</h3>
                    <button
                        class="text-xs bg-slate-700 hover:bg-slate-600 border border-slate-600 text-white font-bold py-1.5 px-3 rounded-md transition-colors">+
                        Upload Document</button>
                </div>

                <div class="text-center py-10">
                    <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <p class="text-slate-400 font-medium">No documents uploaded yet.</p>
                </div>
            </div>

        </div>
    </div>

    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.remove('block');
                el.classList.add('hidden');
            });

            document.getElementById('content-' + tabId).classList.remove('hidden');
            document.getElementById('content-' + tabId).classList.add('block');

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-securx-cyan', 'text-securx-cyan');
                btn.classList.add('border-transparent', 'text-slate-500');
            });

            const activeBtn = document.getElementById('tab-' + tabId);
            activeBtn.classList.remove('border-transparent', 'text-slate-500');
            activeBtn.classList.add('border-securx-cyan', 'text-securx-cyan');
        }
    </script>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection
