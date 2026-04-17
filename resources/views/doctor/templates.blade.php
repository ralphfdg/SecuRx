@extends('layouts.doctor')

@section('page_title', 'Clinical Macros & Templates')

@section('content')
<div x-data="templateManager({ 
        storeRoute: '{{ route('doctor.templates.store') }}' 
    })" class="max-w-7xl mx-auto space-y-6 pb-12 relative overflow-hidden">

    <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-securx-navy">SOAP Templates & Macros</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your one-click clinical notes to speed up documentation.</p>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button @click="openDrawer('create')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] flex items-center gap-2 text-sm w-full md:w-auto justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Create New Macro
            </button>
        </div>
    </div>

    <form method="GET" action="{{ route('doctor.templates') }}" class="flex flex-col md:flex-row gap-4" x-data x-ref="templateSearchForm">
    <div class="relative flex-1">
        <input type="text" name="search" value="{{ request('search') }}" 
            x-on:input.debounce.500ms="$refs.templateSearchForm.submit()"
            autofocus onfocus="this.setSelectionRange(this.value.length, this.value.length);"
            class="w-full bg-white border border-gray-200 text-base rounded-xl p-3.5 pl-12 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition font-medium text-securx-navy" 
            placeholder="Search templates by name or content...">
        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    </div>
    <div class="w-full md:w-auto flex gap-2">
        <noscript>
            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3.5 px-6 rounded-xl transition h-full text-sm">Search</button>
        </noscript>
    </div>
</form>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl font-bold text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $template)
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200 flex flex-col group relative overflow-hidden">
                
                <div class="absolute top-4 right-4 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-10 bg-white/90 backdrop-blur-sm p-1 rounded-lg shadow-sm border border-gray-100">
                    <button @click="openDrawer('edit', {{ Js::from($template) }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-md transition" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                    <button @click="duplicateTemplate({{ Js::from($template) }})" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition" title="Duplicate"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></button>
                    <button @click="confirmDelete('{{ $template->id }}')" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition" title="Delete"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                </div>

                <div class="p-5 border-b border-gray-100 bg-slate-50/50 rounded-t-2xl">
                    <h3 class="text-lg font-black text-securx-navy line-clamp-1" title="{{ $template->template_name }}">{{ $template->template_name }}</h3>
                </div>
                
                <div class="p-5 space-y-4 flex-1 text-sm">
                    @if($template->subjective_text)
                    <div>
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-1.5 py-0.5 rounded">S</span>
                        <p class="text-gray-600 mt-1 line-clamp-2 leading-relaxed">{{ $template->subjective_text }}</p>
                    </div>
                    @endif
                    @if($template->objective_text)
                    <div>
                        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-1.5 py-0.5 rounded">O</span>
                        <p class="text-gray-600 mt-1 line-clamp-2 leading-relaxed">{{ $template->objective_text }}</p>
                    </div>
                    @endif
                    @if($template->assessment_text)
                    <div>
                        <span class="text-[10px] font-bold text-purple-600 uppercase tracking-widest bg-purple-50 px-1.5 py-0.5 rounded">A</span>
                        <p class="text-gray-600 mt-1 line-clamp-1 leading-relaxed">{{ $template->assessment_text }}</p>
                    </div>
                    @endif
                    @if($template->plan_text)
                    <div>
                        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest bg-amber-50 px-1.5 py-0.5 rounded">P</span>
                        <p class="text-gray-600 mt-1 line-clamp-2 leading-relaxed">{{ $template->plan_text }}</p>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500 font-medium italic bg-white border border-dashed border-gray-300 rounded-2xl">
                No templates found. Click "Create New Macro" to build your first one!
            </div>
        @endforelse
    </div>

    <div x-show="showDrawer || showDeleteModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40" x-transition.opacity @click="showDrawer = false; showDeleteModal = false" style="display: none;"></div>

    <div x-show="showDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-2xl bg-white shadow-2xl flex flex-col border-l border-gray-200"
         x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
         style="display: none;">
         
         <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center shrink-0">
             <div>
                 <h2 class="text-xl font-black text-securx-navy" x-text="isEditing ? 'Edit Macro' : 'Create New Macro'"></h2>
                 <p class="text-sm text-gray-500 mt-0.5">Build a reusable template for your consultation console.</p>
             </div>
             <button @click="showDrawer = false" type="button" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
         </div>

         <form :action="formAction" method="POST" class="flex-1 flex flex-col overflow-hidden">
             @csrf
             <template x-if="formMethod === 'PATCH'">
                 <input type="hidden" name="_method" value="PATCH">
             </template>

             <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">
                 
                 <div>
                     <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Macro Details</h3>
                     <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                         <div class="sm:col-span-2">
                             <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Template Name (Button Label) *</label>
                             <input type="text" name="template_name" x-model="formData.template_name" required class="w-full bg-slate-50 border border-gray-200 text-base font-bold text-securx-navy rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Acute Gastroenteritis">
                         </div>
                     </div>
                 </div>

                 <div>
                     <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Default Content (S.O.A.P)</h3>
                     <p class="text-xs text-gray-500 mb-4">Leave any field blank if you prefer to type it manually during the consultation.</p>
                     
                     <div class="space-y-4">
                         <div>
                             <label class="block text-[11px] font-bold text-blue-600 uppercase tracking-wider mb-1.5">Subjective</label>
                             <textarea name="subjective_text" @input="resizeTextarea" x-model="formData.subjective_text" class="w-full bg-slate-50 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all p-3.5 text-sm text-gray-800 placeholder-gray-300 min-h-[80px] resize-none overflow-hidden" placeholder="Pre-fill patient complaints..."></textarea>
                         </div>
                         <div>
                             <label class="block text-[11px] font-bold text-emerald-600 uppercase tracking-wider mb-1.5">Objective</label>
                             <textarea name="objective_text" @input="resizeTextarea" x-model="formData.objective_text" class="w-full bg-slate-50 border border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all p-3.5 text-sm text-gray-800 placeholder-gray-300 min-h-[80px] resize-none overflow-hidden" placeholder="Pre-fill standard physical findings..."></textarea>
                         </div>
                         <div>
                             <label class="block text-[11px] font-bold text-purple-600 uppercase tracking-wider mb-1.5">Assessment</label>
                             <textarea name="assessment_text" @input="resizeTextarea" x-model="formData.assessment_text" class="w-full bg-slate-50 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all p-3.5 text-sm text-gray-800 placeholder-gray-300 min-h-[80px] resize-none overflow-hidden" placeholder="Pre-fill diagnosis..."></textarea>
                         </div>
                         <div>
                             <label class="block text-[11px] font-bold text-amber-600 uppercase tracking-wider mb-1.5">Plan</label>
                             <textarea name="plan_text" @input="resizeTextarea" x-model="formData.plan_text" class="w-full bg-slate-50 border border-gray-200 rounded-xl focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all p-3.5 text-sm text-gray-800 placeholder-gray-300 min-h-[80px] resize-none overflow-hidden" placeholder="Pre-fill standard advice and treatment plans..."></textarea>
                         </div>
                     </div>
                 </div>

             </div>

             <div class="p-4 border-t border-gray-200 bg-slate-50 flex gap-3 shrink-0">
                 <button type="button" @click="showDrawer = false" class="flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 px-4 rounded-xl transition shadow-sm text-sm">
                     Cancel
                 </button>
                 <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] text-sm">
                     <span x-text="isEditing ? 'Save Changes' : 'Create Macro'"></span>
                 </button>
             </div>
         </form>
    </div>

    <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white rounded-2xl shadow-2xl max-w-md w-full border border-red-100 overflow-hidden relative z-50">
            <div class="bg-red-50 p-5 border-b border-red-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-lg font-black text-red-800">Delete Template?</h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-700">Are you sure you want to permanently delete this macro? You cannot undo this action.</p>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex gap-3 border-t border-gray-100">
                <button @click="showDeleteModal = false" class="flex-1 bg-white border border-gray-300 text-gray-700 font-bold py-2.5 rounded-xl transition text-sm">Cancel</button>
                <form :action="`/doctor/templates/${deleteId}`" method="POST" class="flex-1 flex">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl transition text-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $template)
            @empty
            @endforelse
    </div>

    <div class="mt-8">
        {{ $templates->appends(request()->query())->links() }}
    </div>

</div>
@endsection