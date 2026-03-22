@extends('layouts.public')

@section('title', 'Accessibility Statement')

@section('content')
<div class="flex flex-col items-center max-w-4xl mx-auto w-full">
    
    <div class="text-center mb-12 mt-8">
        <div class="inline-block py-1.5 px-4 rounded-full bg-securx-cyan/10 border border-securx-cyan/20 text-securx-cyan text-xs font-bold tracking-widest uppercase mb-4">
            Inclusive Design
        </div>
        <h1 class="text-4xl font-extrabold text-securx-navy mb-4 tracking-tight">
            Accessibility Statement
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Healthcare technology must be usable by everyone, regardless of their physical abilities, socioeconomic status, or internet connectivity.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full mb-12">
        
        <div class="glass-panel p-8 bg-white/80">
            <div class="w-12 h-12 rounded-xl bg-securx-cyan/10 flex items-center justify-center text-securx-cyan mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-securx-navy mb-3">Offline-First Portability</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                We recognize that not all patients have reliable mobile data or smartphones. SecuRx is intentionally designed so that prescriptions can be printed on physical paper. The cryptographic verification happens entirely on the pharmacy's scanner, ensuring the system remains accessible to elderly populations and those in rural areas.
            </p>
        </div>

        <div class="glass-panel p-8 bg-white/80">
            <div class="w-12 h-12 rounded-xl bg-securx-gold/15 flex items-center justify-center text-securx-gold mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-securx-navy mb-3">High-Contrast UI</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                Our interface utilizes "Clinical Light" aesthetics with deep navy typography to exceed WCAG (Web Content Accessibility Guidelines) contrast ratios. This reduces eye strain for pharmacists operating the scanner during long shifts and assists patients with visual impairments.
            </p>
        </div>

    </div>

    <div class="glass-panel p-8 md:p-12 w-full text-center bg-white/90">
        <h2 class="text-2xl font-bold text-securx-navy mb-4">Ongoing Commitment</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-6">
            Our development team continuously tests the SecuRx portal with standard screen readers and keyboard navigation tools to ensure that medical professionals with motor or visual disabilities can seamlessly issue and dispense prescriptions.
        </p>
        <p class="text-sm text-gray-500 font-medium border-t border-gray-200 pt-6">
            If you experience any barriers while using our network, please reach out to <span class="text-securx-cyan">accessibility@securx.test</span>.
        </p>
    </div>

</div>
@endsection