@extends('layouts.patient')

@section('page_title', 'Clinical Record')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-6 py-4 rounded-xl shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="p-6 bg-slate-800 border border-slate-700 rounded-2xl shadow-xl flex items-center gap-5 text-slate-200 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-securx-cyan/5 rounded-bl-full pointer-events-none"></div>

            <div class="w-14 h-14 bg-securx-cyan/10 rounded-full flex items-center justify-center text-securx-cyan border border-securx-cyan/20 flex-shrink-0 relative z-10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="relative z-10">
                <h2 class="text-2xl font-extrabold text-white tracking-tight">Comprehensive Medical Record</h2>
                <p class="text-sm text-slate-400 mt-1 max-w-2xl">
                    Maintain your baseline clinical data here. This information powers the SecuRx Intelligence Module to alert pharmacists of potential contraindications.
                </p>
            </div>
        </div>

        <div class="flex overflow-x-auto border-b border-slate-300 pb-px hide-scrollbar">
            <button onclick="window.switchTab('encounters')" id="tab-encounters" class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-securx-cyan text-securx-cyan whitespace-nowrap transition-colors">Clinical Encounters</button>
            <button onclick="window.switchTab('allergies')" id="tab-allergies" class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap transition-colors">Allergies & Reactions</button>
            <button onclick="window.switchTab('immunizations')" id="tab-immunizations" class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap transition-colors">Immunizations</button>
            <button onclick="window.switchTab('labs')" id="tab-labs" class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap transition-colors">Lab Results</button>
            <button onclick="window.switchTab('documents')" id="tab-documents" class="tab-btn px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap transition-colors">Documents</button>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg min-h-[500px]">

            <div id="content-allergies" class="tab-content hidden space-y-4">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-700">
                    <div>
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span> Known Allergies
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">Logged allergies are cross-referenced with RxNorm during prescribing.</p>
                    </div>
                    <button onclick="window.openModal('modal-allergy')" class="text-xs bg-slate-700 hover:bg-slate-600 border border-slate-500 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        Report New Allergy
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    @forelse($allergies as $allergy)
                        <div class="p-5 bg-slate-900/40 border border-slate-700 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-400 shrink-0 mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <p class="font-bold text-white text-lg">{{ $allergy->allergen_name }}</p>
                                        <span class="px-2.5 py-0.5 bg-orange-500/20 text-orange-300 text-[10px] font-bold rounded border border-orange-500/20 uppercase tracking-wider">{{ $allergy->severity }}</span>
                                    </div>
                                    <p class="text-sm text-slate-300">Reaction: {{ $allergy->reaction }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                @if($allergy->is_verified)
                                    <span class="text-[10px] bg-green-500/10 text-green-400 border border-green-500/20 px-2.5 py-1 rounded font-bold uppercase tracking-wider flex items-center gap-1.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Clinically Verified
                                    </span>
                                @else
                                    <span class="text-[10px] bg-securx-gold/10 text-securx-gold border border-securx-gold/20 px-2.5 py-1 rounded font-bold uppercase tracking-wider flex items-center gap-1.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Pending Doctor Review
                                    </span>
                                @endif
                                <p class="text-xs text-slate-500">Reported {{ $allergy->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm text-center py-6">No allergies recorded.</p>
                    @endforelse
                </div>
                <div class="mt-4">{{ $allergies->links() }}</div>
            </div>

            <div id="content-immunizations" class="tab-content hidden space-y-4">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-700">
                    <h3 class="text-lg font-bold text-white">Vaccination History</h3>
                    <button onclick="window.openModal('modal-immunization')" class="text-xs bg-slate-700 hover:bg-slate-600 border border-slate-500 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        + Log Vaccine
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @forelse($immunizations as $imm)
                        <div class="p-5 bg-slate-900/60 border border-slate-700/50 rounded-xl relative overflow-hidden">
                            @if($imm->is_verified)
                                <div class="absolute top-0 right-0 bg-green-500/20 px-3 py-1 rounded-bl-lg border-b border-l border-green-500/20">
                                    <span class="text-[10px] font-bold text-green-400 uppercase tracking-wider">Verified</span>
                                </div>
                            @else
                                <div class="absolute top-0 right-0 bg-securx-gold/10 px-3 py-1 rounded-bl-lg border-b border-l border-securx-gold/20">
                                    <span class="text-[10px] font-bold text-securx-gold uppercase tracking-wider">Pending Review</span>
                                </div>
                            @endif
                            <p class="font-bold text-white text-lg mb-2 mt-1">{{ $imm->vaccine_name }}</p>
                            <div class="space-y-1">
                                <p class="text-sm text-slate-300"><span class="text-slate-500 mr-2">Administered:</span> {{ \Carbon\Carbon::parse($imm->administered_date)->format('M d, Y') }}</p>
                                <p class="text-sm text-slate-300"><span class="text-slate-500 mr-2">Facility:</span> {{ $imm->facility }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm text-center py-6 col-span-2">No immunizations recorded.</p>
                    @endforelse
                </div>
                <div class="mt-4">{{ $immunizations->links() }}</div>
            </div>

            <div id="content-labs" class="tab-content hidden space-y-4">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-700">
                    <h3 class="text-lg font-bold text-white">Laboratory Diagnostics</h3>
                    <button onclick="window.openModal('modal-lab')" class="text-xs bg-slate-700 hover:bg-slate-600 border border-slate-500 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Upload PDF
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-3">
                    @forelse($labs as $lab)
                        <div class="p-4 bg-slate-900/60 border border-slate-700/50 rounded-xl flex justify-between items-center hover:bg-slate-800 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-800 border border-slate-600 rounded-xl flex items-center justify-center text-red-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3">
                                        <p class="font-bold text-white text-base">{{ $lab->test_name }}</p>
                                        @if($lab->is_verified)
                                            <span class="text-[10px] bg-green-500/10 text-green-400 border border-green-500/20 px-1.5 py-0.5 rounded font-bold uppercase">Verified</span>
                                        @else
                                            <span class="text-[10px] bg-securx-gold/10 text-securx-gold border border-securx-gold/20 px-1.5 py-0.5 rounded font-bold uppercase">Pending Review</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Uploaded {{ $lab->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('patient.file.view', ['path' => $lab->file_path]) }}" target="_blank" class="text-securx-cyan text-sm font-bold hover:text-cyan-300 transition-colors bg-securx-cyan/10 px-4 py-2 rounded-lg">View File</a>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm text-center py-6">No lab results uploaded.</p>
                    @endforelse
                </div>
                <div class="mt-4">{{ $labs->links() }}</div>
            </div>

            <div id="content-documents" class="tab-content hidden space-y-4">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-700">
                    <h3 class="text-lg font-bold text-white">Medical Certificates & Files</h3>
                    <button onclick="window.openModal('modal-document')" class="text-xs bg-slate-700 hover:bg-slate-600 border border-slate-500 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Upload Document
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($documents as $doc)
                        <div class="p-4 bg-slate-900/60 border border-slate-700/50 rounded-xl flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="font-bold text-white">{{ $doc->document_name }}</p>
                                    @if($doc->is_verified)
                                        <span class="text-[10px] bg-green-500/10 text-green-400 px-1.5 py-0.5 rounded font-bold uppercase border border-green-500/20">Verified</span>
                                    @else
                                        <span class="text-[10px] bg-securx-gold/10 text-securx-gold px-1.5 py-0.5 rounded font-bold uppercase border border-securx-gold/20">Pending</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-400 mt-1">Uploaded {{ $doc->created_at->format('M Y') }}</p>
                            </div>
                            <a href="{{ route('patient.file.view', ['path' => $doc->file_path]) }}" target="_blank" class="text-slate-400 hover:text-securx-cyan transition-colors" title="View Document">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm text-center py-6 col-span-2">No documents uploaded.</p>
                    @endforelse
                </div>
                <div class="mt-4">{{ $documents->links() }}</div>
            </div>

            <div id="content-encounters" class="tab-content block space-y-4">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-700">
                    <div>
                        <h3 class="text-lg font-bold text-white">Recent Visits</h3>
                        <p class="text-xs text-slate-400">Clinical notes generated by your verified physicians.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    @forelse($encounters as $encounter)
                        <div class="p-5 bg-slate-900/60 border border-slate-700/50 rounded-xl shadow-sm hover:border-securx-cyan/30 transition-colors">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="font-bold text-white text-lg">Consultation with Dr. {{ $encounter->doctor->last_name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-slate-400">{{ $encounter->created_at->format('F d, Y - h:i A') }}</p>
                                </div>
                                <span class="text-[10px] bg-securx-cyan/10 text-securx-cyan border border-securx-cyan/20 px-2.5 py-1 rounded font-bold uppercase tracking-wider flex items-center gap-1.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Completed
                                </span>
                            </div>
                            
                            <div class="bg-slate-800/80 p-4 rounded-lg border border-slate-700/50 mt-3">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-slate-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-sm text-slate-300">
                                        <span class="text-slate-400 font-bold mr-1">Diagnosis / Notes:</span> 
                                        {{ $encounter->diagnosis ?? $encounter->notes ?? 'Clinical details are confidential or pending synchronization.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 text-center bg-slate-900/30 rounded-xl border border-dashed border-slate-700">
                            <div class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center text-slate-500 mb-4 border border-slate-700">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h4 class="text-white font-bold mb-1">No Clinical Encounters</h4>
                            <p class="text-slate-400 text-sm max-w-sm">Your visit history will appear here once a verified physician completes your consultation.</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-4">{{ $encounters->links() }}</div>
            </div>

        </div>
    </div>

    <div id="modal-allergy" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm hidden z-50 flex items-center justify-center">
        <div class="bg-slate-800 border border-slate-700 p-6 rounded-2xl w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold text-white mb-4">Report New Allergy</h3>
            <form action="{{ route('patient.allergies.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Allergen / Medication Name</label>
                    <input type="text" name="allergen_name" required class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white px-4 py-2 focus:border-securx-cyan outline-none">
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Reaction</label>
                    <input type="text" name="reaction" placeholder="e.g. Hives, shortness of breath" required class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white px-4 py-2 focus:border-securx-cyan outline-none">
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Severity</label>
                    <select name="severity" required class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white px-4 py-2 focus:border-securx-cyan outline-none">
                        <option value="Low">Low Severity</option>
                        <option value="Medium">Medium Severity</option>
                        <option value="High Severity">High Severity</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="window.closeModal('modal-allergy')" class="px-4 py-2 text-slate-400 hover:text-white">Cancel</button>
                    <button type="submit" class="bg-securx-cyan text-white px-4 py-2 rounded-lg font-bold hover:bg-cyan-600">Save Allergy</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-immunization" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm hidden z-50 flex items-center justify-center">
        <div class="bg-slate-800 border border-slate-700 p-6 rounded-2xl w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold text-white mb-4">Log Vaccination</h3>
            <form action="{{ route('patient.immunizations.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Vaccine Name</label>
                    <input type="text" name="vaccine_name" required class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white px-4 py-2 focus:border-securx-cyan outline-none">
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Date Administered</label>
                    <input type="date" name="administered_date" required 
                            min="{{ now()->subYears(100)->format('Y-m-d') }}" 
                            max="{{ now()->format('Y-m-d') }}" 
                            class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white px-4 py-2 focus:border-securx-cyan outline-none">
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Facility / Clinic Name</label>
                    <input type="text" name="facility" required class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white px-4 py-2 focus:border-securx-cyan outline-none">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="window.closeModal('modal-immunization')" class="px-4 py-2 text-slate-400 hover:text-white">Cancel</button>
                    <button type="submit" class="bg-securx-cyan text-white px-4 py-2 rounded-lg font-bold hover:bg-cyan-600">Save Vaccine</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-lab" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm hidden z-50 flex items-center justify-center">
        <div class="bg-slate-800 border border-slate-700 p-6 rounded-2xl w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold text-white mb-4">Upload Lab Result</h3>
            <form action="{{ route('patient.labs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Test Name (e.g., Blood Test)</label>
                    <input type="text" name="test_name" required class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white px-4 py-2 focus:border-securx-cyan outline-none">
                </div>
                
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Date of Test</label>
                    <input type="date" name="test_date" required 
                            min="{{ now()->subYears(100)->format('Y-m-d') }}" 
                            max="{{ now()->format('Y-m-d') }}" 
                            class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white px-4 py-2 focus:border-securx-cyan outline-none">
                </div>

                <div>
                    <label class="block text-sm text-slate-400 mb-1">File (PDF, JPG, PNG)</label>
                    <input type="file" name="lab_file" accept=".pdf,.jpg,.jpeg,.png" required class="w-full bg-slate-900 border border-slate-600 rounded-lg text-slate-400 px-4 py-2 focus:border-securx-cyan outline-none">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="window.closeModal('modal-lab')" class="px-4 py-2 text-slate-400 hover:text-white">Cancel</button>
                    <button type="submit" class="bg-securx-cyan text-white px-4 py-2 rounded-lg font-bold hover:bg-cyan-600">Upload Lab</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-document" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm hidden z-50 flex items-center justify-center">
        <div class="bg-slate-800 border border-slate-700 p-6 rounded-2xl w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold text-white mb-4">Upload Medical Document</h3>
            <form action="{{ route('patient.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Document Name (e.g., Fit to Work)</label>
                    <input type="text" name="document_name" required class="w-full bg-slate-900 border border-slate-600 rounded-lg text-white px-4 py-2 focus:border-securx-cyan outline-none">
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">File (PDF, JPG, PNG)</label>
                    <input type="file" name="document_file" accept=".pdf,.jpg,.jpeg,.png" required class="w-full bg-slate-900 border border-slate-600 rounded-lg text-slate-400 px-4 py-2 focus:border-securx-cyan outline-none">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="window.closeModal('modal-document')" class="px-4 py-2 text-slate-400 hover:text-white">Cancel</button>
                    <button type="submit" class="bg-securx-cyan text-white px-4 py-2 rounded-lg font-bold hover:bg-cyan-600">Upload Document</button>
                </div>
            </form>
        </div>
    </div>

    @vite(['resources/js/medical-profile.js'])

@endsection