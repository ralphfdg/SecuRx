@extends('layouts.admin')

@section('page_title', 'Dataset Import Engine')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1">Dataset Import Engine</h1>
            <p class="text-gray-600 font-medium text-sm">Upload bulk CSV datasets to automatically synchronize the clinical database.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="glass-panel p-8 bg-white/80 flex flex-col justify-center border-t-4 border-t-securx-cyan">
            <form action="{{ route('admin.dataset.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="dataset-upload-form">
                @csrf
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-securx-cyan border-dashed rounded-xl cursor-pointer bg-securx-cyan/5 hover:bg-securx-cyan/10 transition group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-securx-cyan group-hover:scale-110 transition-transform" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-600"><span class="font-bold text-securx-navy">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 font-medium">Valid formats: .CSV only (Max 10MB)</p>
                        </div>
                        <input id="dropzone-file" type="file" name="dataset" class="hidden" accept=".csv" required />
                    </label>
                </div>
                
                <p id="file-name-display" class="text-sm font-bold text-center text-securx-cyan hidden p-2 bg-securx-cyan/10 rounded-lg"></p>

                <button type="submit" class="w-full py-3.5 px-4 bg-securx-cyan hover:bg-securx-navy text-white font-bold rounded-xl shadow-md transition-colors flex justify-center items-center gap-2">
                    Initialize Import Pipeline
                </button>
            </form>
        </div>

        <div class="glass-panel p-8 bg-white/60">
            <h3 class="text-lg font-bold text-securx-navy mb-4 border-b border-gray-200/60 pb-2">Formatting Requirements</h3>
            <p class="text-sm text-gray-600 mb-4">Your CSV file must include headers in the first row. The system expects exactly four columns in the following order:</p>
            
            <ol class="space-y-3 text-sm text-gray-700 font-medium mb-6">
                <li class="flex items-start gap-2">
                    <span class="w-6 h-6 rounded bg-securx-cyan/20 text-securx-cyan flex items-center justify-center font-bold text-xs shrink-0">1</span>
                    <div><strong class="text-securx-navy block">Generic Name</strong> e.g., "Paracetamol" or "Amoxicillin"</div>
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-6 h-6 rounded bg-securx-cyan/20 text-securx-cyan flex items-center justify-center font-bold text-xs shrink-0">2</span>
                    <div><strong class="text-securx-navy block">Form</strong> e.g., "Tablet", "Syrup", "Capsule"</div>
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-6 h-6 rounded bg-securx-cyan/20 text-securx-cyan flex items-center justify-center font-bold text-xs shrink-0">3</span>
                    <div><strong class="text-securx-navy block">Strength</strong> e.g., "500mg", "250mg/5ml"</div>
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-6 h-6 rounded bg-securx-cyan/20 text-securx-cyan flex items-center justify-center font-bold text-xs shrink-0">4</span>
                    <div><strong class="text-securx-navy block">Estimated Price</strong> e.g., "5.00" (Numerical values only)</div>
                </li>
            </ol>

            <div class="p-4 bg-securx-gold/10 rounded-lg border border-securx-gold/20">
                <p class="text-xs text-securx-gold font-bold mb-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Smart Overwrite
                </p>
                <p class="text-xs text-gray-600">If a drug with the same Name and Form already exists, the system will update its Strength and Price without duplicating the record.</p>
            </div>
        </div>

    </div>
</div>
@endsection