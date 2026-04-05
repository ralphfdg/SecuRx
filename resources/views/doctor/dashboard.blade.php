@extends('layouts.doctor')

@section('page_title', 'Provider Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6 pb-12">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div
                class="md:col-span-4 bg-gradient-to-r from-securx-navy to-blue-800 rounded-2xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden flex items-center justify-between">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-bl-full pointer-events-none"></div>
                <div class="relative z-10">
                    <h2 class="text-2xl md:text-3xl font-black tracking-tight mb-1">Good Morning, Dr. Santos</h2>
                    <p class="text-blue-200 font-medium text-sm md:text-base">Here is your clinical overview for today.</p>
                </div>
                <div
                    class="hidden md:flex items-center gap-3 bg-white/10 backdrop-blur-md px-5 py-3 rounded-xl border border-white/20">
                    <div class="text-right">
                        <p class="text-xs text-blue-200 font-bold uppercase tracking-wider">Today's Date</p>
                        <p class="text-lg font-bold">{{ date('F j, Y') }}</p>
                    </div>
                    <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Scheduled Today</p>
                    <p class="text-2xl font-black text-securx-navy">14</p>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Completed Consults</p>
                    <p class="text-2xl font-black text-securx-navy">3</p>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Rx Issued</p>
                    <p class="text-2xl font-black text-securx-navy">8</p>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-600 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">DUR Alerts (30d)</p>
                    <p class="text-2xl font-black text-securx-navy">2</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="text-lg font-bold text-securx-navy flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></span>
                            Live Waiting Queue
                        </h3>
                        <a href="{{ route('doctor.queue') ?? '#' }}"
                            class="text-sm font-bold text-blue-600 hover:text-blue-800 transition">View Full Queue
                            &rarr;</a>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <tbody class="divide-y divide-gray-100 text-sm">
                                <tr class="hover:bg-gray-50 transition group">
                                    <td class="p-4">
                                        <p class="font-bold text-securx-navy">Reyes, Maria</p>
                                        <p class="text-xs text-gray-400">45 yrs • F</p>
                                    </td>
                                    <td class="p-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Waiting (15m)
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('doctor.queue') }}"
                                            class="inline-block bg-white border border-gray-300 text-gray-600 hover:border-blue-600 hover:text-blue-600 text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
                                            Open Queue
                                        </a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition group">
                                    <td class="p-4">
                                        <p class="font-bold text-securx-navy">Cruz, Juan</p>
                                        <p class="text-xs text-gray-400">62 yrs • M</p>
                                    </td>
                                    <td class="p-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                            Triaged
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('doctor.queue') }}"
                                            class="inline-block bg-white border border-gray-300 text-gray-600 hover:border-blue-600 hover:text-blue-600 text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
                                            Open Queue
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <h3 class="text-lg font-bold text-securx-navy">Top Prescribed Medications</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Trailing 30 Days (Powered by RxNorm)</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <div class="p-6 relative h-72">
                        <canvas id="medicationChart"></canvas>
                    </div>
                </div>

            </div>

            <div class="space-y-6">

                <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Command Center</h3>

                    <div class="space-y-3">
                        <a href="{{ route('doctor.queue') }}"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] hover:-translate-y-0.5 text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Manage Clinic Queue
                        </a>

                        <a href="{{ route('doctor.directory') }}"
                            class="block w-full bg-white border border-gray-300 hover:border-securx-navy text-securx-navy font-bold py-3 px-4 rounded-xl transition text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search Patient Directory
                        </a>

                        <a href="{{ route('doctor.history') }}"
                            class="block w-full bg-white border border-red-200 hover:border-red-500 hover:text-red-600 text-red-500 font-bold py-3 px-4 rounded-xl transition text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Revoke Prescription
                        </a>
                    </div>
                </div>

                <div class="bg-slate-800 border border-slate-700 rounded-2xl shadow-xl overflow-hidden">
                    <div class="p-5 border-b border-slate-700 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-white flex items-center gap-2">
                            <svg class="w-4 h-4 text-securx-gold" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Recent DUR Flags
                        </h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex gap-3">
                            <div class="w-2 h-2 mt-1.5 rounded-full bg-securx-gold flex-shrink-0"></div>
                            <div>
                                <p class="text-sm font-bold text-slate-200">Drug-Drug Interaction Alert</p>
                                <p class="text-xs text-slate-400 mt-0.5">System flagged a moderate interaction between
                                    <span class="text-slate-300 font-semibold">Losartan</span> and <span
                                        class="text-slate-300 font-semibold">Ibuprofen</span> for patient Dela Cruz, J.
                                    Override justification was logged.</p>
                                <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-wider">Yesterday at 3:45 PM
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('medicationChart');
            if (!canvas) return; // Prevent errors if element isn't found

            const ctx = canvas.getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Amoxicillin', 'Losartan', 'Metformin', 'Amlodipine', 'Paracetamol'],
                    datasets: [{
                        label: 'Prescriptions Issued',
                        data: [45, 38, 32, 28, 20],
                        backgroundColor: [
                            'rgba(37, 99, 235, 0.8)', // blue-600
                            'rgba(28, 181, 209, 0.8)', // securx-cyan
                            'rgba(5, 150, 105, 0.8)', // emerald-600
                            'rgba(212, 175, 55, 0.8)', // securx-gold
                            'rgba(148, 163, 184, 0.8)' // slate-400
                        ],
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: {
                                size: 13,
                                family: 'Inter'
                            },
                            bodyFont: {
                                size: 13,
                                family: 'Inter'
                            },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(241, 245, 249, 1)',
                                drawBorder: false,
                            },
                            ticks: {
                                font: {
                                    family: 'Inter',
                                    size: 11
                                },
                                color: '#64748b'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    family: 'Inter',
                                    size: 11,
                                    weight: 'bold'
                                },
                                color: '#334155'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
