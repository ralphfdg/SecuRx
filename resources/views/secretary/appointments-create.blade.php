@extends('layouts.secretary')

@section('page_title', 'Log Walk-in')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="p-6 bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-securx-cyan/10 rounded-full flex items-center justify-center text-securx-cyan">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
        </div>
        <div>
            <h2 class="text-2xl font-extrabold text-securx-navy">Log Walk-in Appointment</h2>
            <p class="text-sm text-gray-500 mt-1">Quickly register a patient currently at the front desk. This will automatically confirm their slot for today.</p>
        </div>
    </div>

    <div class="bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl p-8 shadow-sm">
        <form action="{{ route('secretary.appointments.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="space-y-2">
                    <label for="patient_id" class="block text-sm font-bold text-gray-700">Select Patient</label>
                    <select id="patient_id" name="patient_id" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                        <option value="" disabled selected>-- Choose Patient --</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}">{{ $p->first_name }} {{ $p->last_name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-securx-cyan font-semibold hover:underline cursor-pointer">+ Register New Patient</p>
                </div>

                <div class="space-y-2">
                    <label for="doctor_id" class="block text-sm font-bold text-gray-700">Attending Doctor</label>
                    <select id="doctor_id" name="doctor_id" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                        <option value="" disabled selected>-- Choose Doctor --</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}">Dr. {{ $d->first_name }} {{ $d->last_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="appointment_time" class="block text-sm font-bold text-gray-700">Time of Arrival (Today)</label>
                    <input type="time" id="appointment_time" name="appointment_time" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Appointment Status</label>
                    <div class="w-full rounded-xl border border-gray-200 bg-gray-100 py-2.5 px-3 flex items-center gap-2 cursor-not-allowed text-gray-500">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span> Confirmed (Walk-in)
                    </div>
                </div>

            </div>

            <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('secretary.calendar') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700">Cancel</a>
                <button type="submit" class="bg-securx-cyan hover:bg-cyan-500 text-white font-bold py-2.5 px-8 rounded-xl transition shadow-[0_4px_14px_0_rgba(28,181,209,0.39)]">
                    Log Walk-in &rarr;
                </button>
            </div>
        </form>
    </div>

</div>
@endsection