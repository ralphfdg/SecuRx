@extends('layouts.secretary')

@section('page_title', 'Patient Directory')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6 relative">

        @if (session('success'))
            <div
                class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 shadow-sm animate-pulse">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div
            class="p-6 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Patient Directory</h2>
                <p class="text-sm text-gray-500 mt-1">Manage patient records and update contact information.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                <form action="{{ route('secretary.patients') }}" method="GET" class="relative w-full sm:w-72">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search name or email..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm bg-slate-50">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>

                <button onclick="openPatientModal('create')"
                    class="bg-securx-cyan hover:bg-cyan-500 text-white font-bold py-2.5 px-5 rounded-xl transition shadow-[0_4px_14px_0_rgba(28,181,209,0.39)] flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                        </path>
                    </svg>
                    Add Patient
                </button>
            </div>
        </div>

        <div class="bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-gray-200 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="p-4 font-bold">Patient Name</th>
                            <th class="p-4 font-bold">Contact Info</th>
                            <th class="p-4 font-bold">DOB / Age</th>
                            <th class="p-4 font-bold">Gender</th>
                            <th class="p-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($patients as $p)
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="p-4">
                                    <p class="font-bold text-securx-navy">{{ $p->last_name }}, {{ $p->first_name }}</p>
                                    <p class="text-xs text-gray-400">ID: {{ substr($p->id, 0, 8) }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="text-gray-700">{{ $p->mobile_num ?? 'No number' }}</p>
                                    <p class="text-xs text-gray-500">{{ $p->email }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="text-gray-700">{{ \Carbon\Carbon::parse($p->dob)->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($p->dob)->age }} yrs old</p>
                                </td>
                                <td class="p-4 text-gray-600">{{ $p->gender ?? 'N/A' }}</td>
                                <td class="p-4 text-right">
                                    <button onclick="openPatientModal('edit', {{ json_encode($p) }})"
                                        class="bg-white border border-gray-300 text-gray-600 hover:border-securx-cyan hover:text-securx-cyan text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
                                        Edit Profile
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                        <p>No patients found.</p>
                                        @if (request('search'))
                                            <a href="{{ route('secretary.patients') }}"
                                                class="text-securx-cyan text-xs font-bold mt-2 hover:underline">Clear
                                                Search</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($patients->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $patients->links() }}
                </div>
            @endif
        </div>

    </div>

    <div id="patient_modal"
        class="fixed inset-0 z-[100] hidden bg-slate-900/60 backdrop-blur-sm overflow-y-auto md:pl-[18rem]">

        <div class="flex min-h-full items-center justify-center p-4 sm:p-6 py-12">

            <div
                class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl w-full max-w-5xl overflow-hidden border border-white/20 relative">

                <div
                    class="p-6 md:p-8 bg-securx-navy text-white flex justify-between items-center border-b border-securx-cyan/20">
                    <div>
                        <h3 id="modal_title" class="text-2xl font-black tracking-tight">Patient Registration</h3>
                        <p class="text-sm text-securx-cyan font-medium mt-1">Create or update a comprehensive medical
                            profile</p>
                    </div>
                    <button type="button" onclick="closePatientModal()"
                        class="text-slate-400 hover:text-white transition bg-white/10 p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-white/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <form id="patient_form" action="#" data-store-url="{{ route('secretary.patients.store') }}"
                    method="POST" class="p-6 md:p-8 space-y-8">
                    @csrf
                    <input type="hidden" name="_method" id="form_method" value="POST">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                        <div class="space-y-5">
                            <h3
                                class="text-lg font-bold text-securx-navy border-b border-securx-cyan/30 pb-2 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-securx-cyan" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Personal Information
                            </h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-securx-navy mb-1.5">First Name *</label>
                                    <input type="text" name="first_name" id="inp_first_name" required
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Last Name *</label>
                                    <input type="text" name="last_name" id="inp_last_name" required
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Middle Name</label>
                                    <input type="text" name="middle_name" id="inp_middle_name"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Qualifier</label>
                                    <select name="qualifier" id="inp_qualifier"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                                        <option value="">None</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="III">III</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Date of Birth *</label>
                                    <input type="date" name="dob" id="inp_dob" required
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3 text-gray-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Gender *</label>
                                    <select name="gender" id="inp_gender" required
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3 text-gray-600">
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <h3
                                class="text-lg font-bold text-securx-navy border-b border-gray-200 pb-2 mb-4 flex items-center gap-2 mt-8">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Contact Details
                            </h3>

                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Mobile Number *</label>
                                <input type="tel" name="mobile_num" id="inp_mobile_num"
                                    placeholder="+63 900 000 0000" required
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Email Address *</label>
                                <input type="email" name="email" id="inp_email" placeholder="patient@example.com"
                                    required
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                            </div>
                        </div>

                        <div class="space-y-5">
                            <h3
                                class="text-lg font-bold text-securx-navy border-b border-securx-gold/40 pb-2 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-securx-gold" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Medical & Demographics
                            </h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Height (cm)</label>
                                    <input type="number" step="0.1" name="height" id="inp_height"
                                        placeholder="e.g. 170"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Weight (kg)</label>
                                    <input type="number" step="0.1" name="weight" id="inp_weight"
                                        placeholder="e.g. 65"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Full Address *</label>
                                <input type="text" name="address" id="inp_address" required
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">School / Workplace</label>
                                <input type="text" name="school_work" id="inp_school_work"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                            </div>

                            <div class="p-5 bg-slate-50 border border-gray-200 rounded-xl mt-4">
                                <p class="text-xs font-bold text-securx-navy uppercase tracking-wider mb-3">Emergency /
                                    Guardian Info</p>
                                <div class="grid grid-cols-2 gap-3">
                                    <input type="text" name="mother_name" id="inp_mother_name"
                                        placeholder="Mother's Name"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 py-2 px-3 text-sm">
                                    <input type="tel" name="mother_contact" id="inp_mother_contact"
                                        placeholder="Mother's Contact"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 py-2 px-3 text-sm">
                                    <input type="text" name="father_name" id="inp_father_name"
                                        placeholder="Father's Name"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 py-2 px-3 text-sm">
                                    <input type="tel" name="father_contact" id="inp_father_contact"
                                        placeholder="Father's Contact"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 py-2 px-3 text-sm">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="account_security_section"
                        class="mt-8 pt-8 border-t border-gray-200/60 transition-all duration-300">
                        <h3 class="text-lg font-bold text-securx-navy mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-securx-navy" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Account Security Setup
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Username *</label>
                                <input type="text" name="username" id="inp_username"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Password *</label>
                                <input type="password" name="password" id="inp_password"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Confirm Password *</label>
                                <input type="password" name="password_confirmation" id="inp_password_confirmation"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200/60 flex items-center justify-end gap-4">
                        <button type="button" onclick="closePatientModal()"
                            class="px-5 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Cancel</button>
                        <button type="submit" id="btn_submit"
                            class="bg-securx-cyan hover:bg-cyan-500 text-white font-bold py-3 px-8 rounded-xl transition shadow-[0_4px_14px_0_rgba(28,181,209,0.39)] text-lg">
                            Submit Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    @push('scripts')
        @vite(['resources/js/secretary-patients.js'])
    @endpush
