@extends('layouts.master')

@section('header', 'Doctor Control Panel')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h3 class="text-gray-500 text-sm font-medium">Prescriptions Issued</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">124</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h3 class="text-gray-500 text-sm font-medium">Active Patients</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">89</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 text-center max-w-2xl">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Generate Secure Prescription</h2>
    <p class="text-gray-500 mb-6">Create a new cryptographically secured QR prescription for a patient.</p>
    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded shadow transition">
        + Write New Prescription
    </button>
</div>
@endsection