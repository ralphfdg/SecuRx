<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white py-12">

    @php
        $role = request('role', 'patient');
    @endphp

    <div
        class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none fixed">
    </div>
    <div
        class="absolute bottom-[5%] right-[10%] w-[400px] h-[400px] bg-securx-gold/15 rounded-full blur-[120px] pointer-events-none fixed">
    </div>

    <div class="absolute top-6 right-6 md:top-8 md:right-8 z-20 fixed">
        <a href="{{ route('home') }}"
            class="px-4 py-2 bg-white/60 border border-gray-200 rounded-md text-sm font-semibold text-gray-500 hover:text-securx-navy hover:border-securx-cyan/30 hover:bg-white backdrop-blur-sm transition-all flex items-center gap-2 shadow-sm">
            &larr; Back to Home
        </a>
    </div>

    <div class="glass-panel p-8 md:p-12 z-10 mx-4 w-full max-w-5xl relative mt-12 md:mt-0">

        <div class="flex flex-col items-center mb-10 text-center border-b border-gray-200/60 pb-8">
            <div class="flex items-center gap-1 text-3xl font-extrabold tracking-tight mb-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx Logo"
                        class="h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>
            </div>

            @if ($role === 'doctor')
                <p class="text-securx-navy font-bold text-xl">Provider Registration</p>
                <p class="text-gray-500 font-medium text-sm mt-1">Register your clinical practice</p>
            @elseif($role === 'pharmacist')
                <p class="text-securx-navy font-bold text-xl">Pharmacy Registration</p>
                <p class="text-gray-500 font-medium text-sm mt-1">Join the dispensing network</p>
            @else
                <p class="text-securx-navy font-bold text-xl">Patient Registration</p>
                <p class="text-gray-500 font-medium text-sm mt-1">Create your secure medical profile</p>
            @endif
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-10">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <div class="space-y-5">
                    <h3
                        class="text-lg font-bold text-securx-navy border-b border-securx-cyan/30 pb-2 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Personal Information
                    </h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">First Name *</label>
                            <input type="text" name="first_name" class="glass-input w-full py-2 px-3" required
                                autofocus>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">Last Name *</label>
                            <input type="text" name="last_name" class="glass-input w-full py-2 px-3" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">Middle Name</label>
                            <input type="text" name="middle_name" class="glass-input w-full py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">Qualifier</label>
                            <select name="qualifier" class="glass-input w-full py-2 px-3">
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
                            <input type="date" name="dob" class="glass-input w-full py-2 px-3 text-gray-600"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">Gender *</label>
                            <select name="gender" class="glass-input w-full py-2 px-3 text-gray-600" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Mobile Number *</label>
                        <input type="tel" name="mobile_num" placeholder="+63 900 000 0000"
                            class="glass-input w-full py-2 px-3" required>
                    </div>
                </div>

                <div class="space-y-5">
                    <h3
                        class="text-lg font-bold text-securx-navy border-b border-securx-gold/40 pb-2 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-securx-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        @if ($role === 'doctor')
                            Clinical Authority
                        @elseif($role === 'pharmacist')
                            Facility Details
                        @else
                            Medical & Demographics
                        @endif
                    </h3>

                    @if ($role === 'doctor')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">PRC License *</label>
                                <input type="text" name="license_number" class="glass-input w-full py-2 px-3"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">PRC Expiration *</label>
                                <input type="date" name="license_expiration"
                                    class="glass-input w-full py-2 px-3 text-gray-600" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">PTR Number *</label>
                            <input type="text" name="ptr_number" class="glass-input w-full py-2 px-3" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">S2 Number</label>
                                <input type="text" name="s2_number" placeholder="(For dangerous drugs)"
                                    class="glass-input w-full py-2 px-3">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">S2 Expiration</label>
                                <input type="date" name="s2_expiration"
                                    class="glass-input w-full py-2 px-3 text-gray-600">
                            </div>
                        </div>
                    @elseif($role === 'pharmacist')
                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">Pharmacy Branch Name
                                *</label>
                            <input type="text" name="pharmacy_name" placeholder="e.g. Mercury Drug - Main"
                                class="glass-input w-full py-2 px-3" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">FDA LTO Number *</label>
                                <input type="text" name="lto_number" class="glass-input w-full py-2 px-3"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">LTO Expiration *</label>
                                <input type="date" name="lto_expiration"
                                    class="glass-input w-full py-2 px-3 text-gray-600" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">Business Address *</label>
                            <input type="text" name="business_address" class="glass-input w-full py-2 px-3"
                                required>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Height (cm) *</label>
                                <input type="number" name="height" placeholder="e.g. 170"
                                    class="glass-input w-full py-2 px-3" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-securx-navy mb-1.5">Weight (kg) *</label>
                                <input type="number" name="weight" placeholder="e.g. 65"
                                    class="glass-input w-full py-2 px-3" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">Full Address *</label>
                            <input type="text" name="address" class="glass-input w-full py-2 px-3" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-securx-navy mb-1.5">School / Workplace</label>
                            <input type="text" name="school_work" class="glass-input w-full py-2 px-3">
                        </div>

                        <div class="p-4 bg-white/50 border border-gray-200 rounded-lg mt-2 space-y-3">
                            <p class="text-xs font-bold text-securx-navy uppercase tracking-wider mb-2">Emergency /
                                Guardian Info</p>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="text" name="mother_name" placeholder="Mother's Name"
                                    class="glass-input w-full py-1.5 px-3 text-sm">
                                <input type="tel" name="mother_contact" placeholder="Mother's Contact"
                                    class="glass-input w-full py-1.5 px-3 text-sm">
                                <input type="text" name="father_name" placeholder="Father's Name"
                                    class="glass-input w-full py-1.5 px-3 text-sm">
                                <input type="tel" name="father_contact" placeholder="Father's Contact"
                                    class="glass-input w-full py-1.5 px-3 text-sm">
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <div class="mt-8 pt-8 border-t border-gray-200/60">
                <h3 class="text-lg font-bold text-securx-navy mb-6 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-securx-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                    Account Security Setup
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Email Address *</label>
                        <input type="email" name="email" class="glass-input w-full py-2.5 px-4" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Username *</label>
                        <input type="text" name="username" class="glass-input w-full py-2.5 px-4" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Password *</label>
                        <input type="password" name="password" class="glass-input w-full py-2.5 px-4" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-securx-navy mb-1.5">Confirm Password *</label>
                        <input type="password" name="password_confirmation" class="glass-input w-full py-2.5 px-4"
                            required>
                    </div>
                </div>

                @if ($role === 'doctor' || $role === 'pharmacist')
                    <div
                        class="mt-6 p-3 bg-securx-gold/10 border border-securx-gold/30 rounded-lg text-sm text-securx-gold font-semibold text-center max-w-3xl mx-auto">
                        * Note: Professional accounts require system administrator verification before prescribing or
                        dispensing access is granted.
                    </div>
                @endif

                <div class="max-w-md mx-auto mt-8 text-center">
                    <button type="submit" class="glass-btn-primary w-full text-lg py-3">
                        Submit Registration
                    </button>
                    <p class="mt-4 text-sm text-gray-500 font-medium">
                        Already registered? <a href="{{ route('login') }}"
                            class="text-securx-cyan hover:text-securx-navy font-bold transition-colors">Sign in
                            here</a>
                    </p>
                </div>
            </div>

        </form>
    </div>

</body>

</html>
