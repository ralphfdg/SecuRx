@extends('layouts.public')

@section('title', 'Privacy Policy')

@section('content')
<div class="flex flex-col items-center max-w-4xl mx-auto w-full">
    
    <div class="text-center mb-12 mt-8">
        <h1 class="text-4xl font-extrabold text-securx-navy mb-4 tracking-tight">
            Privacy Policy
        </h1>
        <p class="text-sm text-gray-500 font-medium">
            Effective Date: {{ date('F d, Y') }} | Compliant with Republic Act No. 10173 (Data Privacy Act of 2012)
        </p>
    </div>

    <div class="glass-panel bg-white/90 p-8 md:p-12 w-full text-gray-700 leading-relaxed space-y-8 text-sm md:text-base">
        
        <section>
            <h2 class="text-xl font-bold text-securx-navy mb-3">1. Introduction</h2>
            <p>
                Welcome to SecuRx. We are committed to protecting your personal and medical data. This Privacy Policy outlines how we collect, process, cryptographically secure, and store your information when you use our decentralized prescription network. By accessing the SecuRx portal, you consent to the practices described in this document.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-securx-navy mb-3">2. Information We Collect</h2>
            <ul class="list-disc pl-6 space-y-2 text-gray-600 marker:text-securx-cyan">
                <li><strong>Medical Practitioners:</strong> Professional License Numbers (PRC), clinic affiliations, and digital signature data for identity verification.</li>
                <li><strong>Patients:</strong> Name, contact information, known allergies, and active prescription records linked to dynamic UUIDs.</li>
                <li><strong>Pharmacists:</strong> Dispensing logs, terminal access locations, and override justification notes.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-securx-navy mb-3">3. Cryptographic Data Handling</h2>
            <p>
                SecuRx does not distribute raw medical files over unverified channels. Instead, prescriptions are converted into a mathematically secure <strong>Universally Unique Identifier (UUID)</strong>. The QR code provided to the patient contains only this encrypted identifier. Medical details are only decrypted and displayed when a verified pharmacist scans the code within our secure, authenticated portal.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-securx-navy mb-3">4. Drug Utilization Telemetry</h2>
            <p>
                To prevent medication hoarding and abuse, SecuRx actively logs dispensing timestamps and refill counts. This telemetry is shared strictly between partnered pharmacies via the DUR engine to enforce "Max Refill" limits established by the prescribing physician.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-securx-navy mb-3">5. Data Retention & System Audits</h2>
            <p>
                All prescription state changes (generation, scanning, dispensing, revocation) are recorded in an immutable ledger by the System Administrator. Data is retained for the period legally required by the Department of Health (DOH) before being securely archived or purged from active databases.
            </p>
        </section>

        <hr class="border-gray-200">

        <section class="text-center text-gray-500 text-sm">
            <p>If you have questions regarding our data security practices or wish to request an audit of your data, please contact our Data Protection Officer (DPO) at <a href="mailto:privacy@securx.test" class="text-securx-cyan hover:underline">privacy@securx.test</a>.</p>
        </section>

    </div>
</div>
@endsection