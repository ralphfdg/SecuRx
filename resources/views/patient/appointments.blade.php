@extends('layouts.patient')

@section('page_title', 'Appointment Management')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 glass-panel p-6 bg-white/80">
            <div>
                <h2 class="text-2xl font-extrabold text-securx-navy">My Appointments</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your upcoming clinic visits and view your consultation history.
                </p>
            </div>

            <a href="{{ route('patient.appointments.book') }}"
                class="glass-btn-primary flex items-center justify-center gap-2 py-2.5 px-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Book New Visit
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6">

            @forelse($appointments as $appointment)
                <div
                    class="glass-panel bg-white/70 p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 hover:shadow-lg transition-shadow border-l-4 {{ $appointment->status === 'confirmed' ? 'border-green-500' : 'border-securx-gold' }}">

                    <div class="flex items-start gap-4">
                        <div
                            class="flex flex-col items-center justify-center bg-securx-navy/5 rounded-xl border border-securx-navy/10 p-3 min-w-[80px]">
                            <span
                                class="text-xs font-bold text-gray-500 uppercase">{{ $appointment->appointment_date->format('M') }}</span>
                            <span
                                class="text-2xl font-extrabold text-securx-navy">{{ $appointment->appointment_date->format('d') }}</span>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-securx-navy flex items-center gap-2">
                                Dr. {{ $appointment->doctor->last_name }}
                                @if ($appointment->status === 'confirmed')
                                    <span
                                        class="bg-green-100 text-green-700 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full tracking-wider">Confirmed</span>
                                @elseif($appointment->status === 'pending')
                                    <span
                                        class="bg-securx-gold/20 text-securx-gold text-[10px] uppercase font-bold px-2 py-0.5 rounded-full tracking-wider">Pending</span>
                                @else
                                    <span
                                        class="bg-gray-100 text-gray-600 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full tracking-wider">{{ $appointment->status }}</span>
                                @endif
                            </h3>

                            <div class="mt-2 space-y-1 text-sm text-gray-600">
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $appointment->appointment_date->format('h:i A') }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-securx-cyan" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $appointment->doctor->doctorProfile->clinic->clinic_name ?? 'Primary Clinic' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                        <button
                            class="px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-lg hover:bg-gray-50 transition w-full sm:w-auto text-center shadow-sm">
                            Reschedule
                        </button>
                        <form action="{{ route('patient.appointments.cancel', $appointment->id) }}" method="POST"
                            class="w-full sm:w-auto">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="px-4 py-2 bg-white border border-red-100 text-red-500 text-sm font-bold rounded-lg hover:bg-red-50 transition w-full text-center shadow-sm"
                                onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                Cancel
                            </button>
                        </form>
                    </div>
                </div>

            @empty
                <div
                    class="glass-panel bg-white/50 border-dashed border-2 border-securx-cyan/30 flex flex-col items-center justify-center py-16 px-4 text-center rounded-2xl">
                    <div
                        class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4 border border-blue-100">
                        <svg class="w-10 h-10 text-securx-cyan opacity-80" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-securx-navy mb-2">No upcoming appointments</h3>
                    <p class="text-gray-500 max-w-sm mb-6 text-sm">You currently don't have any physical clinic visits
                        scheduled. Book an appointment to securely consult with our verified doctors.</p>
                    <a href="{{ route('patient.appointments.book') }}"
                        class="px-6 py-2.5 bg-securx-navy text-white font-bold rounded-lg hover:bg-slate-800 transition shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Schedule Now
                    </a>
                </div>
            @endforelse

        </div>
    </div>
@endsection
