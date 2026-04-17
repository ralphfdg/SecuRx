@forelse($queue as $index => $appt)
    @php
        $patient = $appt->patient;
        $age = $patient->dob ? \Carbon\Carbon::parse($patient->dob)->age : '--';
        $hasVitals = !empty($appt->triage_vitals);

        $bp = $hasVitals && isset($appt->triage_vitals['blood_pressure']) ? $appt->triage_vitals['blood_pressure'] : '--/--';
        $temp = $hasVitals && isset($appt->triage_vitals['temperature']) ? $appt->triage_vitals['temperature'] . '°C' : '--';
        $weight = $hasVitals && isset($appt->triage_vitals['weight']) ? $appt->triage_vitals['weight'] . 'kg' : '--';

        $queueNum = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
        $shortId = strtoupper(substr($patient->id, 0, 8));
        $reason = $appt->reason_for_visit ?? 'Routine checkup / No reason provided';
        
        // --- Smart Time Display Logic ---
        $timeDisplay = $appt->appointment_time 
            ? 'Scheduled: ' . \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A')
            : 'Logged: ' . $appt->created_at->format('h:i A');
    @endphp

    @if ($hasVitals)
        <div class="bg-white/80 backdrop-blur-md border border-gray-200 rounded-2xl shadow-sm overflow-hidden relative group hover:border-blue-300 transition-colors">
            <div class="p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex items-start gap-4 text-gray-400 group-hover:text-securx-navy transition-colors">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 group-hover:bg-blue-50 flex flex-col items-center justify-center text-slate-500 group-hover:text-blue-600 font-bold shrink-0 transition-colors">
                        <span class="text-xl font-black leading-none">{{ $queueNum }}</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-securx-navy">{{ $patient->last_name }}, {{ $patient->first_name }}</h3>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 uppercase tracking-widest border border-emerald-200">Triaged • Ready</span>
                            
                            <span class="text-xs font-bold text-gray-400 ml-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $timeDisplay }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 font-medium mt-1">{{ $age }} yrs • {{ $patient->gender ?? 'N/A' }} • ID: {{ $shortId }}</p>
                        <p class="text-xs text-gray-400 mt-1 group-hover:text-securx-navy transition-colors">{{ ucfirst($appt->appointment_type) }}: {{ $reason }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-8 px-6 py-3 bg-white/50 rounded-xl border border-gray-100 group-hover:bg-white transition-colors">
                    <div class="text-center">
                        <p class="text-[10px] font-bold text-gray-400 uppercase">BP</p>
                        <p class="text-sm font-black text-emerald-600">{{ $bp }}</p>
                    </div>
                    <div class="text-center border-x border-gray-200 px-8">
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Temp</p>
                        <p class="text-sm font-black text-securx-navy">{{ $temp }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Weight</p>
                        <p class="text-sm font-black text-securx-navy">{{ $weight }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('doctor.consultation.show', ['appointment' => $appt->id]) }}" class="bg-white border-2 border-gray-200 text-securx-navy hover:border-blue-600 hover:text-blue-600 font-bold py-2.5 px-6 rounded-xl transition text-sm shadow-sm flex items-center gap-2 whitespace-nowrap">
                        Start Consultation
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white/40 border border-dashed border-gray-300 rounded-2xl overflow-hidden opacity-70">
            <div class="p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-gray-200 flex items-center justify-center text-slate-300 font-bold shrink-0">
                        <span class="text-xl font-black leading-none">{{ $queueNum }}</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-gray-400">{{ $patient->last_name }}, {{ $patient->first_name }}</h3>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 text-gray-400 uppercase tracking-widest">Front Desk Waiting</span>
                            
                            <span class="text-xs font-bold text-gray-400 ml-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $timeDisplay }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-400 mt-1">{{ $age }} yrs • {{ $patient->gender ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex-1 text-center py-2 italic text-xs text-gray-400">
                    Awaiting triage vitals from Secretary...
                </div>

                <div class="flex items-center gap-3">
                    <button disabled class="bg-gray-100 text-gray-400 font-bold py-2.5 px-6 rounded-xl text-sm cursor-not-allowed border border-gray-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Awaiting Vitals
                    </button>
                </div>
            </div>
        </div>
    @endif
@empty
    <div class="text-center py-10 bg-white rounded-2xl border border-gray-200 shadow-sm">
        <p class="text-gray-500 font-medium">No patients currently in the queue.</p>
    </div>
@endforelse

@if ($queue->total() > 0)
    <div class="bg-white/60 backdrop-blur-sm border border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
        <p class="text-xs text-gray-500 font-medium">
            Showing <span class="font-bold text-securx-navy">{{ $queue->firstItem() }}</span> to <span class="font-bold text-securx-navy">{{ $queue->lastItem() }}</span> of <span class="font-bold text-securx-navy">{{ $queue->total() }}</span> patients in queue
        </p>
        <div class="flex items-center gap-1.5">
            {{ $queue->links('pagination::tailwind') }}
        </div>
    </div>
@endif