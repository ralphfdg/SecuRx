@extends('layouts.patient')

@section('page_title', 'Account Settings')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">

        <div class="p-6 bg-slate-800 border border-slate-700 rounded-2xl shadow-lg flex items-center gap-5 text-slate-200">
            <div
                class="w-14 h-14 bg-securx-cyan/10 rounded-full flex items-center justify-center text-securx-cyan border border-securx-cyan/20 flex-shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-white tracking-tight">Profile Management</h2>
                <p class="text-sm text-slate-400 mt-1">
                    Update your personal demographics, emergency contacts, and account security credentials.
                </p>
            </div>
        </div>

        <form action="#" method="POST" class="space-y-8">
            @csrf
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 md:p-8 shadow-lg">
                <h3 class="text-lg font-bold text-white border-b border-slate-700 pb-3 mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-securx-cyan"></span> Identity & Demographics
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4 md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-300 mb-1.5">First Name *</label>
                                <input type="text" name="first_name" value="John"
                                    class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-300 mb-1.5">Middle Name</label>
                                <input type="text" name="middle_name" value=""
                                    class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="col-span-1">
                                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Last Name *</label>
                                    <input type="text" name="last_name" value="Doe"
                                        class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan"
                                        required>
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Suffix</label>
                                    <select name="qualifier"
                                        class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-3 focus:ring-securx-cyan focus:border-securx-cyan">
                                        <option value="" selected>None</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="III">III</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Date of Birth *</label>
                        <input type="date" name="dob" value="2005-01-15"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Gender *</label>
                        <select name="gender"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan"
                            required>
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Height (cm)</label>
                        <input type="number" name="height" value="175"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Weight (kg)</label>
                        <input type="number" name="weight" value="70"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan">
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 md:p-8 shadow-lg">
                <h3 class="text-lg font-bold text-white border-b border-slate-700 pb-3 mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-securx-gold"></span> Contact & Emergency Info
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">Mobile Number *</label>
                            <input type="tel" name="mobile_num" value="+63 917 123 4567"
                                class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1.5">School or Workplace</label>
                            <input type="text" name="school_work" value="Angeles University Foundation"
                                class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Full Residential Address *</label>
                        <input type="text" name="address" value="Angeles City, Pampanga"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan"
                            required>
                    </div>

                    <div class="md:col-span-2 mt-2 p-5 bg-slate-900/30 border border-slate-700/50 rounded-xl space-y-4">
                        <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Guardian Information</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-1">Mother's Full Name</label>
                                <input type="text" name="mother_name" placeholder="Name"
                                    class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2 px-3 text-sm focus:ring-securx-cyan focus:border-securx-cyan">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-1">Mother's Contact #</label>
                                <input type="tel" name="mother_contact" placeholder="+63"
                                    class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2 px-3 text-sm focus:ring-securx-cyan focus:border-securx-cyan">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-1">Father's Full Name</label>
                                <input type="text" name="father_name" placeholder="Name"
                                    class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2 px-3 text-sm focus:ring-securx-cyan focus:border-securx-cyan">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-1">Father's Contact #</label>
                                <input type="tel" name="father_contact" placeholder="+63"
                                    class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2 px-3 text-sm focus:ring-securx-cyan focus:border-securx-cyan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 md:p-8 shadow-lg">
                <h3 class="text-lg font-bold text-white border-b border-slate-700 pb-3 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                    Authentication Credentials
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Email Address</label>
                        <input type="email" name="email" value="ralph@student.auf.edu.ph"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Username</label>
                        <input type="text" name="username" value="johndoe"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan"
                            required>
                    </div>

                    <div class="md:col-span-2 border-t border-slate-700 pt-6 mt-2">
                        <p class="text-sm text-slate-400 mb-4">Leave the fields below blank if you do not wish to change
                            your password.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">New Password</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 pb-10">
                <button type="submit"
                    class="glass-btn-primary py-3 px-10 text-lg shadow-[0_0_15px_rgba(28,181,209,0.3)] hover:-translate-y-1 transition-transform">
                    Save Account Changes
                </button>
            </div>

        </form>
    </div>
@endsection
