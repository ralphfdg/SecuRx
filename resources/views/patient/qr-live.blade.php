@extends('layouts.patient')

@section('page_title', 'My Live QR Code')

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="mb-6 p-4 bg-securx-cyan/10 border border-securx-cyan/20 rounded-xl flex items-start gap-4 shadow-sm">
        <div class="mt-0.5 text-securx-cyan">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-securx-navy">Your Master Prescription Key</h4>
            <p class="text-sm text-gray-600 mt-1">This single QR code contains your secure cryptographic UUID. Present this screen to any partnered pharmacy to access your active prescriptions. Do not share this online.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-7">
            <div class="glass-panel p-8 md:p-12 flex flex-col items-center bg-white/80 text-center relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-32 h-32 bg-securx-cyan/5 rounded-bl-full"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-securx-gold/10 rounded-tr-full"></div>

                <h2 class="text-2xl font-extrabold text-securx-navy mb-2 relative z-10">Ralph De Guzman</h2>
                <p class="text-gray-500 font-mono text-sm mb-8 relative z-10">UUID: 8F92A-4B7C1-9D2E3</p>

                <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-100 mb-8 relative z-10 hover:scale-105 transition-transform duration-300">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=SecuRx:8F92A-4B7C1-9D2E3&color=0B1120" alt="Patient QR Code" class="w-56 h-56 md:w-64 md:h-64 object-contain">
                </div>

                <div class="flex items-center gap-2 text-green-600 bg-green-50 px-4 py-2 rounded-full border border-green-200 font-bold text-sm relative z-10">
                    <span class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></span>
                    Key Active & Ready to Scan
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 space-y-6">
            
            <div class="glass-panel p-6 bg-white/60">
                <h3 class="text-lg font-bold text-securx-navy mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-securx-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Offline Portability
                </h3>
                <p class="text-sm text-gray-600 mb-5 leading-relaxed">
                    No smartphone? Low battery? Print a wallet-sized physical copy of your SecuRx ID. The pharmacy can scan the paper directly.
                </p>
                <a href="{{ route('patient.qr-print') }}" target="_blank" class="glass-btn-secondary w-full flex justify-center py-2.5 text-sm">
                    Generate Printable Card &rarr;
                </a>
            </div>

            <div class="glass-panel p-6 bg-white/60">
                <h3 class="text-lg font-bold text-securx-navy mb-4">How it works</h3>
                <ol class="space-y-4 relative border-l-2 border-securx-cyan/20 ml-3">
                    <li class="pl-6 relative">
                        <div class="absolute w-4 h-4 bg-white border-2 border-securx-cyan rounded-full -left-[9px] top-0.5"></div>
                        <p class="font-bold text-sm text-securx-navy">Visit Pharmacy</p>
                        <p class="text-xs text-gray-500 mt-0.5">Go to any SecuRx partnered branch.</p>
                    </li>
                    <li class="pl-6 relative">
                        <div class="absolute w-4 h-4 bg-white border-2 border-securx-gold rounded-full -left-[9px] top-0.5"></div>
                        <p class="font-bold text-sm text-securx-navy">Present QR Code</p>
                        <p class="text-xs text-gray-500 mt-0.5">Show this screen or your printed card to the pharmacist.</p>
                    </li>
                    <li class="pl-6 relative">
                        <div class="absolute w-4 h-4 bg-white border-2 border-securx-navy rounded-full -left-[9px] top-0.5"></div>
                        <p class="font-bold text-sm text-securx-navy">Instant Decryption</p>
                        <p class="text-xs text-gray-500 mt-0.5">They will scan it to securely view your active prescriptions and dispense medication.</p>
                    </li>
                </ol>
            </div>

        </div>
    </div>
</div>
@endsection