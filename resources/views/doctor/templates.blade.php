@extends('layouts.doctor')

@section('page_title', 'Clinical Macros & Templates')

@section('content')
<div x-data="templateManager()" class="max-w-7xl mx-auto space-y-6 pb-12 relative overflow-hidden">

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

    <div class="flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <input type="text" class="w-full bg-white border border-gray-200 text-base rounded-xl p-3.5 pl-12 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition font-medium text-securx-navy" placeholder="Search templates by name or content...">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <div class="w-full md:w-64">
            <select class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition text-gray-600 font-medium h-full">
                <option>All Categories</option>
                <option>Respiratory</option>
                <option>Cardiovascular</option>
                <option>Gastrointestinal</option>
                <option>General / Admin</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200 flex flex-col group relative overflow-hidden">
            <div class="absolute top-4 right-4 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-10 bg-white/90 backdrop-blur-sm p-1 rounded-lg shadow-sm border border-gray-100">
                <button @click="openDrawer('edit', 'Normal URI (Cold/Flu)')" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-md transition" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                <button class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition" title="Duplicate"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></button>
                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition" title="Delete"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
            </div>

            <div class="p-5 border-b border-gray-100 bg-slate-50/50 rounded-t-2xl">
                <span class="inline-block px-2.5 py-1 bg-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-widest rounded-md mb-2">Respiratory</span>
                <h3 class="text-lg font-black text-securx-navy line-clamp-1">Normal URI (Cold/Flu)</h3>
                <p class="text-xs text-gray-500 mt-1">Used 42 times this month</p>
            </div>
            
            <div class="p-5 space-y-4 flex-1 text-sm">
                <div>
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-1.5 py-0.5 rounded">S</span>
                    <p class="text-gray-600 mt-1 line-clamp-2 leading-relaxed">Patient presents with persistent dry cough and mild sore throat. Denies fever or chills.</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-1.5 py-0.5 rounded">O</span>
                    <p class="text-gray-600 mt-1 line-clamp-2 leading-relaxed">Lungs clear to auscultation bilaterally. Throat is mildly erythematous, no exudates.</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-purple-600 uppercase tracking-widest bg-purple-50 px-1.5 py-0.5 rounded">A</span>
                    <p class="text-gray-600 mt-1 line-clamp-1 leading-relaxed">Uncomplicated viral URI.</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest bg-amber-50 px-1.5 py-0.5 rounded">P</span>
                    <p class="text-gray-600 mt-1 line-clamp-2 leading-relaxed">Advised oral hydration and rest. Prescribed supportive meds. Return if fever develops.</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200 flex flex-col group relative overflow-hidden">
            <div class="absolute top-4 right-4 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-10 bg-white/90 backdrop-blur-sm p-1 rounded-lg shadow-sm border border-gray-100">
                <button @click="openDrawer('edit', 'HTN Regular Follow-up')" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-md transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                <button class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></button>
                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
            </div>

            <div class="p-5 border-b border-gray-100 bg-slate-50/50 rounded-t-2xl">
                <span class="inline-block px-2.5 py-1 bg-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-widest rounded-md mb-2">Cardiovascular</span>
                <h3 class="text-lg font-black text-securx-navy line-clamp-1">HTN Regular Follow-up</h3>
                <p class="text-xs text-gray-500 mt-1">Used 28 times this month</p>
            </div>
            
            <div class="p-5 space-y-4 flex-1 text-sm">
                <div>
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-1.5 py-0.5 rounded">S</span>
                    <p class="text-gray-600 mt-1 line-clamp-2 leading-relaxed">Follow-up for hypertension. Denies headaches, dizziness, or chest pain. Compliant with meds.</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-1.5 py-0.5 rounded">O</span>
                    <p class="text-gray-600 mt-1 line-clamp-2 leading-relaxed">BP is within normal limits. Regular heart rate and rhythm. No lower extremity edema.</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-purple-600 uppercase tracking-widest bg-purple-50 px-1.5 py-0.5 rounded">A</span>
                    <p class="text-gray-600 mt-1 line-clamp-1 leading-relaxed">Controlled Essential Hypertension.</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest bg-amber-50 px-1.5 py-0.5 rounded">P</span>
                    <p class="text-gray-600 mt-1 line-clamp-2 leading-relaxed">Refill current antihypertensive medications. Continue low sodium diet and regular exercise.</p>
                </div>
            </div>
        </div>

    </div>

    <div x-show="showDrawer" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40" x-transition.opacity @click="showDrawer = false" style="display: none;"></div>

    <div x-show="showDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-2xl bg-white shadow-2xl flex flex-col border-l border-gray-200"
         x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
         style="display: none;">
         
         <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center shrink-0">
             <div>
                 <h2 class="text-xl font-black text-securx-navy" x-text="isEditing ? 'Edit Macro' : 'Create New Macro'"></h2>
                 <p class="text-sm text-gray-500 mt-0.5">Build a reusable template for your consultation console.</p>
             </div>
             <button @click="showDrawer = false" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
         </div>

         <form action="#" method="POST" class="flex-1 flex flex-col overflow-hidden">
             <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">
                 
                 <div>
                     <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Macro Details</h3>
                     <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                         <div class="sm:col-span-2">
                             <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Template Name (Button Label) *</label>
                             <input type="text" x-model="formData.name" required class="w-full bg-slate-50 border border-gray-200 text-base font-bold text-securx-navy rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Acute Gastroenteritis">
                         </div>
                         <div class="sm:col-span-2">
                             <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Category *</label>
                             <select class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">
                                 <option>Respiratory</option>
                                 <option>Cardiovascular</option>
                                 <option>Gastrointestinal</option>
                                 <option>General / Admin</option>
                                 <option>+ Create New Category</option>
                             </select>
                         </div>
                     </div>
                 </div>

                 <div>
                     <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Default Content (S.O.A.P)</h3>
                     <p class="text-xs text-gray-500 mb-4">Leave any field blank if you prefer to type it manually during the consultation.</p>
                     
                     <div class="space-y-4">
                         <div>
                             <label class="block text-[11px] font-bold text-blue-600 uppercase tracking-wider mb-1.5">Subjective</label>
                             <textarea @input="resizeTextarea" x-model="formData.subjective" class="w-full bg-slate-50 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all p-3.5 text-sm text-gray-800 placeholder-gray-300 min-h-[80px] resize-none overflow-hidden" placeholder="Pre-fill patient complaints..."></textarea>
                         </div>

                         <div>
                             <label class="block text-[11px] font-bold text-emerald-600 uppercase tracking-wider mb-1.5">Objective</label>
                             <textarea @input="resizeTextarea" x-model="formData.objective" class="w-full bg-slate-50 border border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all p-3.5 text-sm text-gray-800 placeholder-gray-300 min-h-[80px] resize-none overflow-hidden" placeholder="Pre-fill standard physical findings..."></textarea>
                         </div>

                         <div>
                             <label class="block text-[11px] font-bold text-purple-600 uppercase tracking-wider mb-1.5">Assessment</label>
                             <textarea @input="resizeTextarea" x-model="formData.assessment" class="w-full bg-slate-50 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all p-3.5 text-sm text-gray-800 placeholder-gray-300 min-h-[80px] resize-none overflow-hidden" placeholder="Pre-fill diagnosis..."></textarea>
                         </div>

                         <div>
                             <label class="block text-[11px] font-bold text-amber-600 uppercase tracking-wider mb-1.5">Plan</label>
                             <textarea @input="resizeTextarea" x-model="formData.plan" class="w-full bg-slate-50 border border-gray-200 rounded-xl focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all p-3.5 text-sm text-gray-800 placeholder-gray-300 min-h-[80px] resize-none overflow-hidden" placeholder="Pre-fill standard advice and treatment plans..."></textarea>
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

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('templateManager', () => ({
            showDrawer: false,
            isEditing: false,
            
            // Dummy data binding for the form
            formData: {
                name: '',
                subjective: '',
                objective: '',
                assessment: '',
                plan: ''
            },
            
            // Reusable function to open drawer and pre-fill if editing
            openDrawer(mode, templateName = '') {
                this.isEditing = mode === 'edit';
                
                if (this.isEditing) {
                    // Simulate fetching data from backend
                    this.formData.name = templateName;
                    this.formData.subjective = "Patient presents with persistent dry cough...";
                    this.formData.objective = "Lungs clear to auscultation bilaterally...";
                    this.formData.assessment = "Uncomplicated viral URI.";
                    this.formData.plan = "Advised oral hydration and rest...";
                } else {
                    // Clear form for new macro
                    this.formData.name = '';
                    this.formData.subjective = '';
                    this.formData.objective = '';
                    this.formData.assessment = '';
                    this.formData.plan = '';
                }
                
                this.showDrawer = true;
            },

            // Auto-resizes textareas to fit content
            resizeTextarea(e) {
                let el = e.target;
                el.style.height = 'auto';
                el.style.height = el.scrollHeight + 'px';
            }
        }))
    })
</script>
@endsection