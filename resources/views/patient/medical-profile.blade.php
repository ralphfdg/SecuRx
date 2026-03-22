@extends('layouts.patient')

@section('page_title', 'Medical Profile')

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="mb-8 p-6 bg-[#0B1120] border border-white/10 rounded-2xl shadow-xl flex items-center gap-5 text-gray-200">
        <div class="w-14 h-14 bg-securx-cyan/20 rounded-full flex items-center justify-center text-securx-cyan border border-securx-cyan/30">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
        </div>
        <div>
            <h2 class="text-2xl font-extrabold text-white">Clinical Baseline</h2>
            <p class="text-sm text-gray-400 mt-1">This information is securely encrypted and only shared with verified pharmacists and your prescribing physicians to prevent adverse drug reactions.</p>
        </div>
    </div>

    <form action="#" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-[#0B1120] border border-white/10 rounded-2xl p-6 shadow-lg text-gray-200">
                <h3 class="text-lg font-bold text-white border-b border-white/10 pb-3 mb-5 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-securx-cyan"></span> Biometrics
                </h3>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-1.5">Blood Type</label>
                        <select name="blood_type" class="w-full bg-black/40 border border-white/10 text-gray-100 rounded-md py-2.5 px-3 focus:ring-securx-cyan focus:border-securx-cyan transition-colors">
                            <option value="">Unknown</option>
                            <option value="A+">A+</option>
                            <option value="O+">O+</option>
                            <option value="B+">B+</option>
                            <option value="AB+">AB+</option>
                            <option value="A-">A-</option>
                            <option value="O-">O-</option>
                            <option value="B-">B-</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-1.5">Organ Donor Status</label>
                        <select name="organ_donor" class="w-full bg-black/40 border border-white/10 text-gray-100 rounded-md py-2.5 px-3 focus:ring-securx-cyan focus:border-securx-cyan transition-colors">
                            <option value="no">Opted Out</option>
                            <option value="yes">Registered Donor</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-[#0B1120] border border-white/10 rounded-2xl p-6 shadow-lg text-gray-200">
                <h3 class="text-lg font-bold text-white border-b border-white/10 pb-3 mb-5 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Known Allergies
                </h3>
                
                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-1.5">Medication & Food Allergies</label>
                    <textarea name="allergies" rows="3" placeholder="e.g., Penicillin, Peanuts, Latex. Leave blank if none." class="w-full bg-black/40 border border-white/10 text-gray-100 rounded-md py-2.5 px-3 focus:ring-red-500 focus:border-red-500 transition-colors"></textarea>
                    <p class="text-xs text-gray-500 mt-2">Separate multiple entries with commas.</p>
                </div>
            </div>

            <div class="bg-[#0B1120] border border-white/10 rounded-2xl p-6 shadow-lg md:col-span-2 text-gray-200">
                <h3 class="text-lg font-bold text-white border-b border-white/10 pb-3 mb-5 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-securx-gold"></span> Chronic Medical Conditions
                </h3>
                
                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-1.5">Pre-existing Conditions</label>
                    <textarea name="conditions" rows="3" placeholder="e.g., Type 2 Diabetes, Hypertension, Asthma." class="w-full bg-black/40 border border-white/10 text-gray-100 rounded-md py-2.5 px-3 focus:ring-securx-gold focus:border-securx-gold transition-colors"></textarea>
                </div>
            </div>

        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-securx-cyan hover:bg-cyan-500 text-white font-bold py-3 px-8 rounded-lg shadow-[0_0_15px_rgba(28,181,209,0.4)] transition-all">
                Update Clinical Profile
            </button>
        </div>
    </form>
</div>
@endsection