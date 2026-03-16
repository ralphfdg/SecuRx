@extends('layouts.master')

@section('header', 'Pharmacy Dispatch')

@section('content')
<div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-lg shadow-md p-8 text-center max-w-3xl mx-auto text-white mt-8">
    <div class="bg-white/10 p-4 rounded-full inline-block mb-4">
        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
    </div>
    <h2 class="text-2xl font-bold mb-2">Scan SecuRx Token</h2>
    <p class="text-slate-300 mb-8 max-w-md mx-auto">Activate your camera to scan a patient's QR code and verify prescription authenticity.</p>
    
    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 px-10 rounded-full shadow-lg text-lg transition transform hover:scale-105">
        Launch Web Scanner
    </button>
</div>

<div class="mt-8 max-w-3xl mx-auto">
    <h3 class="text-gray-700 font-bold mb-4">Recent Scans</h3>
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center text-gray-500 text-sm">
        No prescriptions scanned today.
    </div>
</div>
@endsection