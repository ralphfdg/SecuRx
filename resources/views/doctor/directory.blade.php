@extends('layouts.doctor')

@section('page_title', 'Patient Directory')

@section('content')
    <div x-data="patientDirectory()" class="max-w-7xl mx-auto space-y-6 pb-12 relative overflow-hidden">

        <div
            class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Patient Master Index</h2>
                <p class="text-sm text-gray-500 mt-1">Search, view records, and manage patient demographics.</p>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button @click="showRegisterDrawer = true"  
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Register New Patient
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('doctor.directory') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4" x-data x-ref="directoryForm">
    <div class="md:col-span-8 relative">
        <input type="text" name="search" value="{{ request('search') }}"
            x-on:input.debounce.500ms="$refs.directoryForm.submit()"
            autofocus onfocus="this.setSelectionRange(this.value.length, this.value.length);"
            class="w-full bg-white border border-gray-200 text-base rounded-xl p-3.5 pl-12 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition font-medium text-securx-navy"
            placeholder="Search by name, ID number, phone, or email...">
        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>
    
    <div class="md:col-span-4 flex gap-4">
        <select name="sort" x-on:change="$refs.directoryForm.submit()"
            class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition text-gray-600 font-medium">
            <option value="a-z" {{ request('sort') == 'a-z' ? 'selected' : '' }}>Sort: A-Z</option>
            <option value="z-a" {{ request('sort') == 'z-a' ? 'selected' : '' }}>Sort: Z-A</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Sort: Newest First</option>
        </select>
        <noscript><button type="submit" class="bg-gray-200 px-4 rounded-xl">Go</button></noscript>
    </div>
</form>

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
                        @forelse($patients as $patient)
                            @php
                                $initials = strtoupper(
                                    substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1),
                                );
                                $age = $patient->dob ? \Carbon\Carbon::parse($patient->dob)->age : '--';
                            @endphp
                            <tr class="hover:bg-slate-50 transition group">
                                <td class="p-4 pl-6 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ $initials }}</div>
                                        <div>
                                            <p class="font-bold text-securx-navy text-base">{{ $patient->last_name }},
                                                {{ $patient->first_name }}</p>
                                            <p class="text-[11px] text-gray-500 font-mono mt-0.5">ID:
                                                {{ substr($patient->id, 0, 8) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <p class="font-bold text-gray-700">DOB:
                                        {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('M d, Y') : 'N/A' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $patient->gender ?? 'Unknown' }} •
                                        {{ $age }} yrs</p>
                                </td>
                                <td class="p-4 align-middle">
                                    <p class="font-bold text-gray-700">{{ $patient->mobile_num ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5 truncate max-w-[150px]">
                                        {{ $patient->email ?? 'No email' }}</p>
                                </td>
                                <td class="p-4 pr-6 align-middle text-right">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            @click="openRecords('{{ $patient->id }}', '{{ addslashes($patient->name) }}')"
                                            class="px-3 py-1.5 bg-white border border-gray-200 text-xs font-bold text-gray-600 rounded-lg hover:border-securx-navy hover:text-securx-navy transition shadow-sm flex items-center gap-1">
                                            Records
                                        </button>
                                        <button
                                            @click="openEditDrawer({{ Js::from($patient) }}, {{ Js::from($patient->patientProfile) }})"
                                            class="px-3 py-1.5 bg-slate-100 border border-transparent text-xs font-bold text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm">
                                            View or Update Info
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-gray-500 font-medium italic">No patients
                                    found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100">{{ $patients->links() }}</div>
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
                <h2 class="text-xl font-black text-securx-navy">Register Patient</h2>
                <button type="button" @click="showRegisterDrawer = false" class="p-2 text-gray-400 hover:text-red-500"><svg
                        class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>

            <form action="{{ route('doctor.patient.store') }}" method="POST" class="flex-1 flex flex-col overflow-hidden">
                @csrf
                <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">

                    <div>
                        <h3
                            class="text-xs font-bold text-blue-600 uppercase tracking-widest border-b border-blue-100 pb-2 mb-4">
                            Account details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">First Name *</label>
                                <input type="text" name="first_name" x-model="regForm.first_name" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Middle Name</label>
                                <input type="text" name="middle_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Last Name *</label>
                                <input type="text" name="last_name" x-model="regForm.last_name" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Qualifier (Jr., III)</label>
                                <input type="text" name="qualifier"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Date of Birth *</label>
                                <input type="date" name="dob" required
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
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Email *</label>
                                <input type="email" name="email" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Mobile Number *</label>
                                <input type="text" name="mobile_num" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-xs font-bold text-securx-navy uppercase tracking-widest">Portal Access
                                Credentials</h3>
                            <button type="button" @click="generateCredentials()"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold py-1.5 px-3 rounded shadow-sm transition">Generate</button>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Username *</label>
                                <input type="text" name="username" x-model="regForm.username" readonly required
                                    class="w-full bg-white border border-blue-200 text-sm font-mono text-blue-700 rounded-lg p-2 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Temp Password *</label>
                                <input type="text" name="password" x-model="regForm.password" readonly required
                                    class="w-full bg-white border border-blue-200 text-sm font-mono text-blue-700 rounded-lg p-2 focus:outline-none">
                            </div>
                        </div>
                        <p class="text-[10px] text-blue-500 mt-2 italic">Click Generate after entering First and Last name.
                            Provide these to the patient to log in.</p>
                    </div>

                    <div>
                        <h3
                            class="text-xs font-bold text-emerald-600 uppercase tracking-widest border-b border-emerald-100 pb-2 mb-4">
                            Demographics & Contacts (patient_profiles)</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Height (cm)</label>
                                <input type="number" step="0.1" name="height"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Weight (kg)</label>
                                <input type="number" step="0.1" name="weight"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Address</label>
                                <textarea name="address"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 h-16 resize-none"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">School / Work</label>
                                <input type="text" name="school_work"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>

                            <div class="col-span-2 mt-2 pt-3 border-t border-gray-100">
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Emergency / Family Contacts</p>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Mother's Name</label>
                                <input type="text" name="mother_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Mother's Contact</label>
                                <input type="text" name="mother_contact"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Father's Name</label>
                                <input type="text" name="father_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Father's Contact</label>
                                <input type="text" name="father_contact"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-200 bg-slate-50 flex gap-3 shrink-0">
                    <button type="button" @click="showRegisterDrawer = false"
                        class="flex-1 bg-white border border-gray-300 text-gray-700 font-bold py-3 px-4 rounded-xl text-sm">Cancel</button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white font-bold py-3 px-4 rounded-xl text-sm">Save &
                        Register</button>
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
                    <p class="text-sm text-gray-500 mt-0.5" x-text="editForm.first_name + ' ' + editForm.last_name"></p>
                </div>
                <button type="button" @click="showEditDrawer = false" class="p-2 text-gray-400 hover:text-red-500"><svg
                        class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>

            <form :action="`/doctor/directory/patient/${editForm.id}`" method="POST"
                class="flex-1 flex flex-col overflow-hidden">
                @csrf
                @method('PATCH')
                <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">

                    <div>
                        <h3
                            class="text-xs font-bold text-blue-600 uppercase tracking-widest border-b border-blue-100 pb-2 mb-4">
                            Account details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">First Name *</label><input
                                    type="text" name="first_name" x-model="editForm.first_name" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Middle Name</label><input
                                    type="text" name="middle_name" x-model="editForm.middle_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Last Name *</label><input
                                    type="text" name="last_name" x-model="editForm.last_name" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Qualifier (Jr.,
                                    III)</label><input type="text" name="qualifier" x-model="editForm.qualifier"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500">
                            </div>

                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Date of Birth</label><input
                                    type="date" name="dob" x-model="editForm.dob"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Gender</label>
                                <select name="gender" x-model="editForm.gender"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Email *</label><input
                                    type="email" name="email" x-model="editForm.email" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Mobile</label><input
                                    type="text" name="mobile_num" x-model="editForm.mobile_num"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3
                            class="text-xs font-bold text-emerald-600 uppercase tracking-widest border-b border-emerald-100 pb-2 mb-4">
                            Profile Data</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Height (cm)</label><input
                                    type="number" step="0.1" name="height" x-model="editForm.height"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Weight (kg)</label><input
                                    type="number" step="0.1" name="weight" x-model="editForm.weight"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500">
                            </div>
                            <div class="col-span-2"><label
                                    class="block text-[11px] font-bold text-gray-600 mb-1">Address</label>
                                <textarea name="address" x-model="editForm.address"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500 h-16 resize-none"></textarea>
                            </div>
                            <div class="col-span-2"><label class="block text-[11px] font-bold text-gray-600 mb-1">School /
                                    Work</label><input type="text" name="school_work" x-model="editForm.school_work"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500">
                            </div>

                            <div class="col-span-2 mt-2 pt-3 border-t border-gray-100">
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Emergency / Family Contacts</p>
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Mother's Name</label><input
                                    type="text" name="mother_name" x-model="editForm.mother_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Mother's
                                    Contact</label><input type="text" name="mother_contact"
                                    x-model="editForm.mother_contact"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Father's Name</label><input
                                    type="text" name="father_name" x-model="editForm.father_name"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500">
                            </div>
                            <div><label class="block text-[11px] font-bold text-gray-600 mb-1">Father's
                                    Contact</label><input type="text" name="father_contact"
                                    x-model="editForm.father_contact"
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-lg p-2.5 focus:border-emerald-500">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="p-4 border-t border-gray-200 bg-slate-50 flex gap-3 shrink-0">
                    <button type="button" @click="showEditDrawer = false"
                        class="flex-1 bg-white border border-gray-300 text-gray-700 font-bold py-3 px-4 rounded-xl text-sm">Cancel</button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white font-bold py-3 px-4 rounded-xl text-sm">Save Changes</button>
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
                <button @click="showRecordsDrawer = false" class="p-2 text-gray-400 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-8">
                <div x-show="isLoadingRecords" class="text-center py-10 text-gray-400 font-bold animate-pulse">
                    Loading Records...
                </div>

                <div x-show="!isLoadingRecords">
                    <h3
                        class="text-sm font-bold text-blue-600 uppercase tracking-widest border-b border-blue-200 pb-2 mb-4">
                        Patient Timeline
                    </h3>
                    <div class="space-y-4 border-l-2 border-gray-200 ml-3 pl-5 relative">
                        <template x-for="item in recordsData.timeline" :key="item.id + item.type">
                            <div class="relative group cursor-default" x-data="{ expanded: false }">
                                <div class="absolute -left-[27px] top-4 w-3 h-3 rounded-full ring-4 ring-slate-50 transition-colors duration-200"
                                    :class="{
                                        'bg-blue-500': item.type === 'encounter',
                                        'bg-purple-500': item.type === 'lab_result',
                                        'bg-emerald-500': item.type === 'immunization',
                                        'bg-amber-500': item.type === 'document',
                                        'bg-red-500': item.type === 'allergy',
                                        'group-hover:ring-blue-100': item.is_verified == 1,
                                        'group-hover:ring-amber-100': item.is_verified == 0
                                    }">
                                </div>

                                <div class="bg-white border p-3.5 rounded-xl shadow-sm transition-all duration-200 hover:shadow-md"
                                     :class="item.is_verified == 1 ? 'border-gray-200 hover:border-blue-300' : 'border-amber-300 bg-amber-50/40 hover:border-amber-400'">
                                    
                                    <div class="flex justify-between items-start gap-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                                <p class="font-bold text-securx-navy truncate" x-text="item.title"></p>
                                                <span x-show="item.is_verified == 0" class="shrink-0 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-amber-100 text-amber-700 border border-amber-200">
                                                    Pending
                                                </span>
                                            </div>
                                            
                                            <div class="flex items-center justify-between mt-1">
                                                <p class="text-[10px] font-bold uppercase tracking-wider"
                                                    :class="{
                                                        'text-blue-600': item.type === 'encounter',
                                                        'text-purple-600': item.type === 'lab_result',
                                                        'text-emerald-600': item.type === 'immunization',
                                                        'text-amber-600': item.type === 'document',
                                                        'text-red-600': item.type === 'allergy'
                                                    }"
                                                    x-text="item.type.replace('_', ' ')">
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex flex-col items-end gap-2 shrink-0">
                                            <p class="text-xs text-gray-500 font-bold bg-slate-100 px-2 py-1 rounded"
                                                x-text="new Date(item.date).toLocaleDateString()"></p>
                                            
                                            <div class="flex gap-2">
                                                <button @click="expanded = !expanded" 
                                                        class="text-[10px] font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 px-2 py-1 rounded transition flex items-center gap-1 shadow-sm">
                                                    <span x-text="expanded ? 'Hide Details' : 'View Details'"></span>
                                                </button>

                                                <button x-show="item.is_verified == 0" 
                                                        @click="verifyRecord(item.id, item.type)" 
                                                        class="text-[10px] font-bold text-emerald-600 bg-emerald-100 hover:bg-emerald-600 hover:text-white px-2 py-1 rounded transition flex items-center gap-1 shadow-sm">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Verify
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div x-show="expanded" x-collapse class="mt-4 pt-3 border-t border-gray-100 text-sm text-gray-700">
                                        
                                        <div x-show="item.type === 'encounter'" class="space-y-3">
                                            <div><span class="text-[10px] font-bold text-gray-400 uppercase">Subjective</span><p class="mt-0.5 text-gray-800" x-text="item.subjective_note || 'N/A'"></p></div>
                                            <div><span class="text-[10px] font-bold text-gray-400 uppercase">Objective</span><p class="mt-0.5 text-gray-800" x-text="item.objective_note || 'N/A'"></p></div>
                                            <div><span class="text-[10px] font-bold text-gray-400 uppercase">Assessment</span><p class="mt-0.5 text-gray-800" x-text="item.assessment_note || 'N/A'"></p></div>
                                            <div><span class="text-[10px] font-bold text-gray-400 uppercase">Plan</span><p class="mt-0.5 text-gray-800" x-text="item.plan_note || 'N/A'"></p></div>
                                        </div>

                                        <div x-show="item.type === 'lab_result' || item.type === 'document'">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Attached File</span>
                                            <div class="mt-1">
                                                <a :href="item.file_path ? '/storage/' + item.file_path : '#'" target="_blank" 
                                                   class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-medium bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition"
                                                   x-show="item.file_path">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                    View Attachment
                                                </a>
                                                <p x-show="!item.file_path" class="text-gray-500 italic text-xs">No file attached.</p>
                                            </div>
                                        </div>

                                        <div x-show="item.type === 'immunization'" class="grid grid-cols-2 gap-4">
                                            <div><span class="text-[10px] font-bold text-gray-400 uppercase">Facility</span><p class="mt-0.5 text-gray-800" x-text="item.facility || 'Not specified'"></p></div>
                                            <div><span class="text-[10px] font-bold text-gray-400 uppercase">Valid Until</span><p class="mt-0.5 text-gray-800" x-text="item.valid_until ? new Date(item.valid_until).toLocaleDateString() : 'Lifetime'"></p></div>
                                        </div>

                                        <div x-show="item.type === 'allergy'">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase">Reported Reaction</span>
                                            <p class="mt-0.5 text-red-600 font-medium" x-text="item.reaction || 'No reaction specified'"></p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </template>

                        <p x-show="recordsData.timeline && recordsData.timeline.length === 0"
                            class="text-xs text-gray-400 italic">
                            No records found for this patient.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const form = document.getElementById('directoryForm');
        let debounceTimer;

        if (searchInput && form) {
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () {
                    form.submit();
                }, 500); // Wait 500ms before submitting
            });
        }
    });
</script>
@endsection
