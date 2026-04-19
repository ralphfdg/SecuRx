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

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white/90 backdrop-blur-md border border-gray-200 rounded-2xl p-8 shadow-sm">
        <form action="{{ route('secretary.appointments.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="patient_id" class="block text-sm font-bold text-gray-700">Select Patient</label>
                    <select id="patient_id" name="patient_id" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3">
                        <option value="" disabled selected>-- Choose Patient --</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->last_name }}, {{ $p->first_name }}
                            </option>
                        @endforeach
                    </select>
                    <p onclick="toggleModal('newPatientModal')" class="text-xs text-securx-cyan font-semibold hover:underline cursor-pointer inline-block mt-1">
                        + Register New Patient
                    </p>
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
                    <input 
                        type="time" 
                        id="appointment_time" 
                        name="appointment_time" 
                        value="{{ now()->format('H:i') }}" 
                        required 
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 bg-slate-50 py-2.5 px-3"
                    >
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

<div id="newPatientModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="toggleModal('newPatientModal')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl leading-6 font-bold text-securx-navy" id="modal-title">
                    Register New Patient
                </h3>
                <button type="button" onclick="toggleModal('newPatientModal')" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('secretary.patients.store') }}" method="POST">
                @csrf
                <div class="px-6 py-4 max-h-[70vh] overflow-y-auto space-y-6">
                    
                    <div>
                        <h4 class="text-sm font-bold text-securx-cyan mb-3 uppercase tracking-wider">Personal Information</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Middle Name</label>
                                <input type="text" name="middle_name" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Qualifier (e.g. Jr)</label>
                                <input type="text" name="qualifier" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Date of Birth <span class="text-red-500">*</span></label>
                                <input type="date" name="dob" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Gender <span class="text-red-500">*</span></label>
                                <select name="gender" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                                    <option value="" disabled selected>Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Mobile No. <span class="text-red-500">*</span></label>
                                <input type="text" name="mobile_num" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-securx-cyan mb-3 uppercase tracking-wider">Demographics</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-gray-700">Full Address <span class="text-red-500">*</span></label>
                                <input type="text" name="address" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Occupation / School</label>
                                <input type="text" name="school_work" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700">Height (cm)</label>
                                    <input type="number" step="0.1" name="height" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700">Weight (kg)</label>
                                    <input type="number" step="0.1" name="weight" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Mother's Name</label>
                                <input type="text" name="mother_name" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Mother's Contact</label>
                                <input type="text" name="mother_contact" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Father's Name</label>
                                <input type="text" name="father_name" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Father's Contact</label>
                                <input type="text" name="father_contact" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-securx-cyan mb-3 uppercase tracking-wider">Account Credentials</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-gray-200">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-gray-700">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Username <span class="text-red-500">*</span></label>
                                <input type="text" name="username" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div class="hidden sm:block"></div> <div>
                                <label class="block text-xs font-bold text-gray-700">Temporary Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-securx-cyan focus:ring focus:ring-securx-cyan/20 text-sm py-2">
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 rounded-b-2xl">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-securx-cyan text-base font-bold text-white hover:bg-cyan-500 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Create Patient Profile
                    </button>
                    <button type="button" onclick="toggleModal('newPatientModal')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(modalID){
        document.getElementById(modalID).classList.toggle("hidden");
    }

    // Auto-open modal if there are validation errors on submission
    @if($errors->has('username') || $errors->has('email') || $errors->has('first_name'))
        document.addEventListener("DOMContentLoaded", function() {
            toggleModal('newPatientModal');
        });
    @endif
</script>
@endsection