@extends('layouts.secretary')

@section('page_title', 'Secretary Dashboard')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        <div class="p-8 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="absolute top-0 right-0 w-64 h-64 bg-securx-navy/5 rounded-bl-full pointer-events-none -z-10"></div>
            <div class="relative z-10">
                <span class="bg-securx-navy text-white text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block shadow-sm">Front Desk Console</span>
                <h1 class="text-3xl font-extrabold text-securx-navy mb-2">Hello, {{ $user->first_name }}.</h1>
                <p class="text-gray-600 font-medium">You have <span class="text-orange-500 font-bold">{{ $pendingRequests->total() }} pending</span> appointment requests and <span class="text-securx-cyan font-bold">{{ $todaysExpected->total() }} patients</span> expected today.</p>
            </div>

            <div class="relative z-10 flex gap-3 w-full md:w-auto">
                <a href="{{ route('secretary.appointments.create') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-3 px-6 rounded-xl transition shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Log Walk-in
                </a>
                <a href="{{ route('secretary.calendar') }}" class="bg-securx-navy hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-[0_4px_14px_0_rgba(15,23,42,0.39)] flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Manage Calendar
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl flex flex-col h-full shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-orange-50/50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-orange-500 animate-pulse"></span>
                        Pending Requests
                    </h3>
                    <span class="bg-orange-100 text-orange-700 text-xs font-bold px-2 py-1 rounded-md shadow-sm">{{ $pendingRequests->total() }} New</span>
                </div>

                <div class="p-5 space-y-4 flex-1">
                    @forelse($pendingRequests as $req)
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md hover:border-orange-300 transition-all duration-200 bg-white group">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-bold text-securx-navy group-hover:text-orange-600 transition-colors">
                                        {{ $req->patient->first_name ?? 'Unknown' }} {{ $req->patient->last_name ?? 'Patient' }}
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Dr. {{ $req->doctor->last_name ?? 'Provider' }}
                                    </p>
                                </div>
                                <div class="text-right bg-orange-50/50 px-2.5 py-1.5 rounded-lg border border-orange-100">
                                    <p class="text-sm font-bold text-orange-700">
                                        {{ \Carbon\Carbon::parse($req->appointment_date)->format('M d, Y') }}
                                    </p>
                                    <p class="text-xs font-semibold text-orange-600">
                                        {{ \Carbon\Carbon::parse($req->appointment_time ?? $req->appointment_date)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex gap-2 pt-3 border-t border-gray-100">
                                <form action="{{ route('secretary.appointments.approve', $req->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full flex justify-center items-center gap-1.5 bg-green-50 text-green-700 hover:bg-green-500 hover:text-white border border-green-200 hover:border-green-500 text-xs font-bold py-2.5 rounded-lg transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('secretary.appointments.decline', $req->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Are you sure you want to decline this appointment request?');" class="w-full flex justify-center items-center gap-1.5 bg-red-50 text-red-700 hover:bg-red-500 hover:text-white border border-red-200 hover:border-red-500 text-xs font-bold py-2.5 rounded-lg transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Decline
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-500">
                            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium">No pending requests at this time.</p>
                        </div>
                    @endforelse
                </div>
                
                @if($pendingRequests->hasPages())
                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/50">
                        {{ $pendingRequests->links() }}
                    </div>
                @endif
            </div>

            <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl flex flex-col h-full shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-blue-50/50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Today's Expected
                    </h3>
                    <a href="{{ route('secretary.triage') }}" class="text-xs font-bold text-securx-cyan hover:text-blue-700 transition flex items-center gap-1">
                        Go to Triage <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-[10px] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                <th class="p-4 font-bold">Time</th>
                                <th class="p-4 font-bold">Patient</th>
                                <th class="p-4 font-bold">Provider</th>
                                <th class="p-4 font-bold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($todaysExpected as $expected)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="p-4 font-medium text-gray-600 whitespace-nowrap">
                                        <div class="bg-gray-100/80 px-2 py-1 rounded text-xs inline-block font-semibold">
                                            {{ \Carbon\Carbon::parse($expected->appointment_time ?? $expected->appointment_date)->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td class="p-4 font-bold text-securx-navy">
                                        {{ $expected->patient->first_name ?? 'Unknown' }} {{ $expected->patient->last_name ?? '' }}
                                    </td>
                                    <td class="p-4 text-gray-500 text-xs font-medium">
                                        Dr. {{ $expected->doctor->last_name ?? '' }}
                                    </td>
                                    <td class="p-4 text-right whitespace-nowrap">
                                        @if ($expected->status === 'completed')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wider border border-slate-200">
                                                Done
                                            </span>
                                        @elseif ($expected->status === 'in-progress')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-100 text-blue-700 uppercase tracking-wider border border-blue-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                In Progress
                                            </span>
                                        @else
                                            <div class="flex items-center justify-end gap-1">
                                                <form action="{{ route('secretary.appointments.arrive', $expected->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-white border border-gray-300 text-gray-600 hover:border-securx-cyan hover:text-securx-cyan hover:bg-cyan-50 text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-md transition shadow-sm">
                                                        Arrived
                                                    </button>
                                                </form>

                                                <form action="{{ route('secretary.appointments.no-show') }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="appointment_id" value="{{ $expected->id }}">
                                                    <button type="submit" onclick="return confirm('Are you sure you want to mark this patient as a No Show?');" class="bg-white border border-red-200 text-red-500 hover:bg-red-50 text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-md transition shadow-sm">
                                                        No Show
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500">
                                        <p class="text-sm">No patients scheduled for today.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($todaysExpected->hasPages())
                    <div class="p-4 border-t border-gray-200 bg-gray-50/50">
                        {{ $todaysExpected->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection