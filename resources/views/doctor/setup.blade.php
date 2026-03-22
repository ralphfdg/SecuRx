<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Provider Setup - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white py-12">

    <div class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none fixed"></div>
    <div class="absolute bottom-[5%] right-[10%] w-[400px] h-[400px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none fixed"></div>

    <div class="glass-panel p-8 md:p-12 z-10 mx-4 w-full max-w-4xl relative">
        
        <div class="flex flex-col items-center mb-8 text-center border-b border-gray-200/60 pb-8">
            <div class="w-16 h-16 bg-securx-navy/10 rounded-full flex items-center justify-center text-securx-navy mb-4 border border-securx-navy/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-securx-navy mb-2">Complete Your Clinical Profile</h1>
            <p class="text-gray-500 font-medium text-sm max-w-lg">
                Your account is verified! Before issuing prescriptions, please finalize your public directory listing so partnered pharmacies can verify your active practice.
            </p>
        </div>

        <form method="POST" action="#" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-securx-navy border-b border-securx-cyan/30 pb-2 flex items-center gap-2">
                        Professional Specialty
                    </h3>

                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Primary Specialization *</label>
                        <select name="specialization" class="glass-input w-full py-2.5 px-3 text-gray-700" required>
                            <option value="" disabled selected>Select Specialization...</option>
                            <option value="General Practice">General Practice</option>
                            <option value="Internal Medicine">Internal Medicine</option>
                            <option value="Cardiology">Cardiology</option>
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Psychiatry">Psychiatry</option>
                            <option value="Neurology">Neurology</option>
                            </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Sub-Specialty (Optional)</label>
                        <input type="text" name="sub_specialty" placeholder="e.g. Interventional Cardiology" class="glass-input w-full py-2.5 px-3">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Consultation Prefix *</label>
                        <select name="title_prefix" class="glass-input w-full py-2.5 px-3 text-gray-700" required>
                            <option value="Dr.">Dr. (Medical Doctor)</option>
                            <option value="DMD">DMD (Dentist)</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-securx-navy border-b border-securx-gold/40 pb-2 flex items-center gap-2">
                        Primary Affiliation / Clinic
                    </h3>

                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Clinic or Hospital Name *</label>
                        <input type="text" name="clinic_name" placeholder="e.g. Angeles Medical Center" class="glass-input w-full py-2.5 px-3" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Clinic Address *</label>
                        <input type="text" name="clinic_address" class="glass-input w-full py-2.5 px-3" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Clinic Contact Number *</label>
                        <input type="tel" name="clinic_contact" placeholder="For pharmacy verification calls" class="glass-input w-full py-2.5 px-3" required>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-200/60 text-center">
                <button type="submit" class="glass-btn-primary w-full md:w-auto md:px-12 text-lg py-3">
                    Save Profile & Enter Dashboard
                </button>
            </div>
        </form>
    </div>
</body>
</html>