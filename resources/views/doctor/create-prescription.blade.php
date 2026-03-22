@extends('layouts.doctor')

@section('page_title', 'Issue Secure Prescription')

@section('content')
<div class="max-w-4xl mx-auto">

    <div id="prescription-form-container" class="glass-panel p-8 bg-white/80 transition-all duration-500">
        
        <div class="mb-8 border-b border-gray-200 pb-6 flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Generate New e-Prescription</h2>
                <p class="text-sm text-gray-500 mt-1">Fill out the details below. A cryptographic UUID QR code will be generated for the patient.</p>
            </div>
            <div class="w-12 h-12 bg-securx-cyan/10 rounded-full flex items-center justify-center text-securx-cyan">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
        </div>

        <form id="mock-prescription-form" class="space-y-6" onsubmit="generatePresentationQR(event)">
            
            <div>
                <label class="block text-sm font-bold text-securx-navy mb-1.5">Select Patient *</label>
                <select id="patient_name" class="glass-input w-full py-2.5 px-4" required>
                    <option value="" disabled selected>Search directory...</option>
                    <option value="Ralph De Guzman">Ralph De Guzman (DOB: Jan 15, 2005)</option>
                    <option value="Maria Clara">Maria Clara (DOB: Oct 02, 1990)</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Medication Name & Strength *</label>
                    <input type="text" id="medication" placeholder="e.g. Amoxicillin 500mg" class="glass-input w-full py-2.5 px-4" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Dosage / Sig *</label>
                    <input type="text" placeholder="e.g. Take 1 capsule 3x a day" class="glass-input w-full py-2.5 px-4" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Duration *</label>
                    <input type="text" placeholder="e.g. 7 days" class="glass-input w-full py-2.5 px-4" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Quantity to Dispense *</label>
                    <input type="number" placeholder="e.g. 21" class="glass-input w-full py-2.5 px-4" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-securx-navy mb-1.5">Refills Allowed</label>
                    <input type="number" value="0" class="glass-input w-full py-2.5 px-4" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-securx-navy mb-1.5">Doctor's Notes (Optional)</label>
                <textarea rows="2" placeholder="Instructions for pharmacist or patient..." class="glass-input w-full py-2.5 px-4"></textarea>
            </div>

            <div class="p-4 bg-securx-cyan/5 border border-securx-cyan/20 rounded-xl mt-4">
                <label class="block text-sm font-bold text-securx-navy mb-1.5">Digital Signature PIN *</label>
                <div class="flex gap-4 items-center">
                    <input type="password" placeholder="••••" class="glass-input w-32 py-2.5 px-4 text-center tracking-widest font-bold" maxlength="4" required>
                    <span class="text-xs text-gray-500 font-medium">Verify identity to cryptographically sign this record.</span>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="glass-btn-primary py-3 px-8 text-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Sign & Generate QR Key
                </button>
            </div>
        </form>
    </div>

    <div id="qr-success-container" class="hidden glass-panel p-10 bg-white/90 text-center transition-all duration-500 mt-6 border-t-4 border-t-green-500">
        
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-500 mx-auto mb-4 border-2 border-green-200">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        
        <h2 class="text-2xl font-extrabold text-securx-navy mb-2">Prescription Cryptographically Signed</h2>
        <p class="text-sm text-gray-500 mb-8">This prescription has been securely transmitted to the patient's portal.</p>

        <div class="bg-white p-4 inline-block rounded-xl border border-gray-200 shadow-md mb-6 relative">
            <img id="generated-qr-image" src="" alt="Secure UUID QR Code" class="w-48 h-48">
            <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-securx-navy text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest whitespace-nowrap">
                UUID: <span id="display-uuid"></span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 max-w-sm mx-auto text-sm text-left bg-gray-50 p-4 rounded-lg border border-gray-100 mb-8">
            <div class="text-gray-500 font-bold">Patient:</div>
            <div class="text-securx-navy font-bold text-right" id="display-patient"></div>
            <div class="text-gray-500 font-bold">Drug:</div>
            <div class="text-securx-navy font-bold text-right" id="display-drug"></div>
        </div>

        <div class="flex justify-center gap-4">
            <button onclick="resetForm()" class="glass-btn-secondary py-2.5 px-6">Issue Another</button>
            <a href="#" class="glass-btn-primary py-2.5 px-6">Return to Dashboard</a>
        </div>
    </div>

</div>

<script>
    function generatePresentationQR(event) {
        event.preventDefault(); // Stop page reload

        // 1. Grab values from the form
        const patientName = document.getElementById('patient_name').value;
        const medication = document.getElementById('medication').value || "Medication";
        
        // 2. Generate a fake UUID for the presentation
        const mockUUID = Math.random().toString(36).substring(2, 7).toUpperCase() + '-' + Math.random().toString(36).substring(2, 7).toUpperCase();
        
        // 3. Update the Success UI
        document.getElementById('display-patient').innerText = patientName;
        document.getElementById('display-drug').innerText = medication;
        document.getElementById('display-uuid').innerText = mockUUID;
        
        // Use an external API to generate a real, scannable QR code based on the UUID
        document.getElementById('generated-qr-image').src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=SecuRx:Prescription:${mockUUID}&color=0F172A`;

        // 4. Hide Form, Show Success State smoothly
        const formDiv = document.getElementById('prescription-form-container');
        const successDiv = document.getElementById('qr-success-container');
        
        formDiv.classList.add('opacity-50', 'pointer-events-none'); // Dim the form
        successDiv.classList.remove('hidden');
        
        // Scroll down slightly so panel can see the QR code
        setTimeout(() => {
            successDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    function resetForm() {
        document.getElementById('mock-prescription-form').reset();
        document.getElementById('qr-success-container').classList.add('hidden');
        document.getElementById('prescription-form-container').classList.remove('opacity-50', 'pointer-events-none');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection