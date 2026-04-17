@extends('layouts.admin')

@section('page_title', 'Specialization Management')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 relative">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-4 rounded-2xl shadow-sm border border-gray-100">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1">Medical Specializations</h1>
            <p class="text-gray-600 font-medium text-sm">Manage the official list of clinical specialties available to doctors.</p>
        </div>
        <div class="relative z-10">
            <button onclick="openAddSpecModal()" class="px-4 py-2.5 bg-securx-cyan hover:bg-securx-navy text-white font-bold text-sm rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Specialization
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

    <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-t-4 border-t-securx-cyan shadow-sm rounded-2xl">
        <div class="p-4 border-b border-gray-200/60 bg-gray-50/90 backdrop-blur-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-securx-navy">Active Specialties</h2>
            
            <form method="GET" action="{{ route('admin.specializations') }}" id="search-form" class="relative w-full md:w-96">
                <input type="text" id="search-input" name="search" value="{{ $search ?? '' }}" placeholder="Search specialties..." 
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
                        <th class="p-4 font-bold border-b border-gray-200/60 w-1/3">Specialization Name</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">Description</th>
                        <th class="p-4 font-bold border-b border-gray-200/60 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                    @forelse($specializations as $spec)
                    <tr class="hover:bg-white/60 transition group">
                        <td class="p-4 font-bold text-securx-navy">{{ $spec->name }}</td>
                        <td class="p-4 text-gray-600">{{ $spec->description ?? 'No description provided.' }}</td>
                        <td class="p-4 text-right whitespace-nowrap">
                            <button type="button" onclick="openEditSpecModal('{{ $spec->id }}', '{{ addslashes($spec->name) }}', '{{ addslashes($spec->description) }}')" class="text-xs font-bold px-3 py-1.5 bg-gray-100 hover:bg-securx-cyan hover:text-white text-gray-600 rounded-lg transition-colors shadow-sm">Edit</button>
                            <button type="button" onclick="openDeleteSpecModal('{{ $spec->id }}', '{{ addslashes($spec->name) }}')" class="text-xs font-bold px-3 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 rounded-lg transition-colors ml-1 shadow-sm">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-10 text-center text-gray-400 font-medium">No specializations found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($specializations->hasPages())
        <div class="p-4 border-t border-gray-200/60 bg-white/50">
            {{ $specializations->appends(['search' => request('search')])->links() }}
        </div>
        @endif
    </div>
</div>

<div id="add-spec-modal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all border-t-4 border-t-securx-cyan">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-securx-navy">Add New Specialization</h3>
            <button onclick="closeAddSpecModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('admin.specializations.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Specialization Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="e.g. Cardiology" class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Description (Optional)</label>
                <textarea name="description" rows="3" class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan" placeholder="Brief description of the specialty..."></textarea>
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeAddSpecModal()" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-securx-cyan text-white font-bold rounded-xl hover:bg-securx-navy transition-colors shadow-sm">Save</button>
            </div>
        </form>
    </div>
</div>

<div id="edit-spec-modal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all border-t-4 border-t-securx-cyan">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-securx-navy">Edit Specialization</h3>
            <button onclick="closeEditSpecModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="edit-spec-form" method="POST" action="" class="p-6 space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Specialization Name <span class="text-red-500">*</span></label>
                <input type="text" id="edit-spec-name" name="name" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Description</label>
                <textarea id="edit-spec-desc" name="description" rows="3" class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan"></textarea>
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeEditSpecModal()" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-securx-cyan text-white font-bold rounded-xl hover:bg-securx-navy transition-colors shadow-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div id="delete-spec-modal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden transform transition-all text-center p-6 border-t-4 border-t-red-500">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-securx-navy mb-2">Delete Specialization?</h3>
        <p class="text-sm text-gray-500 mb-6">Are you sure you want to remove <strong id="delete-spec-name" class="text-gray-800"></strong>? This will detach it from any doctors currently assigned to it.</p>
        
        <form id="delete-spec-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteSpecModal()" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    @vite(['resources/js/specializations.js'])
@endpush
@endsection