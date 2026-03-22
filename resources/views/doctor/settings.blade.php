@extends('layouts.doctor')

@section('page_title', 'Profile & Security')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <div class="p-6 bg-slate-800 border border-slate-700 rounded-2xl shadow-lg flex items-center gap-5 text-slate-200">
        <div class="w-14 h-14 bg-securx-cyan/10 rounded-full flex items-center justify-center text-securx-cyan border border-securx-cyan/20 flex-shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Provider Configuration</h2>
            <p class="text-sm text-slate-400 mt-1">
                Manage your clinical directory listing, authentication credentials, and cryptographic signature PIN.
            </p>
        </div>
    </div>

    <form action="#" method="POST" class="space-y-8">
        @csrf

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 md:p-8 shadow-lg relative overflow-hidden">
            <div class="absolute -right-6 -top-6 text-green-500/5 pointer-events-none">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            </div>

            <div class="flex items-center justify-between border-b border-slate-700 pb-3 mb-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-2 relative z-10">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Clinical Authority
                </h3>
                <span class="px-3 py-1 bg-green-500/10 text-green-400 border border-green-500/20 rounded-full text-xs font-bold flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Admin Verified
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <div>
                    <label class="block text-sm font-bold text-slate-400 mb-1.5">Full Name & Title</label>
                    <input type="text" value="Dr. Juan Santos, MD" class="w-full bg-slate-900/30 border border-slate-700 text-slate-500 rounded-md py-2.5 px-4 cursor-not-allowed" disabled>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-400 mb-1.5">Primary Specialization</label>
                    <input type="text" value="Internal Medicine" class="w-full bg-slate-900/30 border border-slate-700 text-slate-500 rounded-md py-2.5 px-4 cursor-not-allowed" disabled>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-400 mb-1.5">PRC License Number</label>
                    <input type="text" value="0123456" class="w-full bg-slate-900/30 border border-slate-700 text-slate-500 rounded-md py-2.5 px-4 cursor-not-allowed" disabled>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-400 mb-1.5">PTR Number</label>
                    <input type="text" value="PTR-9876543" class="w-full bg-slate-900/30 border border-slate-700 text-slate-500 rounded-md py-2.5 px-4 cursor-not-allowed" disabled>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4 italic">* Core medical credentials cannot be altered manually. Please contact the System Administrator to request credential updates.</p>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 md:p-8 shadow-lg">
            <h3 class="text-lg font-bold text-white border-b border-slate-700 pb-3 mb-6 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-securx-cyan"></span> Public Directory Listing
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Primary Clinic / Hospital Affiliation *</label>
                    <input type="text" name="clinic_name" value="Angeles Medical Center" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Clinic Address *</label>
                    <input type="text" name="clinic_address" value="MacArthur Highway, Angeles City" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Clinic Contact Number *</label>
                    <input type="tel" name="clinic_contact" value="(045) 123-4567" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan" required>
                </div>
            </div>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 md:p-8 shadow-lg">
            <h3 class="text-lg font-bold text-white border-b border-slate-700 pb-3 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-securx-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Security & Authentication
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 p-5 bg-securx-gold/5 border border-securx-gold/20 rounded-xl mb-2 flex flex-col md:flex-row gap-6 items-center">
                    <div class="flex-1">
                        <h4 class="text-securx-gold font-bold mb-1">Digital Signature PIN</h4>
                        <p class="text-sm text-slate-400">This 4-digit PIN is required every time you generate a new cryptographic prescription UUID. Do not share this with clinic staff.</p>
                    </div>
                    <div class="w-full md:w-48">
                        <input type="password" name="signature_pin" placeholder="••••" value="1234" maxlength="4" class="w-full bg-slate-900/80 border border-securx-gold/40 text-securx-gold rounded-md py-3 px-4 text-center tracking-[0.5em] font-bold focus:ring-securx-gold focus:border-securx-gold">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Login Email</label>
                    <input type="email" name="email" value="dr.santos@amc.com.ph" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Username</label>
                    <input type="text" name="username" value="drjuansantos" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan" required>
                </div>
                
                <div class="md:col-span-2 border-t border-slate-700 pt-6 mt-2">
                    <p class="text-sm text-slate-400 mb-4">Leave the fields below blank if you do not wish to change your account password.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">New Password</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-securx-cyan focus:border-securx-cyan">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 pb-10">
            <button type="submit" class="glass-btn-primary py-3 px-10 text-lg shadow-[0_0_15px_rgba(28,181,209,0.3)] hover:-translate-y-1 transition-transform flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Save Configuration
            </button>
        </div>

    </form>
</div>
@endsection