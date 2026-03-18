@extends('layouts.master')

@section('header', 'Pharmacy Dispatch')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pharmacist Dashboard - Image Scanner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">1. Upload QR Code Image</h3>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select SecuRx QR Code</label>
                        <input type="file" id="qr-upload" accept="image/*" class="block w-full text-sm text-gray-500 
                            file:mr-4 file:py-2 file:px-4 
                            file:rounded-md file:border-0 
                            file:text-sm file:font-semibold 
                            file:bg-blue-600 file:text-white 
                            hover:file:bg-blue-700 transition duration-150 mx-auto">
                    </div>

                    <div id="file-reader" style="display: none;"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">2. Verification Details</h3>
                    
                    <div id="idle-state" class="text-gray-400 text-center py-16">
                        Awaiting Image Upload...
                    </div>

                    <div id="loading-state" class="hidden text-blue-500 font-bold animate-pulse text-center py-16">
                        Decrypting QR Token...
                    </div>

                    <div id="data-state" class="hidden">
                        <div id="warnings-container" class="mb-4"></div>

                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 text-sm">
                            <p class="mb-2"><strong class="text-gray-700">Patient:</strong> <span id="res-patient" class="text-lg font-semibold text-blue-700"></span></p>
                            <hr class="my-2">
                            <p class="mb-2"><strong class="text-gray-700">Medication:</strong> <span id="res-med"></span></p>
                            <p class="mb-2"><strong class="text-gray-700">Instructions:</strong> <span id="res-inst"></span></p>
                            <p class="mb-2"><strong class="text-gray-700">Doctor:</strong> <span id="res-doc"></span></p>
                            <p><strong class="text-gray-700">Refill Status:</strong> <span id="res-refill" class="font-mono bg-blue-100 px-2 py-1 rounded"></span></p>
                        </div>

                        <form action="{{ route('pharmacist.dispense') }}" method="POST" class="mt-6" id="dispense-form">
                            @csrf
                            <input type="hidden" name="prescription_id" id="form-prescription-id" value="">
                            <button type="submit" id="dispense-btn" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded transition duration-150">
                                Dispense & Log Medication
                            </button>
                        </form>
                        
                        <button onclick="resetScanner()" class="w-full mt-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded transition duration-150">
                            Clear Data
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        // Initialize the scanner on the hidden div
        const html5QrCode = new Html5Qrcode("file-reader");

        document.getElementById('qr-upload').addEventListener('change', function(e) {
            if (e.target.files.length === 0) { return; }
            
            const imageFile = e.target.files[0];
            
            // Show loading state
            document.getElementById('idle-state').classList.add('hidden');
            document.getElementById('data-state').classList.add('hidden');
            document.getElementById('loading-state').classList.remove('hidden');

            // Scan the uploaded file
            html5QrCode.scanFile(imageFile, true)
                .then(decodedText => {
                    // Send the decrypted UUID string to the Laravel API
                    verifyToken(decodedText);
                    document.getElementById('qr-upload').value = ''; 
                })
                .catch(err => {
                    console.error("Scan error:", err);
                    alert("Could not detect a valid QR code in that image. Ensure it is not blurry.");
                    document.getElementById('qr-upload').value = '';
                    resetScanner();
                });
        });

        function verifyToken(token) {
            fetch('/pharmacist/verify-qr', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ qr_token: token })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loading-state').classList.add('hidden');
                
                if(data.status === 'success') {
                    document.getElementById('data-state').classList.remove('hidden');
                    let p = data.data;
                    
                    document.getElementById('res-patient').innerText = p.patient.first_name + ' ' + p.patient.last_name;
                    document.getElementById('res-med').innerText = p.medication.name + ' (' + p.medication.dosage_form + ')';
                    document.getElementById('res-inst').innerText = p.dosage_instructions;
                    document.getElementById('res-doc').innerText = 'Dr. ' + p.doctor.last_name;
                    document.getElementById('res-refill').innerText = p.refills_used + ' used out of ' + p.max_refills + ' total';
                    
                    document.getElementById('form-prescription-id').value = p.id;

                    let warningsDiv = document.getElementById('warnings-container');
                    warningsDiv.innerHTML = '';
                    let btn = document.getElementById('dispense-btn');
                    
                    if(data.warnings && data.warnings.length > 0) {
                        data.warnings.forEach(warning => {
                            warningsDiv.innerHTML += `<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-3 text-sm rounded shadow-sm"><b>ALERT:</b> ${warning}</div>`;
                        });
                        
                        if (p.refills_used >= p.max_refills) {
                            btn.disabled = true;
                            btn.classList.replace('bg-green-600', 'bg-gray-400');
                            btn.classList.replace('hover:bg-green-700', 'cursor-not-allowed');
                            btn.innerText = "System Locked - Max Refills Reached";
                        } else {
                            btn.disabled = false;
                            btn.classList.replace('bg-gray-400', 'bg-green-600');
                            btn.classList.replace('cursor-not-allowed', 'hover:bg-green-700');
                            btn.innerText = "Acknowledge Warning & Dispense Anyway";
                        }
                    } else {
                        btn.disabled = false;
                        btn.classList.replace('bg-gray-400', 'bg-green-600');
                        btn.classList.replace('cursor-not-allowed', 'hover:bg-green-700');
                        btn.innerText = "Dispense & Log Medication";
                    }
                } else {
                    alert(data.message || 'SECURITY ALERT: Invalid QR Code');
                    resetScanner();
                }
            })
            .catch(error => {
                console.error('API Error:', error);
                alert('System connection error. Check your network.');
                resetScanner();
            });
        }

        function resetScanner() {
            document.getElementById('loading-state').classList.add('hidden');
            document.getElementById('data-state').classList.add('hidden');
            document.getElementById('idle-state').classList.remove('hidden');
        }
    </script>
</x-app-layout>
@endsection