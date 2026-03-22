@extends('layouts.doctor')

@section('page_title', 'Provider Dashboard')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="glass-panel p-8 bg-white/80 flex flex-col md:flex-row items-center justify-between gap-6 border-t-4 border-t-securx-navy">
        <div>
            <h1 class="text-3xl font-extrabold text-securx-navy mb-1">Welcome, Dr. Santos.</h1>
            <p class="text-gray-600 font-medium">Your digital signature is active. You have issued <span class="text-securx-cyan font-bold">14 prescriptions</span> this week.</p>
        </div>
        
        <a href="#" class="glass-btn-primary flex items-center justify-center gap-2 py-3 px-8 text-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Issue New Prescription
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-panel p-6 bg-white/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-securx-cyan/10 text-securx-cyan flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500">Active (Pending Dispense)</p>
                <p class="text-2xl font-extrabold text-securx-navy">8</p>
            </div>
        </div>
        <div class="glass-panel p-6 bg-white/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-500/10 text-green-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500">Successfully Dispensed</p>
                <p class="text-2xl font-extrabold text-securx-navy">1,204</p>
            </div>
        </div>
        <div class="glass-panel p-6 bg-white/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500">Revoked / Flagged</p>
                <p class="text-2xl font-extrabold text-securx-navy">3</p>
            </div>
        </div>
    </div>

    <div class="glass-panel overflow-hidden bg-white/80">
        <div class="p-6 border-b border-gray-200/60 flex justify-between items-center">
            <h3 class="text-lg font-bold text-securx-navy">Recent Prescriptions</h3>
            <a href="#" class="text-sm font-bold text-securx-cyan hover:text-securx-navy transition">View All History &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-bold">Patient Name</th>
                        <th class="p-4 font-bold">Medication</th>
                        <th class="p-4 font-bold">Date Issued</th>
                        <th class="p-4 font-bold text-right">Quick Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                    <tr class="hover:bg-white/40 transition">
                        <td class="p-4 font-bold text-securx-navy">Ralph De Guzman</td>
                        <td class="p-4">Amoxicillin 500mg <span class="block text-xs text-gray-500">UUID: 8F92A-4B7C1</span></td>
                        <td class="p-4 text-gray-500">Today, 09:15 AM</td>
                        <td class="p-4 text-right">
                            <button class="text-xs font-bold bg-red-50 text-red-600 border border-red-200 py-1.5 px-3 rounded-md hover:bg-red-500 hover:text-white transition">Revoke Access</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-white/40 transition">
                        <td class="p-4 font-bold text-securx-navy">Maria Clara</td>
                        <td class="p-4">Lisinopril 10mg <span class="block text-xs text-gray-500">UUID: 2C44F-9A1B2</span></td>
                        <td class="p-4 text-gray-500">Yesterday</td>
                        <td class="p-4 text-right">
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-3 py-1.5 rounded-md border border-green-200">Dispensed</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection