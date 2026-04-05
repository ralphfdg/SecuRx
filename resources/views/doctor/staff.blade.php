@extends('layouts.doctor')

@section('page_title', 'Manage Staff')

@section('content')
<div x-data="staffManager()" class="max-w-7xl mx-auto space-y-6 pb-12 relative overflow-hidden">

    <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-securx-navy">Clinic Staff Management</h2>
            <p class="text-sm text-gray-500 mt-1">Manage secretary accounts, update contact info, and control system access.</p>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button @click="openDrawer('create')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] flex items-center justify-center gap-2 text-sm w-full md:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Add New Secretary
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 p-6 relative overflow-hidden group">
            <div class="absolute top-0 right-0 bg-blue-50 text-blue-600 border-b border-l border-blue-100 px-3 py-1 rounded-bl-lg text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                Active Access
            </div>

            <div class="flex items-center gap-4 mb-5 pt-2">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-gray-500 flex items-center justify-center font-black text-xl shrink-0 ring-4 ring-white shadow-sm">
                    JL
                </div>
                <div>
                    <h3 class="text-lg font-black text-securx-navy leading-tight">Josefa Luna</h3>
                    <p class="text-xs text-gray-500 font-bold mt-0.5">Role: Front Desk Secretary</p>
                </div>
            </div>

            <div class="space-y-3 mb-6">
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 border border-gray-100 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="font-medium truncate">j.luna@securx.clinic</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 border border-gray-100 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <span class="font-medium">0917-888-1234</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 border-t border-gray-100 pt-5">
                <button @click="openDrawer('edit', 'Josefa', 'Luna')" class="bg-white border border-gray-200 text-gray-600 hover:text-blue-600 hover:border-blue-300 font-bold py-2 rounded-lg transition shadow-sm text-xs flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Edit Info
                </button>
                <button @click="confirmRevoke('Josefa Luna')" class="bg-red-50 border border-red-100 text-red-600 hover:bg-red-600 hover:text-white font-bold py-2 rounded-lg transition shadow-sm text-xs flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    Revoke Access
                </button>
            </div>
        </div>

        <div class="bg-slate-50 border border-gray-200 rounded-2xl p-6 relative overflow-hidden group opacity-75">
            <div class="absolute top-0 right-0 bg-gray-200 text-gray-600 border-b border-l border-gray-300 px-3 py-1 rounded-bl-lg text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Access Revoked
            </div>

            <div class="flex items-center gap-4 mb-5 pt-2">
                <div class="w-14 h-14 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-black text-xl shrink-0 ring-4 ring-white shadow-sm">
                    RM
                </div>
                <div>
                    <h3 class="text-lg font-black text-gray-500 leading-tight line-through">Rico Mateo</h3>
                    <p class="text-xs text-gray-400 font-bold mt-0.5">Role: Former Secretary</p>
                </div>
            </div>

            <div class="space-y-3 mb-6">
                <div class="flex items-center gap-3 text-sm text-gray-400">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 border border-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="font-medium truncate">r.mateo@securx.clinic</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-400">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 border border-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <span class="font-medium">0922-333-4444</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 border-t border-gray-200 pt-5">
                <button class="bg-gray-100 border border-gray-300 text-gray-500 font-bold py-2 rounded-lg transition shadow-sm text-xs flex items-center justify-center gap-1.5 hover:bg-gray-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Restore Account Access
                </button>
            </div>
        </div>

    </div>

    <div x-show="showDrawer" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40" x-transition.opacity @click="showDrawer = false" style="display: none;"></div>

    <div x-show="showDrawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-lg bg-white shadow-2xl flex flex-col border-l border-gray-200"
         x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
         style="display: none;">
         
         <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center shrink-0">
             <div>
                 <h2 class="text-xl font-black text-securx-navy" x-text="isEditing ? 'Edit Staff Account' : 'Add New Staff'"></h2>
                 <p class="text-sm text-gray-500 mt-0.5" x-text="isEditing ? 'Update secretary details.' : 'Creates a new user record.'"></p>
             </div>
             <button @click="showDrawer = false" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
         </div>

         <form action="#" method="POST" class="flex-1 flex flex-col overflow-hidden">
             <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar">
                 
                 <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3">
                     <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                     <p class="text-xs text-blue-800 font-medium">Staff accounts are restricted to the <span class="font-bold">Secretary Role</span>. They can manage the queue and triage patients, but cannot access the Consultation Console or sign prescriptions.</p>
                 </div>

                 <div class="space-y-4">
                     <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2">Account Details</h3>
                     
                     <div class="grid grid-cols-2 gap-4">
                         <div>
                             <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">First Name *</label>
                             <input type="text" x-model="formData.first_name" required class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">
                         </div>
                         <div>
                             <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Last Name *</label>
                             <input type="text" x-model="formData.last_name" required class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">
                         </div>
                         <div class="col-span-2">
                             <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Email Address (Login ID) *</label>
                             <input type="email" x-model="formData.email" required class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">
                         </div>
                         <div class="col-span-2">
                             <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Mobile Number *</label>
                             <input type="text" x-model="formData.phone" required class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-blue-500 focus:border-blue-500">
                         </div>
                         <div class="col-span-2">
                             <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">System Role</label>
                             <input type="text" value="Secretary" readonly class="w-full bg-gray-100 border border-gray-200 text-sm font-bold text-gray-500 rounded-xl p-3 cursor-not-allowed">
                         </div>
                     </div>
                 </div>

                 <div x-show="!isEditing" class="pt-4 border-t border-gray-100">
                     <label class="flex items-start gap-3 cursor-pointer p-3 border border-gray-200 rounded-xl hover:bg-slate-50 transition">
                         <input type="checkbox" checked class="mt-0.5 rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                         <div>
                             <span class="block text-sm font-bold text-securx-navy">Auto-generate and email password</span>
                             <span class="block text-[10px] text-gray-500 mt-0.5">The staff member will receive a secure login link.</span>
                         </div>
                     </label>
                 </div>
             </div>

             <div class="p-4 border-t border-gray-200 bg-slate-50 flex gap-3 shrink-0">
                 <button type="button" @click="showDrawer = false" class="flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 px-4 rounded-xl transition shadow-sm text-sm">
                     Cancel
                 </button>
                 <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] text-sm">
                     <span x-text="isEditing ? 'Save Changes' : 'Create Account'"></span>
                 </button>
             </div>
         </form>

    </div>

    <div x-show="showRevokeModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showRevokeModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showRevokeModal = false"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="showRevokeModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-red-100">
                
                <div class="bg-red-50/50 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-red-100">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-black leading-6 text-red-800">Revoke Staff Access</h3>
                            <div class="mt-2">
                                <p class="text-sm text-red-700 font-medium">You are about to revoke system access for <span class="font-bold text-red-900" x-text="staffToRevoke"></span>. They will be immediately logged out and unable to access patient records.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-200">
                    <button type="button" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition-colors">
                        Confirm Revocation
                    </button>
                    <button @click="showRevokeModal = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('staffManager', () => ({
            showDrawer: false,
            showRevokeModal: false,
            isEditing: false,
            staffToRevoke: '',
            
            formData: {
                first_name: '',
                last_name: '',
                email: '',
                phone: ''
            },
            
            openDrawer(mode, firstName = '', lastName = '') {
                this.isEditing = mode === 'edit';
                
                if (this.isEditing) {
                    this.formData.first_name = firstName;
                    this.formData.last_name = lastName;
                    this.formData.email = "j.luna@securx.clinic";
                    this.formData.phone = "0917-888-1234";
                } else {
                    this.formData.first_name = '';
                    this.formData.last_name = '';
                    this.formData.email = '';
                    this.formData.phone = '';
                }
                
                this.showDrawer = true;
            },

            confirmRevoke(name) {
                this.staffToRevoke = name;
                this.showRevokeModal = true;
            }
        }))
    })
</script>
@endsection