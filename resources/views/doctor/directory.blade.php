@extends('layouts.doctor')

@section('page_title', 'Patient Directory')

@section('content')
    <div x-data="{ showEditDrawer: false, showRegisterDrawer: false, showRecordsDrawer: false, activePatient: '' }" class="max-w-7xl mx-auto space-y-6 pb-12 relative overflow-hidden">

        <div
            class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Patient Master Index</h2>
                <p class="text-sm text-gray-500 mt-1">Search, view records, and manage patient demographics.</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button
                    class="bg-white border border-gray-300 text-gray-600 hover:text-blue-600 hover:border-blue-300 font-bold py-2.5 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export
                </button>
                <button @click="showRegisterDrawer = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Register New Patient
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-8 relative">
                <input type="text"
                    class="w-full bg-white border border-gray-200 text-base rounded-xl p-3.5 pl-12 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition font-medium text-securx-navy"
                    placeholder="Search by name, ID number, phone, or email...">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div class="md:col-span-4 flex gap-4">
                <select
                    class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition text-gray-600 font-medium">
                    <option>Sort: A-Z</option>
                    <option>Sort: Z-A</option>
                    <option>Sort: Newest First</option>
                </select>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-gray-200 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="p-4 pl-6">Patient Name & ID</th>
                            <th class="p-4">Demographics</th>
                            <th class="p-4">Contact Info</th>
                            <th class="p-4 pr-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">

                        <tr class="hover:bg-slate-50 transition group">
                            <td class="p-4 pl-6 align-middle">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0">
                                        MC</div>
                                    <div>
                                        <p class="font-bold text-securx-navy text-base">Reyes, Maria Clara</p>
                                        <p class="text-[11px] text-gray-500 font-mono mt-0.5">ID: 019D57-X</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 align-middle">
                                <p class="font-bold text-gray-700">DOB: Aug 12, 1980</p>
                                <p class="text-xs text-gray-500 mt-0.5">Female</p>
                            </td>
                            <td class="p-4 align-middle">
                                <p class="font-bold text-gray-700">0917-555-0198</p>
                                <p class="text-xs text-gray-500 mt-0.5 truncate max-w-[150px]">m.reyes80@email.com</p>
                            </td>
                            <td class="p-4 pr-6 align-middle text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="showRecordsDrawer = true; activePatient = 'Reyes, Maria Clara'"
                                        class="px-3 py-1.5 bg-white border border-gray-200 text-xs font-bold text-gray-600 rounded-lg hover:border-securx-navy hover:text-securx-navy transition shadow-sm flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        Records
                                    </button>
                                    <button @click="showEditDrawer = true"
                                        class="px-3 py-1.5 bg-slate-100 border border-transparent text-xs font-bold text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm">Update
                                        Info</button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="showEditDrawer || showRegisterDrawer || showRecordsDrawer"
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40" x-transition.opacity
            @click="showEditDrawer = false; showRegisterDrawer = false; showRecordsDrawer = false" style="display: none;">
        </div>

        <div x-show="showRegisterDrawer"
            class="fixed inset-y-0 right-0 z-50 w-full max-w-xl bg-white shadow-2xl flex flex-col border-l border-gray-200"
            x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" style="display: none;">

            <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center shrink-0">
                <div>
                    <h2 class="text-xl font-black text-securx-navy">Register Patient</h2>
                </div>
                <button @click="showRegisterDrawer = false"
                    class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"><svg class="w-6 h-6"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>

            <form action="#" method="POST" class="flex-1 flex flex-col overflow-hidden">
                <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">

                    <div>
                        <h3
                            class="text-xs font-bold text-blue-600 uppercase tracking-widest border-b border-blue-100 pb-2 mb-4">
                            Account details (users)</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">First Name *</label><input
                                    type="text" name="first_name" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Middle Name</label><input
                                    type="text" name="middle_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Last Name *</label><input
                                    type="text" name="last_name" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Qualifier (e.g., Jr.,
                                    III)</label><input type="text" name="qualifier"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div class="col-span-2"><label class="block text-[11px] font-bold text-gray-600 mb-1">Full
                                    Name (Display) *</label><input type="text" name="name" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>

                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Date of Birth
                                    *</label><input type="date" name="dob" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Gender *</label>
                                <select name="gender" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="">Select...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Email</label><input
                                    type="email" name="email"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Mobile Number
                                    *</label><input type="text" name="mobile_num" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Role</label>
                                <input type="text" name="role" value="Patient" readonly
                                    class="w-full bg-gray-100 border border-gray-200 text-sm rounded-lg p-2.5 text-gray-500 cursor-not-allowed">
                            </div>
                            <div class="col-span-2 pt-2 border-t border-gray-100">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="generate_password" checked
                                        class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="text-sm font-bold text-securx-navy">Auto-generate secure password & email
                                        to patient</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3
                            class="text-xs font-bold text-emerald-600 uppercase tracking-widest border-b border-emerald-100 pb-2 mb-4">
                            Profile Data (patient_profiles)</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Height (cm)</label><input
                                    type="number" step="0.1" name="height"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Weight (kg)</label><input
                                    type="number" step="0.1" name="weight"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>

                            <div class="col-span-2"><label
                                    class="block text-[11px] font-bold text-gray-600 mb-1">Address</label>
                                <textarea name="address"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 h-16 resize-none"></textarea>
                            </div>
                            <div class="col-span-2"><label class="block text-[11px] font-bold text-gray-600 mb-1">School /
                                    Work</label><input type="text" name="school_work"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>

                            <div class="col-span-2 mt-2 pt-3 border-t border-gray-100">
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Family Contacts</p>
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Mother's Name</label><input
                                    type="text" name="mother_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Mother's
                                    Number</label><input type="text" name="mother_num"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Father's Name</label><input
                                    type="text" name="father_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Father's
                                    Number</label><input type="text" name="father_num"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-200 bg-slate-50 flex gap-3 shrink-0">
                    <button type="button" @click="showRegisterDrawer = false"
                        class="flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 px-4 rounded-xl transition text-sm">Cancel</button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition text-sm">Save
                        & Register</button>
                </div>
            </form>
        </div>

        <div x-show="showEditDrawer"
            class="fixed inset-y-0 right-0 z-50 w-full max-w-xl bg-white shadow-2xl flex flex-col border-l border-gray-200"
            x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" style="display: none;">

            <div class="px-6 py-4 bg-slate-50 border-b border-gray-200 flex justify-between items-center shrink-0">
                <div>
                    <h2 class="text-xl font-black text-securx-navy">Update Patient Info</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Reyes, Maria Clara</p>
                </div>
                <button @click="showEditDrawer = false"
                    class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"><svg
                        class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>

            <form action="#" method="POST" class="flex-1 flex flex-col overflow-hidden">
                @method('PATCH')
                <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">

                    <div>
                        <h3
                            class="text-xs font-bold text-blue-600 uppercase tracking-widest border-b border-blue-100 pb-2 mb-4">
                            Account details (users)</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">First Name</label><input
                                    type="text" name="first_name" value="Maria Clara"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Middle Name</label><input
                                    type="text" name="middle_name" value=""
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Last Name</label><input
                                    type="text" name="last_name" value="Reyes"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Qualifier</label><input
                                    type="text" name="qualifier" value=""
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div class="col-span-2"><label class="block text-[11px] font-bold text-gray-600 mb-1">Full
                                    Name (Display)</label><input type="text" name="name" value="Maria Clara Reyes"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>

                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Date of Birth</label><input
                                    type="date" name="dob" value="1980-08-12"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Gender</label>
                                <select name="gender"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="Male">Male</option>
                                    <option value="Female" selected>Female</option>
                                </select>
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Email</label><input
                                    type="email" name="email" value="m.reyes80@email.com"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Mobile Number</label><input
                                    type="text" name="mobile_num" value="0917-555-0198"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3
                            class="text-xs font-bold text-emerald-600 uppercase tracking-widest border-b border-emerald-100 pb-2 mb-4">
                            Profile Data (patient_profiles)</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Height (cm)</label><input
                                    type="number" step="0.1" name="height" value="160"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Weight (kg)</label><input
                                    type="number" step="0.1" name="weight" value="65"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>

                            <div class="col-span-2"><label
                                    class="block text-[11px] font-bold text-gray-600 mb-1">Address</label>
                                <textarea name="address"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 h-16 resize-none">142 Sampaguita St., Brgy. Lourdes Sur, Angeles City</textarea>
                            </div>
                            <div class="col-span-2"><label class="block text-[11px] font-bold text-gray-600 mb-1">School /
                                    Work</label><input type="text" name="school_work" value="Local Business Owner"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>

                            <div class="col-span-2 mt-2 pt-3 border-t border-gray-100">
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Family Contacts</p>
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Mother's Name</label><input
                                    type="text" name="mother_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Mother's
                                    Number</label><input type="text" name="mother_num"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Father's Name</label><input
                                    type="text" name="father_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Father's
                                    Number</label><input type="text" name="father_num"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-200 bg-slate-50 flex gap-3 shrink-0">
                    <button type="button" @click="showEditDrawer = false"
                        class="flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 px-4 rounded-xl transition text-sm">Cancel</button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition text-sm">Save
                        Changes</button>
                </div>
            </form>
        </div>

        <div x-show="showRecordsDrawer"
            class="fixed inset-y-0 right-0 z-50 w-full max-w-2xl bg-slate-50 shadow-2xl flex flex-col border-l border-gray-200"
            x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" style="display: none;">

            <div class="px-6 py-4 bg-white border-b border-gray-200 flex justify-between items-center shrink-0">
                <div>
                    <h2 class="text-xl font-black text-securx-navy">Medical Records</h2>
                    <p class="text-sm text-gray-500 mt-0.5" x-text="activePatient"></p>
                </div>
                <button @click="showRecordsDrawer = false"
                    class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"><svg
                        class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-8">

                <div>
                    <h3
                        class="text-sm font-bold text-blue-600 uppercase tracking-widest border-b border-blue-200 pb-2 mb-4">
                        1. Clinical Encounters</h3>
                    <div class="space-y-4 border-l-2 border-gray-200 ml-3 pl-5 relative">
                        <div class="relative">
                            <div class="absolute -left-[27px] top-1 w-3 h-3 bg-blue-500 rounded-full ring-4 ring-slate-50">
                            </div>
                            <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="font-bold text-securx-navy">Hypertension Follow-up</p>
                                    <p class="text-xs text-gray-400 font-bold bg-slate-100 px-2 py-1 rounded">Feb 12, 2026
                                    </p>
                                </div>
                                <p class="text-sm text-gray-600 mb-3"><span class="font-bold text-gray-500">A:</span>
                                    Patient's BP is stable at 120/80. Responding well to current Losartan regimen.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-red-600 uppercase tracking-widest border-b border-red-200 pb-2 mb-4">
                        2. Allergies & Reactions</h3>
                    <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2 mb-2">
                            <p class="font-bold text-red-700">Penicillin</p>
                            <span
                                class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-bold">Verified</span>
                        </div>
                        <p class="text-sm text-gray-600"><span class="font-bold text-gray-500">Reaction:</span> Severe
                            hives and shortness of breath (Reported 2021).</p>
                    </div>
                </div>

                <div>
                    <h3
                        class="text-sm font-bold text-emerald-600 uppercase tracking-widest border-b border-emerald-200 pb-2 mb-4">
                        3. Immunizations</h3>
                    <div
                        class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm flex justify-between items-center">
                        <div>
                            <p class="font-bold text-securx-navy">Influenza (Flu) Vaccine</p>
                            <p class="text-xs text-gray-500">Administered: Oct 10, 2025</p>
                        </div>
                        <span
                            class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-bold">Verified</span>
                    </div>
                </div>

                <div>
                    <h3
                        class="text-sm font-bold text-purple-600 uppercase tracking-widest border-b border-purple-200 pb-2 mb-4">
                        4. Lab Results & Documents</h3>
                    <div
                        class="bg-white border border-gray-200 p-3 rounded-xl shadow-sm flex items-center justify-between hover:border-purple-300 transition cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-100 p-2 rounded-lg text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-securx-navy text-sm">Complete Blood Count (CBC)</p>
                                <p class="text-xs text-gray-500">Uploaded: Jan 05, 2026</p>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-blue-600">View PDF</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
