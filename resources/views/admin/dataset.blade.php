@extends('layouts.admin')

@section('page_title', 'Dataset Management')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 relative">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden flex justify-between items-center">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1">Dataset Management</h1>
            <p class="text-gray-600 font-medium text-sm">Upload bulk CSV datasets or search and edit the current clinical database.</p>
        </div>
        <div class="hidden md:block">
            <span class="px-4 py-2 bg-securx-cyan/10 text-securx-cyan font-bold text-xs rounded-full border border-securx-cyan/20">
                Total Records: {{ \App\Models\Medication::count() }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="glass-panel p-4 bg-green-50/80 border border-green-200 text-green-700 rounded-xl shadow-sm flex items-center gap-3">
            <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <span class="font-bold block text-sm">Success!</span> 
                <span class="text-sm">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="glass-panel p-4 bg-red-50/80 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <span class="font-bold text-sm block mb-1">Please fix the following issues:</span>
            <ul class="list-disc ml-5 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-panel p-8 bg-white/80 flex flex-col justify-center border-t-4 border-t-securx-cyan md:col-span-2">
            <form action="{{ route('admin.dataset.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="dataset-upload-form">
                @csrf
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-securx-cyan border-dashed rounded-xl cursor-pointer bg-securx-cyan/5 hover:bg-securx-cyan/10 transition group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-securx-cyan group-hover:scale-110 transition-transform" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-1 text-sm text-gray-600"><span class="font-bold text-securx-navy">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 font-medium">Valid formats: .CSV only</p>
                        </div>
                        <input id="dropzone-file" type="file" name="dataset" class="hidden" accept=".csv" required />
                    </label>
                </div>
                <p id="file-name-display" class="text-sm font-bold text-center text-securx-cyan hidden p-2 bg-securx-cyan/10 rounded-lg"></p>
                <button type="submit" class="w-full py-3 px-4 bg-securx-cyan hover:bg-securx-navy text-white font-bold rounded-xl shadow-md transition-colors flex justify-center items-center gap-2">
                    Initialize Import Pipeline
                </button>
            </form>
        </div>

        <div class="glass-panel p-6 bg-white/60">
            <h3 class="text-sm font-bold text-securx-navy mb-3 border-b border-gray-200/60 pb-2">Formatting Requirements</h3>
            <ol class="space-y-2 text-xs text-gray-700 font-medium mb-4">
                <li class="flex items-start gap-2">
                    <span class="text-securx-cyan font-bold">1.</span>
                    <div><strong class="text-securx-navy block">Generic Name</strong> "Paracetamol"</div>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-securx-cyan font-bold">2.</span>
                    <div><strong class="text-securx-navy block">Form</strong> "Tablet"</div>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-securx-cyan font-bold">3.</span>
                    <div><strong class="text-securx-navy block">Strength</strong> "500mg"</div>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-securx-cyan font-bold">4.</span>
                    <div><strong class="text-securx-navy block">Estimated Price</strong> "5.00"</div>
                </li>
            </ol>
            <div class="p-3 bg-securx-gold/10 rounded-lg border border-securx-gold/20">
                <p class="text-xs text-securx-gold font-bold mb-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Smart Overwrite Active
                </p>
                <p class="text-[10px] text-gray-600">Existing drugs with the same Name and Form will simply have their price/strength updated.</p>
            </div>
        </div>
    </div>

    <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-t-4 border-t-securx-navy shadow-sm">
        
        <div class="p-4 border-b border-gray-200/60 bg-gray-50/90 backdrop-blur-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-securx-navy">Current Inventory</h2>
            
            <div class="relative w-full md:w-96">
                <input type="text" id="live-search" value="{{ $search ?? '' }}" placeholder="Live search by name or form..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-securx-cyan focus:border-securx-cyan text-sm transition-shadow">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <div id="search-spinner" class="absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                    <svg class="animate-spin h-4 w-4 text-securx-cyan" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>

        <div id="table-wrapper">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr class="text-xs text-gray-500 uppercase tracking-wider">
                            <th class="p-4 font-bold border-b border-gray-200/60">Generic Name</th>
                            <th class="p-4 font-bold border-b border-gray-200/60">Form</th>
                            <th class="p-4 font-bold border-b border-gray-200/60">Dosage Strength</th>
                            <th class="p-4 font-bold border-b border-gray-200/60">Estimated Price</th>
                            <th class="p-4 font-bold border-b border-gray-200/60 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                        @forelse($medications as $med)
                        <tr class="hover:bg-white/60 transition group">
                            <td class="p-4 font-bold text-securx-navy">{{ $med->generic_name }}</td>
                            <td class="p-4 font-medium text-gray-600">{{ $med->form }}</td>
                            <td class="p-4 text-gray-500">{{ $med->dosage_strength }}</td>
                            <td class="p-4 font-bold text-securx-cyan">₱{{ number_format($med->estimated_price, 2) }}</td>
                            <td class="p-4 text-right">
                                <button type="button" 
                                    onclick="openEditModal('{{ $med->id }}', '{{ addslashes($med->generic_name) }}', '{{ addslashes($med->form) }}', '{{ addslashes($med->dosage_strength) }}', '{{ $med->estimated_price }}')"
                                    class="text-xs font-bold px-3 py-1.5 bg-gray-100 hover:bg-securx-cyan hover:text-white text-gray-600 rounded-lg transition-colors">
                                    Edit
                                </button>
                                <button type="button" 
                                    onclick="openDeleteModal('{{ $med->id }}', '{{ addslashes($med->generic_name) }}')"
                                    class="text-xs font-bold px-3 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 rounded-lg transition-colors">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400 font-medium">
                                <svg class="w-12 h-12 text-gray-300 mb-3 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                @if($search)
                                    No medications found matching "{{ $search }}".
                                @else
                                    No medications found in the database. Please upload a dataset above.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($medications->hasPages())
            <div class="p-4 border-t border-gray-200/60 bg-white/50 flex justify-between items-center">
                {{ $medications->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<div id="edit-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-securx-navy">Edit Medication Details</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form id="edit-form" method="POST" action="" class="p-6 space-y-4">
            @csrf
            @method('PATCH')
            
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Generic Name</label>
                <input type="text" id="edit-name" name="generic_name" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan">
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Form</label>
                    <input type="text" id="edit-form-input" name="form" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Strength</label>
                    <input type="text" id="edit-strength" name="dosage_strength" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Estimated Price (₱)</label>
                <input type="number" step="0.01" id="edit-price" name="estimated_price" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeEditModal()" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-securx-cyan text-white font-bold rounded-xl hover:bg-securx-navy transition-colors shadow-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div> <div id="delete-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden transform transition-all text-center p-6">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-securx-navy mb-2">Archive Medication?</h3>
        <p class="text-sm text-gray-500 mb-6">Are you sure you want to remove <strong id="delete-drug-name" class="text-gray-800"></strong> from the active inventory? Existing patient prescriptions will not be affected.</p>
        
        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">Yes, Archive It</button>
            </div>
        </form>
    </div>
</div>

@endsection