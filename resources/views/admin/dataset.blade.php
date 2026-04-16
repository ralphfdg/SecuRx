@extends('layouts.admin')

@section('page_title', 'Dataset Management')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 relative">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-4 rounded-2xl shadow-sm border border-gray-100">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1">Dataset Management</h1>
            <p class="text-gray-600 font-medium text-sm">Search the active clinical database or import new datasets.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 relative z-10">
            <button onclick="openImportMedModal()" class="px-4 py-2.5 bg-securx-cyan/10 hover:bg-securx-cyan text-securx-cyan hover:text-white font-bold text-sm rounded-xl border border-securx-cyan/20 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Import Medications
            </button>
            <button onclick="openImportDpriModal()" class="px-4 py-2.5 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white font-bold text-sm rounded-xl border border-blue-200 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Import DPRI Index
            </button>
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

    <div class="border-b border-gray-200/60 mt-4 px-2">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button onclick="switchTab('med-tab')" id="btn-med-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                Medication Inventory
                <span class="bg-gray-100 text-gray-600 py-0.5 px-2 rounded-full text-xs">{{ \App\Models\Medication::count() }}</span>
            </button>
            <button onclick="switchTab('dpri-tab')" id="btn-dpri-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                DOH DPRI Registry
                <span class="bg-gray-100 text-gray-600 py-0.5 px-2 rounded-full text-xs">{{ \App\Models\DpriRecord::count() }}</span>
            </button>
        </nav>
    </div>

    <div id="med-tab" class="tab-content hidden space-y-4">
        <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-t-4 border-t-securx-cyan shadow-sm rounded-2xl">
            <div class="p-4 border-b border-gray-200/60 bg-gray-50/90 backdrop-blur-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-lg font-bold text-securx-navy">Active Masterlist</h2>
                <form method="GET" action="{{ route('admin.dataset') }}" class="relative w-full md:w-96">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search medications..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-securx-cyan focus:border-securx-cyan text-sm transition-shadow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>

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
                            <td class="p-4 text-right whitespace-nowrap">
                                <button type="button" onclick="openEditModal('{{ $med->id }}', '{{ addslashes($med->generic_name) }}', '{{ addslashes($med->form) }}', '{{ addslashes($med->dosage_strength) }}', '{{ $med->estimated_price }}')" class="text-xs font-bold px-3 py-1.5 bg-gray-100 hover:bg-securx-cyan hover:text-white text-gray-600 rounded-lg transition-colors">Edit</button>
                                <button type="button" onclick="openDeleteModal('{{ $med->id }}', '{{ addslashes($med->generic_name) }}')" class="text-xs font-bold px-3 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 rounded-lg transition-colors ml-1">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400 font-medium">No medications found matching your criteria.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($medications) && $medications->hasPages())
            <div class="p-4 border-t border-gray-200/60 bg-white/50">
                {{ $medications->appends(['dpri_page' => request('dpri_page'), 'search' => request('search')])->links() }}
            </div>
            @endif
        </div>
    </div>

    <div id="dpri-tab" class="tab-content hidden space-y-4">
        <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-t-4 border-t-blue-500 shadow-sm rounded-2xl">
            <div class="p-4 border-b border-gray-200/60 bg-blue-50/50 backdrop-blur-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h2 class="text-lg font-bold text-blue-900">Mandated DPRI Pricing</h2>
                <form method="GET" action="{{ route('admin.dataset') }}" class="relative w-full md:w-96">
                    <input type="hidden" name="active_tab" value="dpri-tab">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search DOH registry..." 
                           class="w-full pl-10 pr-4 py-2 border border-blue-100 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr class="text-xs text-gray-500 uppercase tracking-wider">
                            <th class="p-4 font-bold border-b border-gray-200/60">DOH Drug Name</th>
                            <th class="p-4 font-bold border-b border-gray-200/60">Lowest (₱)</th>
                            <th class="p-4 font-bold border-b border-gray-200/60">Median (₱)</th>
                            <th class="p-4 font-bold border-b border-gray-200/60">Highest (₱)</th>
                            <th class="p-4 font-bold border-b border-gray-200/60">Year</th>
                            <th class="p-4 font-bold border-b border-gray-200/60 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                        @forelse($dpriRecords as $dpri)
                        <tr class="hover:bg-white/60 transition group">
                            <td class="p-4 font-bold text-securx-navy">{{ $dpri->doh_raw_drug_name }}</td>
                            <td class="p-4 text-green-600 font-medium">{{ number_format($dpri->lowest_price, 2) }}</td>
                            <td class="p-4 text-blue-600 font-bold">{{ number_format($dpri->median_price, 2) }}</td>
                            <td class="p-4 text-red-500 font-medium">{{ number_format($dpri->highest_price, 2) }}</td>
                            <td class="p-4 text-gray-500">{{ $dpri->effective_year }}</td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <button type="button" onclick="openDpriEditModal('{{ $dpri->id }}', '{{ addslashes($dpri->doh_raw_drug_name) }}', '{{ $dpri->lowest_price }}', '{{ $dpri->median_price }}', '{{ $dpri->highest_price }}', '{{ $dpri->effective_year }}')" class="text-xs font-bold px-3 py-1.5 bg-gray-100 hover:bg-blue-500 hover:text-white text-gray-600 rounded-lg transition-colors">Edit</button>
                                <button type="button" onclick="openDpriDeleteModal('{{ $dpri->id }}', '{{ addslashes($dpri->doh_raw_drug_name) }}')" class="text-xs font-bold px-3 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 rounded-lg transition-colors ml-1">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400 font-medium">No DPRI records found. Upload a dataset to populate.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($dpriRecords) && $dpriRecords->hasPages())
            <div class="p-4 border-t border-gray-200/60 bg-white/50">
                {{ $dpriRecords->appends(['med_page' => request('med_page'), 'search' => request('search')])->links() }}
            </div>
            @endif
        </div>
    </div>

</div> <div id="import-med-modal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all border-t-4 border-t-securx-cyan">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-securx-navy">Import Medication Masterlist</h3>
            <button onclick="closeImportMedModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50">
            <div class="flex flex-col justify-center">
                <form action="{{ route('admin.dataset.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-securx-cyan border-dashed rounded-xl cursor-pointer bg-white hover:bg-securx-cyan/5 transition group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-securx-cyan group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="mb-1 text-sm text-gray-600"><span class="font-bold text-securx-navy">Upload CSV</span></p>
                        </div>
                        <input type="file" name="dataset" class="hidden" accept=".csv" required onchange="document.getElementById('file-med-display').textContent = this.files[0].name; document.getElementById('file-med-display').classList.remove('hidden');" />
                    </label>
                    <p id="file-med-display" class="text-sm font-bold text-center text-securx-cyan hidden p-2 bg-white rounded-lg border border-securx-cyan/20"></p>
                    <button type="submit" class="w-full py-3 px-4 bg-securx-cyan hover:bg-securx-navy text-white font-bold rounded-xl shadow-md transition-colors">Start Import</button>
                </form>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200">
                <h3 class="text-sm font-bold text-securx-navy mb-3 border-b border-gray-100 pb-2">CSV Requirements:</h3>
                <ol class="space-y-2 text-xs text-gray-700 font-medium mb-4">
                    <li><span class="text-securx-cyan font-bold mr-1">1.</span> Generic Name</li>
                    <li><span class="text-securx-cyan font-bold mr-1">2.</span> Form</li>
                    <li><span class="text-securx-cyan font-bold mr-1">3.</span> Strength</li>
                    <li><span class="text-securx-cyan font-bold mr-1">4.</span> Estimated Price</li>
                </ol>
                <div class="p-2 bg-securx-gold/10 rounded border border-securx-gold/20 text-[11px] text-securx-gold font-bold">Smart Overwrite Active</div>
            </div>
        </div>
    </div>
</div>

<div id="import-dpri-modal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all border-t-4 border-t-blue-500">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-blue-900">Import DPRI Dataset</h3>
            <button onclick="closeImportDpriModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50">
            <div class="flex flex-col justify-center">
                <form action="{{ route('admin.dataset.import-dpri') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-blue-400 border-dashed rounded-xl cursor-pointer bg-white hover:bg-blue-50 transition group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-blue-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="mb-1 text-sm text-gray-600"><span class="font-bold text-blue-800">Upload DPRI CSV</span></p>
                        </div>
                        <input type="file" name="dpri_dataset" class="hidden" accept=".csv" required onchange="document.getElementById('file-dpri-display').textContent = this.files[0].name; document.getElementById('file-dpri-display').classList.remove('hidden');" />
                    </label>
                    <p id="file-dpri-display" class="text-sm font-bold text-center text-blue-600 hidden p-2 bg-white rounded-lg border border-blue-200"></p>
                    <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-xl shadow-md transition-colors">Sync DOH Index</button>
                </form>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200">
                <h3 class="text-sm font-bold text-securx-navy mb-3 border-b border-gray-100 pb-2">CSV Requirements:</h3>
                <ol class="space-y-2 text-xs text-gray-700 font-medium mb-4">
                    <li><span class="text-blue-500 font-bold mr-1">1.</span> Drug Name</li>
                    <li><span class="text-blue-500 font-bold mr-1">2.</span> Lowest Price</li>
                    <li><span class="text-blue-500 font-bold mr-1">3.</span> Median Price</li>
                    <li><span class="text-blue-500 font-bold mr-1">4.</span> Highest Price</li>
                    <li><span class="text-blue-500 font-bold mr-1">5.</span> Effective Year</li>
                </ol>
            </div>
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
</div> 

<div id="delete-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden transform transition-all text-center p-6">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-securx-navy mb-2">Archive Medication?</h3>
        <p class="text-sm text-gray-500 mb-6">Are you sure you want to remove <strong id="delete-drug-name" class="text-gray-800"></strong> from the active inventory?</p>
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

<div id="edit-dpri-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-blue-50/50">
            <h3 class="text-lg font-bold text-blue-900">Edit DPRI Record</h3>
            <button onclick="closeDpriEditModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="edit-dpri-form" method="POST" action="" class="p-6 space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">DOH Raw Drug Name</label>
                <input type="text" id="edit-dpri-name" name="doh_raw_drug_name" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Lowest (₱)</label>
                    <input type="number" step="0.01" id="edit-dpri-lowest" name="lowest_price" class="w-full border-gray-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Median (₱)</label>
                    <input type="number" step="0.01" id="edit-dpri-median" name="median_price" class="w-full border-gray-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Highest (₱)</label>
                    <input type="number" step="0.01" id="edit-dpri-highest" name="highest_price" class="w-full border-gray-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Effective Year</label>
                <input type="number" id="edit-dpri-year" name="effective_year" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeDpriEditModal()" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-800 transition-colors shadow-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div id="delete-dpri-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden transform transition-all text-center p-6">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-securx-navy mb-2">Archive DPRI Record?</h3>
        <p class="text-sm text-gray-500 mb-6">Are you sure you want to remove <strong id="delete-dpri-name" class="text-gray-800"></strong> from the DOH index?</p>
        <form id="delete-dpri-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeDpriDeleteModal()" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">Archive Record</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    @vite(['resources/js/dataset-management.js'])
@endpush

@endsection