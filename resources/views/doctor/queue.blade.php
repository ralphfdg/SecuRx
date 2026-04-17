@extends('layouts.doctor')

@section('page_title', 'Clinic Queue & Schedule')
@vite(['resources/css/app.css', 'resources/js/app.js'])
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/doctor-calendar.js'])

@section('content')
    <div x-data="queueManager()" class="max-w-6xl mx-auto space-y-6">

        <div
            class="p-6 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm flex flex-col xl:flex-row xl:items-center justify-between gap-6">

            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">Clinic Queue & Schedule</h2>
                <div x-data="{
                    time: '',
                    init() {
                        setInterval(() => { this.time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }); }, 1000);
                        this.time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    }
                }" class="text-sm text-gray-500 mt-1.5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span x-text="time" class="font-bold text-gray-700 w-20"></span>
                    <span class="text-gray-300">|</span>
                    <span>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</span>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center gap-4 w-full xl:w-auto">

                <div x-show="activeTab === 'queue'" x-transition class="flex items-center gap-2 w-full md:w-auto">
                    <div class="relative w-full md:w-56">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <div class="relative w-full md:w-56">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>

                            <input type="text" x-model="search" @input.debounce.500ms="updateQueue"
                                placeholder="Search patient..."
                                class="w-full pl-9 pr-10 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

                            <button x-show="search.length > 0" @click="search = ''; updateQueue()" style="display: none;"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <select x-model="sort" @change="updateQueue"
                        class="border border-gray-200 rounded-xl py-2 pl-3 pr-8 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-gray-600 bg-white">
                        <option value="asc">Earliest</option>
                        <option value="desc">Latest</option>
                    </select>
                </div>

                <div class="flex p-1 bg-slate-100 rounded-xl border border-gray-200 w-full md:w-auto justify-center">
                    <button @click="activeTab = 'queue'"
                        :class="activeTab === 'queue' ? 'bg-white text-blue-600 shadow-sm' :
                            'text-gray-500 hover:text-blue-600'"
                        class="px-5 py-2 text-sm font-bold rounded-lg transition-all duration-200 flex items-center justify-center gap-2 w-1/2 md:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        Live Queue
                    </button>

                    <button
                        @click="activeTab = 'calendar'; setTimeout(() => { if(typeof window.initDoctorCalendar === 'function') window.initDoctorCalendar(); }, 50)"
                        :class="activeTab === 'calendar' ? 'bg-white text-blue-600 shadow-sm' :
                            'text-gray-500 hover:text-blue-600'"
                        class="px-5 py-2 text-sm font-bold rounded-lg transition-all duration-200 flex items-center justify-center gap-2 w-1/2 md:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Calendar
                    </button>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'queue'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            class="space-y-4 relative">

            <div id="queue-list-container" class="space-y-4">
                @include('doctor.partials.queue-list')
            </div>

            <div x-show="loading" style="display: none;"
                class="absolute inset-0 bg-white/50 backdrop-blur-sm z-10 flex items-center justify-center rounded-2xl">
                <svg class="animate-spin h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>
        </div>

        <div x-show="activeTab === 'calendar'" style="display: none;"
            class="bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl p-6 shadow-sm min-h-[600px]">

            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-bold text-securx-navy border-l-4 border-blue-600 pl-3">Appointment Schedule
                    </h3>
                    <span
                        class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold border border-emerald-200">Accepting
                        Appointments</span>
                </div>

                <div
                    class="flex flex-wrap items-center gap-4 text-xs font-bold text-gray-500 bg-slate-50 px-4 py-2 rounded-xl border border-gray-100">
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#2563eb]"></span>
                        Confirmed
                    </div>
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#f59e0b]"></span> Pending
                    </div>
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#10b981]"></span>
                        Completed
                    </div>
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#ef4444]"></span>
                        Cancelled
                    </div>
                </div>
            </div>

            <div id="doctorCalendar" class="w-full min-h-[600px]" data-events="{{ json_encode($calendarEvents) }}"></div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('queueManager', () => ({
                activeTab: 'queue',
                search: '{{ request('search') }}',
                sort: '{{ request('sort', 'asc') }}',
                loading: false,

                updateQueue() {
                    this.loading = true;

                    let url = new URL(window.location.href);
                    if (this.search) {
                        url.searchParams.set('search', this.search);
                    } else {
                        url.searchParams.delete('search');
                    }
                    url.searchParams.set('sort', this.sort);

                    window.history.pushState({}, '', url);

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('queue-list-container').innerHTML = html;
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                }
            }));
        });
    </script>
@endsection
