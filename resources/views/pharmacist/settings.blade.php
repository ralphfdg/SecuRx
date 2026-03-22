@extends('layouts.pharmacist')

@section('page_title', 'Account & Security')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <div class="p-6 bg-slate-800 border border-slate-700 rounded-2xl shadow-lg flex items-center gap-5 text-slate-200">
        <div class="w-14 h-14 bg-emerald-500/10 rounded-full flex items-center justify-center text-emerald-500 border border-emerald-500/20 flex-shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Dispensary Profile</h2>
            <p class="text-sm text-slate-400 mt-1">
                Manage your login credentials and view your officially verified registered pharmacist (RPh) status.
            </p>
        </div>
    </div>

    <form action="#" method="POST" class="space-y-8">
        @csrf

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 md:p-8 shadow-lg relative overflow-hidden">
            
            <div class="flex items-center justify-between border-b border-slate-700 pb-3 mb-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-2 relative z-10">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Pharmacist Authority
                </h3>
                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-full text-xs font-bold flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> FDA / PRC Verified
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <div>
                    <label class="block text-sm font-bold text-slate-400 mb-1.5">Full Name</label>
                    <input type="text" value="Maria Reyes, RPh" class="w-full bg-slate-900/30 border border-slate-700 text-slate-500 rounded-md py-2.5 px-4 cursor-not-allowed" disabled>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-400 mb-1.5">PRC License Number</label>
                    <input type="text" value="9988776" class="w-full bg-slate-900/30 border border-slate-700 text-slate-500 rounded-md py-2.5 px-4 cursor-not-allowed" disabled>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-400 mb-1.5">Active Dispensary Branch</label>
                    <input type="text" value="Mercury Drug - Angeles Main (LTO: CDRR-R3-DS-12345)" class="w-full bg-slate-900/30 border border-slate-700 text-slate-500 rounded-md py-2.5 px-4 cursor-not-allowed" disabled>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4 italic">* Core regulatory credentials and branch assignments must be updated by a branch manager or system administrator.</p>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 md:p-8 shadow-lg">
            <h3 class="text-lg font-bold text-white border-b border-slate-700 pb-3 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Authentication Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Login Email</label>
                    <input type="email" name="email" value="m.reyes@mercurydrug.com" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-emerald-500 focus:border-emerald-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Username</label>
                    <input type="text" name="username" value="mreyes_rph" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-emerald-500 focus:border-emerald-500" required>
                </div>
                
                <div class="md:col-span-2 border-t border-slate-700 pt-6 mt-2">
                    <p class="text-sm text-slate-400 mb-4">Leave the fields below blank if you do not wish to change your account password.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">New Password</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-1.5">Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full bg-slate-900/50 border border-slate-600 text-slate-200 rounded-md py-2.5 px-4 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 pb-10">
            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-lg shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] py-3 px-10 text-lg hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Save Account Changes
            </button>
        </div>

    </form>
</div>
@endsection