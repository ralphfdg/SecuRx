@extends('layouts.public')

@section('title', 'About the Architecture')

@section('content')
    <div class="relative w-full overflow-hidden bg-slate-50 min-h-screen">

        <div
            class="absolute top-[10%] left-[-10%] w-[500px] h-[500px] bg-securx-cyan/20 rounded-full mix-blend-multiply filter blur-3xl opacity-60 pointer-events-none">
        </div>
        <div
            class="absolute top-[40%] right-[-5%] w-96 h-96 bg-securx-navy/10 rounded-full mix-blend-multiply filter blur-3xl opacity-60 pointer-events-none">
        </div>
        <div
            class="absolute bottom-[-10%] left-[20%] w-[600px] h-[600px] bg-securx-gold/10 rounded-full mix-blend-multiply filter blur-[150px] opacity-60 pointer-events-none">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">

            <div class="text-center max-w-3xl mx-auto mb-20">
                <div
                    class="inline-block py-1.5 px-4 rounded-full bg-white/60 backdrop-blur-md border border-white/50 shadow-sm text-securx-cyan text-xs font-bold tracking-widest uppercase mb-6">
                    System Architecture
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-securx-navy mb-6 tracking-tight">
                    Decentralized Trust for <br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-securx-cyan to-blue-500">Modern
                        Pharmacies.</span>
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed font-medium">
                    SecuRx was engineered to solve a critical flaw in Philippine telehealth: the disconnect between digital
                    clinics and independent brick-and-mortar pharmacies. By moving away from centralized hardware
                    requirements, we empower any pharmacy to verify prescriptions securely.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-32">

                <div
                    class="bg-white/60 backdrop-blur-xl border border-white/50 shadow-xl rounded-3xl p-10 relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 w-40 h-40 bg-securx-cyan/10 rounded-full filter blur-3xl group-hover:bg-securx-cyan/20 transition-colors duration-500">
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-securx-navy to-securx-cyan flex items-center justify-center shadow-lg mb-8 relative z-10">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-securx-navy mb-4 relative z-10">The Cryptographic Engine</h3>
                    <p class="text-slate-600 leading-relaxed relative z-10">
                        Instead of sending paper prescriptions that can be forged, SecuRx generates a unique cryptographic
                        UUID for every encounter. This data is embedded into a high-density QR code, locking the patient,
                        doctor, and medication details into an immutable digital state.
                    </p>
                </div>

                <div
                    class="bg-white/60 backdrop-blur-xl border border-white/50 shadow-xl rounded-3xl p-10 relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 w-40 h-40 bg-securx-gold/10 rounded-full filter blur-3xl group-hover:bg-securx-gold/20 transition-colors duration-500">
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-400 to-securx-gold flex items-center justify-center shadow-lg mb-8 relative z-10">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-securx-navy mb-4 relative z-10">Offline-Ready Verification</h3>
                    <p class="text-slate-600 leading-relaxed relative z-10">
                        Pharmacies do not need to install complex desktop software or connect to a hospital's internal
                        server. Using the SecuRx Guest Portal, pharmacists can use any standard smartphone or webcam to scan
                        the QR code, instantly decrypting the authorization and logging the transaction against the
                        patient's record.
                    </p>
                </div>

            </div>

            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-securx-navy mb-4">The Capstone Team</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Developed by 3rd-year BSIT students at Angeles University
                    Foundation, dedicated to building software that solves real-world healthcare infrastructure challenges.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white/50 backdrop-blur-lg border border-white/60 shadow-lg rounded-2xl p-6 text-center hover:-translate-y-2 transition-transform duration-300">
                    <div
                        class="w-24 h-24 mx-auto rounded-full bg-slate-200 border-4 border-white shadow-md mb-4 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Ralph+De+Guzman&background=0D1B2A&color=fff"
                            alt="Ralph De Guzman" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-lg font-bold text-securx-navy">Ralph De Guzman</h4>
                    <p class="text-sm font-semibold text-securx-cyan mb-2">Lead Full-Stack Developer</p>
                    <p class="text-xs text-slate-500">Architected the cryptographic routing, database schema, and Laravel
                        backend infrastructure.</p>
                </div>

                <div
                    class="bg-white/50 backdrop-blur-lg border border-white/60 shadow-lg rounded-2xl p-6 text-center hover:-translate-y-2 transition-transform duration-300">
                    <div
                        class="w-24 h-24 mx-auto rounded-full bg-slate-200 border-4 border-white shadow-md mb-4 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Team+Member&background=f1f5f9&color=64748b"
                            alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-lg font-bold text-securx-navy">[Name Here]</h4>
                    <p class="text-sm font-semibold text-securx-gold mb-2">Project Manager / UI</p>
                    <p class="text-xs text-slate-500">Managed system requirements, frontend Tailwind implementation, and
                        UI/UX design workflows.</p>
                </div>

                <div
                    class="bg-white/50 backdrop-blur-lg border border-white/60 shadow-lg rounded-2xl p-6 text-center hover:-translate-y-2 transition-transform duration-300">
                    <div
                        class="w-24 h-24 mx-auto rounded-full bg-slate-200 border-4 border-white shadow-md mb-4 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Team+Member&background=f1f5f9&color=64748b"
                            alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-lg font-bold text-securx-navy">[Name Here]</h4>
                    <p class="text-sm font-semibold text-securx-navy mb-2">Systems Analyst</p>
                    <p class="text-xs text-slate-500">Designed the clinical workflows, Drug Utilization Review rules, and
                        DOH/NIH API integrations.</p>
                </div>

                <div
                    class="bg-white/50 backdrop-blur-lg border border-white/60 shadow-lg rounded-2xl p-6 text-center hover:-translate-y-2 transition-transform duration-300">
                    <div
                        class="w-24 h-24 mx-auto rounded-full bg-slate-200 border-4 border-white shadow-md mb-4 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Team+Member&background=f1f5f9&color=64748b"
                            alt="Team Member" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-lg font-bold text-securx-navy">[Name Here]</h4>
                    <p class="text-sm font-semibold text-slate-600 mb-2">QA & Documentation</p>
                    <p class="text-xs text-slate-500">Handled system testing, security vulnerability auditing, and capstone
                        manuscript preparation.</p>
                </div>

            </div>

        </div>
    </div>
@endsection
