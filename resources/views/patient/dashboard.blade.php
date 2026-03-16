@extends('layouts.master')

@section('header', 'My Prescriptions')

@section('content')
<div class="mb-6">
    <h2 class="text-lg font-bold text-gray-800">Active SecuRx Tokens</h2>
    <p class="text-sm text-gray-500">Present these secure QR codes to your pharmacist.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-blue-50 p-4 border-b border-gray-200 text-center">
            <div class="w-32 h-32 bg-white border-2 border-dashed border-gray-300 mx-auto flex items-center justify-center text-xs text-gray-400">
                [ QR Code Space ]
            </div>
        </div>
        <div class="p-4">
            <h3 class="font-bold text-gray-800 text-lg">Amoxicillin 500mg</h3>
            <p class="text-sm text-gray-600 mt-1">Take 1 capsule every 8 hours for 7 days.</p>
            
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between text-xs">
                <span class="text-gray-500">Dr. Gregory House</span>
                <span class="font-semibold text-blue-600">Valid</span>
            </div>
        </div>
    </div>
</div>
@endsection