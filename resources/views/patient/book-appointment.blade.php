@extends('layouts.patient')

@section('page_title', 'Book Appointment')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

<div class="max-w-5xl mx-auto">
    
    <div class="mb-6">
        <a href="{{ route('patient.appointments') }}" class="text-sm font-bold text-gray-500 hover:text-securx-cyan flex items-center gap-2 transition w-max px-3 py-1.5 rounded-lg hover:bg-white/50">
            &larr; Back to Appointments
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg text-sm font-medium shadow-sm">
            Please fix the errors below before proceeding.
        </div>
    @endif

    <form action="{{ route('patient.appointments.store') }}" method="POST">
        @csrf
        
        <div class="glass-panel overflow-hidden bg-white/80 shadow-xl rounded-2xl flex flex-col md:flex-row">
            
            <div class="w-full md:w-5/12 p-8 md:p-10 border-b md:border-b-0 md:border-r border-gray-100 bg-white/40">
                <div class="mb-8">
                    <span class="bg-securx-navy text-white text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block">Step 1</span>
                    <h2 class="text-2xl font-extrabold text-securx-navy mb-2">Choose Specialist</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">Search and select a verified physician from our network for your consultation.</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Select Doctor *</label>
                        <select name="doctor_id" id="doctor_select" class="w-full" required>
                            <option value="" disabled selected>Search for a doctor or clinic...</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->last_name }}, {{ $doctor->first_name }} - {{ $doctor->doctorProfile->clinic->clinic_name ?? 'General Practice' }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id') <span class="text-xs text-red-500 font-bold mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100/50 mt-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-securx-cyan shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-xs text-gray-600 leading-relaxed">All doctors listed are fully verified by the DOH and active within the SecuRx network.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-7/12 p-8 md:p-10 bg-slate-50/30">
                <div class="mb-6">
                    <span class="bg-securx-cyan text-white text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block shadow-sm shadow-securx-cyan/30">Step 2</span>
                    <h2 class="text-2xl font-extrabold text-securx-navy mb-2">Select Date & Time</h2>
                    <p class="text-gray-500 text-sm">Pick an available slot. <span class="font-semibold text-gray-700">Clinic hours: Mon-Fri, 9AM - 5PM.</span></p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-6 w-full flex justify-center">
                    <input type="text" id="appointment_datetime" name="appointment_date" value="{{ old('appointment_date') }}" class="hidden" required>
                </div>
                
                <div id="taken-slots-container" class="hidden mb-6 p-4 bg-slate-100 border border-slate-200 rounded-xl text-sm transition-all">
                    <p class="font-bold text-slate-700 mb-2">Booked Times for <span id="taken-slots-date"></span>:</p>
                    <div id="taken-slots-list" class="flex flex-wrap gap-2"></div>
                </div>

                <div id="booking-conflict-warning" class="hidden mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm font-bold flex items-center gap-3 transition-all">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>This exact time slot is already taken! Please adjust the time below.</span>
                </div>

                @error('appointment_date') <span class="text-xs text-red-500 font-bold mb-4 block text-center">{{ $message }}</span> @enderror

                <div class="mt-8 pt-6 border-t border-gray-200/60">
                    <button type="submit" id="btn-confirm-booking" class="w-full py-4 bg-gradient-to-r from-securx-navy to-slate-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2 text-lg disabled:opacity-50 disabled:cursor-not-allowed">
                        Confirm Appointment
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    window.doctorSchedules = @json($doctors->keyBy('id')->map(function($doc) {
        return $doc->schedules;
    }));
    
    // NEW: Pass the taken appointments to JS
    window.bookedAppointments = @json($upcomingAppointments ?? []);
</script>

@vite(['resources/js/appointments.js'])
@endsection