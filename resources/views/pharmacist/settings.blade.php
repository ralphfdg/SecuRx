@extends('layouts.pharmacist')

@section('page_title', 'Account & Security')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-12">

    <div class="p-6 bg-white/60 backdrop-blur-md border border-gray-200/50 rounded-2xl shadow-sm flex items-center gap-5">
        <div class="w-14 h-14 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 border border-emerald-100 flex-shrink-0 shadow-inner">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
            <h2 class="text-2xl font-extrabold text-securx-navy tracking-tight">Dispensary Profile</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">
                Manage your login credentials, demographics, and view your officially verified registered pharmacist (RPh) status.
            </p>
        </div>
    </div>

    <form action="#" method="POST" class="space-y-8">
        @csrf

        <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm relative overflow-hidden">
            
            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
                <h3 class="text-lg font-black text-securx-navy flex items-center gap-2 relative z-10">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Pharmacist Authority
                </h3>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] uppercase tracking-widest font-black flex items-center gap-1.5 shadow-sm">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> 
                    FDA / PRC Verified
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <div class="md:col-span-2 opacity-75">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Registered Pharmacy Name</label>
                    <input type="text" name="pharmacy_name" value="Mercury Drug - Angeles City Main" class="w-full bg-gray-50 border border-gray-200 text-gray-600 font-bold rounded-xl py-3 px-4 cursor-not-allowed select-none" disabled>
                </div>
                
                <div class="md:col-span-2 opacity-75">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Business Address</label>
                    <textarea name="business_address" class="w-full bg-gray-50 border border-gray-200 text-gray-600 font-bold rounded-xl py-3 px-4 h-20 resize-none cursor-not-allowed select-none" disabled>Sto. Rosario St, Angeles, 2009 Pampanga</textarea>
                </div>

                <div class="opacity-75">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">FDA LTO Number</label>
                    <input type="text" name="lto_number" value="CDRR-R3-DS-12345" class="w-full bg-gray-50 border border-gray-200 text-gray-600 font-mono font-bold rounded-xl py-3 px-4 cursor-not-allowed select-none" disabled>
                </div>
                <div class="opacity-75">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">LTO Expiration Date</label>
                    <input type="date" name="lto_expiration" value="2028-12-31" class="w-full bg-gray-50 border border-gray-200 text-gray-600 font-bold rounded-xl py-3 px-4 cursor-not-allowed select-none" disabled>
                </div>
            </div>
            
            <div class="mt-6 flex items-start gap-2 bg-blue-50/50 border border-blue-100 p-3 rounded-lg">
                <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-[11px] text-blue-800 font-medium italic">Core regulatory credentials and branch assignments must be updated by a branch manager or system administrator.</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm">
            <h3 class="text-lg font-black text-securx-navy border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Personal Demographics
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">First Name</label>
                    <input type="text" name="first_name" value="Maria" class="w-full bg-slate-50 border border-gray-200 text-gray-900 font-medium rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner" required>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Middle Name</label>
                    <input type="text" name="middle_name" value="" class="w-full bg-slate-50 border border-gray-200 text-gray-900 font-medium rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Last Name</label>
                    <input type="text" name="last_name" value="Reyes" class="w-full bg-slate-50 border border-gray-200 text-gray-900 font-medium rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner" required>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Qualifier (Jr, Sr)</label>
                    <input type="text" name="qualifier" class="w-full bg-slate-50 border border-gray-200 text-gray-900 font-medium rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Gender</label>
                    <select name="gender" class="w-full bg-slate-50 border border-gray-200 text-gray-900 font-medium rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner" required>
                        <option value="Female" selected>Female</option>
                        <option value="Male">Male</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Date of Birth</label>
                    <input type="date" name="dob" value="1985-04-12" class="w-full bg-slate-50 border border-gray-200 text-gray-900 font-medium rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner" required>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-sm">
            <h3 class="text-lg font-black text-securx-navy border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Authentication Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Login Email</label>
                    <input type="email" name="email" value="m.reyes@mercurydrug.com" class="w-full bg-slate-50 border border-gray-200 text-gray-900 font-medium rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner" required>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Username</label>
                    <input type="text" name="username" value="mreyes_rph" class="w-full bg-slate-50 border border-gray-200 text-gray-900 font-mono font-bold rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Mobile Number</label>
                    <input type="text" name="mobile_num" value="0917-888-1234" class="w-full bg-slate-50 border border-gray-200 text-gray-900 font-medium rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner" required>
                </div>
                
                <div class="md:col-span-2 border-t border-gray-100 pt-6 mt-2">
                    <p class="text-sm font-bold text-securx-navy mb-1">Change Password</p>
                    <p class="text-[11px] text-gray-500 font-medium mb-4">Leave the fields below blank if you do not wish to change your account password.</p>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">New Password</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-50 border border-gray-200 text-gray-900 rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wider mb-1.5">Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full bg-slate-50 border border-gray-200 text-gray-900 rounded-xl py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 shadow-inner">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 pb-10">
            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-[0_4px_14px_0_rgba(16,185,129,0.39)] hover:-translate-y-1 py-3 px-10 text-base transition-all duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Save Account Changes
            </button>
        </div>

    </form>
</div>
@endsection