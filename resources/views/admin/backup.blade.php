@extends('layouts.admin')

@section('page_title', 'System Backup')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden flex justify-between items-center">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1 flex items-center gap-2">
                <svg class="w-6 h-6 text-securx-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                System Backup & Export
            </h1>
            <p class="text-gray-600 font-medium text-sm">Download secure, encrypted copies of system datasets and database architecture.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="glass-panel p-8 bg-white/80 flex flex-col justify-between border-t-4 border-t-securx-cyan hover:shadow-lg transition-shadow">
            <div>
                <div class="w-12 h-12 bg-securx-cyan/10 text-securx-cyan rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-securx-navy mb-2">Dataset Export (.CSV)</h3>
                <p class="text-sm text-gray-500 mb-6">Download a clean, human-readable spreadsheet of the current clinical datasets. Ideal for auditing the DPRI medication inventory or importing data into external analytics software.</p>
                
                <ul class="space-y-2 mb-8">
                    <li class="flex items-center text-xs text-gray-600 font-medium">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Live Medication Inventory
                    </li>
                    <li class="flex items-center text-xs text-gray-600 font-medium">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Comma-Separated Values
                    </li>
                </ul>
            </div>

            <form action="{{ route('admin.backup.export') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="csv">
                <button type="submit" class="w-full py-3 px-4 bg-securx-cyan hover:bg-securx-navy text-white font-bold rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download CSV Backup
                </button>
            </form>
        </div>

        <div class="glass-panel p-8 bg-white/80 flex flex-col justify-between border-t-4 border-t-securx-gold hover:shadow-lg transition-shadow">
            <div>
                <div class="w-12 h-12 bg-securx-gold/10 text-securx-gold rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-securx-navy mb-2">Full Architecture (.SQL)</h3>
                <p class="text-sm text-gray-500 mb-6">Generates a complete structural snapshot of the database. Use this file for complete disaster recovery or migrating the system to a new server architecture.</p>
                
                <ul class="space-y-2 mb-8">
                    <li class="flex items-center text-xs text-gray-600 font-medium">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Table Structures & Schemas
                    </li>
                    <li class="flex items-center text-xs text-gray-600 font-medium">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Standard SQL Dump Format
                    </li>
                </ul>
            </div>

            <form action="{{ route('admin.backup.export') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="sql">
                <button type="submit" class="w-full py-3 px-4 bg-securx-gold hover:bg-yellow-600 text-white font-bold rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download SQL Backup
                </button>
            </form>
        </div>

    </div>
</div>
@endsection