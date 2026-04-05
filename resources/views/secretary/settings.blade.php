@extends('layouts.secretary')

@section('page_title', 'Account Settings')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">

        <div class="p-6 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-securx-cyan/10 rounded-full flex items-center justify-center text-securx-cyan border border-securx-cyan/20 flex-shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy tracking-tight">Profile Management</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Update your personal information and front desk authentication credentials.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 shadow-sm animate-pulse">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('secretary.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm">
                <h3 class="text-lg font-bold text-securx-navy border-b border-gray-100 pb-3 mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-securx-cyan"></span> Personal & Contact Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4 md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">First Name *</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                    class="w-full bg-white border border-gray-300 text-gray-800 rounded-md py-2.5 px-4 focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Middle Name</label>
                                <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}"
                                    class="w-full bg-white border border-gray-300 text-gray-800 rounded-md py-2.5 px-4 focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="col-span-1">
                                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Last Name *</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                        class="w-full bg-white border border-gray-300 text-gray-800 rounded-md py-2.5 px-4 focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors" required>
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Qualifier</label>
                                    <select name="qualifier" class="w-full bg-white border border-gray-300 text-gray-800 rounded-md py-2.5 px-3 focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors">
                                        <option value="" {{ empty($user->qualifier) ? 'selected' : '' }}>None</option>
                                        <option value="Jr." {{ $user->qualifier === 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                        <option value="Sr." {{ $user->qualifier === 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                        <option value="III" {{ $user->qualifier === 'III' ? 'selected' : '' }}>III</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Mobile Number *</label>
                        <input type="tel" name="mobile_num" value="{{ old('mobile_num', $user->mobile_num) }}"
                            class="w-full bg-white border border-gray-300 text-gray-800 rounded-md py-2.5 px-4 focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors" required>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 md:p-8 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-securx-cyan/10 rounded-bl-full pointer-events-none"></div>

                <h3 class="text-lg font-bold text-white border-b border-slate-700 pb-3 mb-6 flex items-center gap-2 relative z-10">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Authentication Credentials
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors" required>
                    </div>

                    <div class="md:col-span-2 border-t border-slate-700 pt-6 mt-2">
                        <p class="text-sm text-slate-400 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-securx-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Leave the fields below blank if you do not wish to change your password.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">New Password</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1.5">Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                            class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-2 focus:ring-securx-cyan focus:border-securx-cyan transition-colors">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 pb-10">
                <button type="submit" class="bg-securx-cyan hover:bg-cyan-500 text-white font-bold py-3 px-10 rounded-xl text-lg shadow-[0_4px_14px_0_rgba(28,181,209,0.39)] transition-transform hover:-translate-y-1">
                    Save Account Changes
                </button>
            </div>

        </form>
    </div>
@endsection