@extends('layouts.master')

@section('header', 'My Prescriptions')

@section('content')
<x-app-layout>
    <div class="min-h-screen bg-gray-900 text-gray-200 pb-12">
        
        <header class="bg-gray-800 shadow border-b border-gray-700">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                    {{ __('Admin Command Center') }}
                </h2>
            </div>
        </header>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-900 border border-green-500 text-green-300 px-4 py-3 rounded relative shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 shadow-lg">
                    <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider mb-2">System Users</h3>
                    <p class="text-3xl font-extrabold text-blue-400">{{ $stats['total_doctors'] }} <span class="text-sm font-medium text-gray-500">Doctors</span></p>
                    <p class="text-xl font-bold text-green-400 mt-1">{{ $stats['total_pharmacists'] }} <span class="text-sm font-medium text-gray-500">Pharmacists</span></p>
                </div>

                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 shadow-lg">
                    <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider mb-2">Drug Database</h3>
                    <p class="text-3xl font-extrabold text-purple-400">{{ $stats['total_medications'] }}</p>
                    <p class="text-gray-400 text-sm mt-1">Registered Medications</p>
                </div>

                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 shadow-lg">
                    <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider mb-2">Active Network</h3>
                    <p class="text-3xl font-extrabold text-teal-400">{{ $stats['active_prescriptions'] }}</p>
                    <p class="text-gray-400 text-sm mt-1">Pending Prescriptions</p>
                </div>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-lg p-6 shadow-lg mb-8">
                <h3 class="text-lg font-bold text-gray-100 mb-4">Add New Medication to System</h3>
                
                <form action="{{ route('admin.medications.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Drug Name</label>
                            <input type="text" name="name" required placeholder="e.g. Paracetamol" class="w-full bg-gray-900 border border-gray-600 rounded-md text-gray-200 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Dosage Form</label>
                            <input type="text" name="dosage_form" required placeholder="e.g. 500mg Tablet" class="w-full bg-gray-900 border border-gray-600 rounded-md text-gray-200 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150 border border-blue-500">
                                + Save to Inventory
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-700">
                    <h3 class="text-lg font-bold text-gray-100">Medication Inventory</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Drug Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Dosage Form</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @foreach($medications as $med)
                            <tr class="hover:bg-gray-750 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200">{{ $med->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $med->dosage_form }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
@endsection