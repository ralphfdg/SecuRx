@extends('layouts.secretary')

@section('page_title', 'Secretary Dashboard')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        <div
            class="p-8 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="absolute top-0 right-0 w-64 h-64 bg-securx-navy/5 rounded-bl-full pointer-events-none -z-10"></div>
            <div class="relative z-10">
                <span
                    class="bg-securx-navy text-white text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block shadow-sm">Front
                    Desk Console</span>
                <h1 class="text-3xl font-extrabold text-securx-navy mb-2">Hello, {{ $user->first_name }}.</h1>
                <p class="text-gray-600 font-medium">You have <span
                        class="text-orange-500 font-bold">{{ $pendingRequests->count() }} pending</span> appointment requests
                    and <span class="text-securx-cyan font-bold">{{ $todaysExpected->count() }} patients</span> expected
                    today.</p>
            </div>

            <div class="relative z-10 flex gap-3 w-full md:w-auto">
                <a href="{{ route('secretary.appointments.create') }}"
                    class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-3 px-6 rounded-xl transition shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                        </path>
                    </svg>
                    Log Walk-in
                </a>
                <a href="{{ route('secretary.calendar') }}"
                    class="bg-securx-navy hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-[0_4px_14px_0_rgba(15,23,42,0.39)] flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Manage Calendar
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div
                class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl flex flex-col h-full shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-orange-50/50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-orange-500 animate-pulse"></span>
                        Pending Requests
                    </h3>
                    <span
                        class="bg-orange-100 text-orange-700 text-xs font-bold px-2 py-1 rounded-md">{{ $pendingRequests->count() }}
                        New</span>
                </div>

                <div class="p-5 space-y-4 flex-1">
                    @forelse($pendingRequests as $req)
                        <div
                            class="border border-gray-200 rounded-xl p-4 hover:border-orange-300 transition-colors bg-white">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-bold text-securx-navy">{{ $req->patient->first_name ?? 'Unknown' }}
                                        {{ $req->patient->last_name ?? 'Patient' }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Consultation w/ Dr.
                                        {{ $req->doctor->last_name ?? 'Provider' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-700">
                                        {{ \Carbon\Carbon::parse($req->appointment_date)->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($req->appointment_date)->format('h:i A') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2 pt-3 border-t border-gray-100">
                                <button
                                    class="flex-1 bg-green-50 text-green-600 hover:bg-green-500 hover:text-white border border-green-200 hover:border-green-500 text-xs font-bold py-2.5 rounded-lg transition">Approve</button>
                                <button
                                    class="flex-1 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white border border-red-200 hover:border-red-500 text-xs font-bold py-2.5 rounded-lg transition">Decline</button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-500">
                            <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm">No pending requests at this time.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl flex flex-col h-full shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-blue-50/50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Today's Expected
                    </h3>
                    <a href="{{ route('secretary.triage') }}" class="text-xs font-bold text-securx-cyan hover:underline">Go
                        to Triage &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                <th class="p-4 font-bold">Time</th>
                                <th class="p-4 font-bold">Patient</th>
                                <th class="p-4 font-bold">Provider</th>
                                <th class="p-4 font-bold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($todaysExpected as $expected)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 font-medium text-gray-600">
                                        {{ \Carbon\Carbon::parse($expected->appointment_date)->format('h:i A') }}</td>
                                    <td class="p-4 font-bold text-securx-navy">
                                        {{ $expected->patient->first_name ?? 'Unknown' }}
                                        {{ $expected->patient->last_name ?? '' }}</td>
                                    <td class="p-4 text-gray-500 text-xs">Dr. {{ $expected->doctor->last_name ?? '' }}</td>
                                    <td class="p-4 text-right">
                                        @if ($expected->status === 'completed')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-100 text-blue-700 uppercase tracking-wider border border-blue-200">Arrived
                                                / Done</span>
                                        @else
                                            <div class="flex items-center justify-end gap-1">
                                                <button
                                                    class="bg-white border border-gray-300 text-gray-600 hover:border-securx-cyan hover:text-securx-cyan text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-md transition shadow-sm">Arrived</button>

                                                <form action="{{ route('secretary.appointments.no-show') }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <input type="hidden" name="appointment_id"
                                                        value="{{ $expected->id }}">
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to mark this patient as a No Show?');"
                                                        class="bg-white border border-red-200 text-red-500 hover:bg-red-50 text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-md transition shadow-sm">No
                                                        Show</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500 text-sm">No patients scheduled
                                        for today.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
