@extends('layouts.public')

@section('title', 'Help Center & FAQ')

@section('content')
<div class="flex flex-col items-center max-w-4xl mx-auto w-full">
    
    <div class="text-center mb-12 mt-8">
        <div class="inline-block py-1.5 px-4 rounded-full bg-securx-cyan/10 border border-securx-cyan/20 text-securx-cyan text-xs font-bold tracking-widest uppercase mb-4">
            Support Center
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-securx-navy mb-4 tracking-tight">
            Frequently Asked Questions
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Learn how to navigate the SecuRx network, whether you are issuing, receiving, or dispensing a digital prescription.
        </p>
    </div>

    <div class="w-full space-y-4">
        
        <details class="group glass-panel bg-white/80 [&_summary::-webkit-details-marker]:hidden">
            <summary class="flex items-center justify-between p-6 cursor-pointer text-securx-navy font-bold text-lg list-none">
                <span>Do patients need an internet connection to use their prescription?</span>
                <span class="transition duration-300 group-open:-rotate-180 text-securx-cyan">
                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                </span>
            </summary>
            <div class="p-6 pt-0 text-gray-600 leading-relaxed border-t border-gray-100 mt-2">
                No. SecuRx is designed for offline portability. Patients can save their unique QR code to their phone's photo gallery or print it on a piece of paper. The cryptographic UUID is embedded directly in the image, allowing the pharmacist to scan and verify it even if the patient's phone is completely offline.
            </div>
        </details>

        <details class="group glass-panel bg-white/80 [&_summary::-webkit-details-marker]:hidden">
            <summary class="flex items-center justify-between p-6 cursor-pointer text-securx-navy font-bold text-lg list-none">
                <span>How does the system prevent medication hoarding?</span>
                <span class="transition duration-300 group-open:-rotate-180 text-securx-cyan">
                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                </span>
            </summary>
            <div class="p-6 pt-0 text-gray-600 leading-relaxed border-t border-gray-100 mt-2">
                SecuRx utilizes a built-in Drug Utilization Review (DUR) engine. When a pharmacist scans a QR code, the system cross-references the central database. If a patient attempts to refill a prescription before the authorized timeframe (e.g., trying to claim a 30-day supply on day 15), the system will flag it as a "Refill Too Soon" and require pharmacist override logic.
            </div>
        </details>

        <details class="group glass-panel bg-white/80 [&_summary::-webkit-details-marker]:hidden">
            <summary class="flex items-center justify-between p-6 cursor-pointer text-securx-navy font-bold text-lg list-none">
                <span>What hardware do pharmacies need to join the network?</span>
                <span class="transition duration-300 group-open:-rotate-180 text-securx-cyan">
                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                </span>
            </summary>
            <div class="p-6 pt-0 text-gray-600 leading-relaxed border-t border-gray-100 mt-2">
                Absolutely none. SecuRx is entirely web-based. Any independent pharmacy can log into the Pharmacist Portal using a standard web browser on a laptop, tablet, or smartphone. The portal uses the device's native camera to scan the patient's QR code.
            </div>
        </details>

        <details class="group glass-panel bg-white/80 [&_summary::-webkit-details-marker]:hidden">
            <summary class="flex items-center justify-between p-6 cursor-pointer text-securx-navy font-bold text-lg list-none">
                <span>Can a doctor revoke a prescription if they made a mistake?</span>
                <span class="transition duration-300 group-open:-rotate-180 text-securx-cyan">
                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                </span>
            </summary>
            <div class="p-6 pt-0 text-gray-600 leading-relaxed border-t border-gray-100 mt-2">
                Yes. Doctors have full control over their active prescriptions via the Doctor Dashboard. If an error is made in dosage, the doctor can instantly invalidate the UUID. If a patient attempts to present the revoked QR code to a pharmacy, the scanner will throw a critical "Invalid/Revoked" alert.
            </div>
        </details>

    </div>

    <div class="mt-12 text-center">
        <p class="text-gray-600 mb-4">Still have questions?</p>
        <a href="{{ route('contact') }}" class="glass-btn-primary px-8">Contact System Admin</a>
    </div>

</div>
@endsection