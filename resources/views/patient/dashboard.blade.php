@extends('layouts.master')

@section('header', 'My Prescriptions')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Dashboard - My Prescriptions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">

                @if($latestPrescription)
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Active Prescription</h3>
                    <p class="text-gray-600 mb-8">Present this secure QR code to your pharmacist to verify your medication.</p>

                    <div class="flex justify-center mb-8">
                        <div class="p-4 bg-white border-4 border-blue-500 rounded-lg shadow-lg inline-block">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($latestPrescription->qr_token) !!}
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 max-w-md mx-auto text-left border border-gray-200 shadow-inner">
                        <p class="mb-2"><strong class="text-gray-700">Medication:</strong> {{ $latestPrescription->medication->name }} ({{ $latestPrescription->medication->dosage_form }})</p>
                        <p class="mb-2"><strong class="text-gray-700">Instructions:</strong> {{ $latestPrescription->dosage_instructions }}</p>
                        <p class="mb-2"><strong class="text-gray-700">Prescribed by:</strong> Dr. {{ $latestPrescription->doctor->last_name }}</p>
                        <p><strong class="text-gray-700">Refills Remaining:</strong> {{ $latestPrescription->max_refills - $latestPrescription->refills_used }}</p>
                    </div>

                @else
                    <div class="py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">No Active Prescriptions</h3>
                        <p class="mt-1 text-gray-500">You currently do not have any active prescriptions on file.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
@endsection