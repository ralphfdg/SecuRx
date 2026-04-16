@extends('layouts.doctor')

@section('page_title', 'Consultation History & Revocation')

@section('content')
    <div x-data="{ showRevokeModal: false, activeRx: '', activeRxDisplay: '' }" class="max-w-7xl mx-auto space-y-6 pb-12 relative">

        <div
            class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Consultation History</h2>
                <p class="text-sm text-gray-500 mt-1">Review past encounters and manage active prescriptions.</p>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <a href="{{ route('doctor.history.export') }}" id="export-btn" 
                   data-base-url="{{ route('doctor.history.export') }}"
                   class="bg-white border border-gray-300 text-gray-600 hover:text-blue-600 hover:border-blue-300 font-bold py-2.5 px-4 rounded-xl transition shadow-sm flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export CSV
                </a>
            </div>
        </div>

        <form id="filter-form" data-fetch-url="{{ route('doctor.history') }}" onsubmit="event.preventDefault();"
            class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2 relative">
                <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                    class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3.5 pl-11 pr-10 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition"
                    placeholder="Search by patient name, ID, or diagnosis..." autocomplete="off">

                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>

                <button type="button" id="clear-search-btn"
                    class="absolute right-3 top-3.5 text-gray-400 hover:text-red-500 transition-colors hidden"
                    aria-label="Clear search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div>
                <select name="status" id="status-select"
                    class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition text-gray-600 font-medium">
                    <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>Filter by Status: All</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Status: Active</option>
                    <option value="dispensed" {{ request('status') == 'dispensed' ? 'selected' : '' }}>Status: Dispensed
                    </option>
                    <option value="revoked" {{ request('status') == 'revoked' ? 'selected' : '' }}>Status: Revoked</option>
                </select>
            </div>
            <div>
                <input type="date" name="date" id="date-input" value="{{ request('date') }}"
                    class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition text-gray-600 font-medium">
            </div>
        </form>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden relative">

            <div id="loading-overlay"
                class="absolute inset-0 bg-white/60 backdrop-blur-sm z-10 hidden flex items-center justify-center">
                <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-gray-200 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="p-4 pl-6">Date & Time</th>
                            <th class="p-4">Patient Information</th>
                            <th class="p-4">Diagnosis / Notes</th>
                            <th class="p-4 text-center">Rx Status</th>
                            <th class="p-4 pr-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="divide-y divide-gray-100 text-sm">
                        @include('doctor.partials.history-table', ['encounters' => $encounters])
                    </tbody>
                </table>
            </div>
        </div>

        @if ($errors->has('password'))
            <div class="fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline font-bold">{{ $errors->first('password') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="fixed bottom-4 right-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div x-show="showRevokeModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div x-show="showRevokeModal" x-transition.opacity
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="showRevokeModal = false">
            </div>
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showRevokeModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-red-100">
                    <div class="bg-red-50/50 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-red-100">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-black leading-6 text-red-800">Revoke Prescription</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-red-700 font-medium">You are about to permanently invalidate the
                                        QR code for prescription <span class="font-bold text-red-900"
                                            x-text="activeRxDisplay"></span>. If the patient presents this at a pharmacy,
                                        it will immediately flag as revoked.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" :action="`/doctor/history/revoke/${activeRx}`">
                        @csrf
                        <div class="px-4 py-5 sm:p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Reason
                                    for Revocation (Required)</label>
                                <select name="reason" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-red-500 focus:border-red-500 font-medium text-gray-700">
                                    <option value="">Select a clinical reason...</option>
                                    <option value="Clinical Error / Incorrect Dosage">Clinical Error / Incorrect Dosage
                                    </option>
                                    <option value="Patient reported adverse reaction">Patient reported adverse reaction
                                    </option>
                                    <option value="Therapy changed before dispensing">Therapy changed before dispensing
                                    </option>
                                    <option value="Suspected fraud or loss">Suspected fraud or loss</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-2">Security
                                    Authorization</label>
                                <input type="password" name="password" required
                                    class="w-full bg-slate-50 border border-gray-200 text-sm rounded-xl p-3 focus:ring-red-500 focus:border-red-500"
                                    placeholder="Enter your account password to confirm">
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-200">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition-colors">Confirm
                                Revocation</button>
                            <button type="button" @click="showRevokeModal = false"
                                class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/doctor-history.js'])
@endsection
