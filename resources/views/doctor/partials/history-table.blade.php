@forelse($encounters as $encounter)
    @php
        $patient = $encounter->patient;
        $initials = strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1));
        $rx = $encounter->prescriptions->first();
    @endphp

    <tr class="transition group {{ $rx && $rx->status === 'revoked' ? 'bg-red-50/30 hover:bg-red-50/50' : 'hover:bg-slate-50' }}">
        <td class="p-4 pl-6 align-top">
            <p class="font-bold {{ $rx && $rx->status === 'revoked' ? 'text-red-800' : 'text-securx-navy' }}">
                {{ \Carbon\Carbon::parse($encounter->encounter_date)->format('M d, Y') }}
            </p>
            <p class="text-xs {{ $rx && $rx->status === 'revoked' ? 'text-red-400' : 'text-gray-500' }} mt-0.5">
                {{ \Carbon\Carbon::parse($encounter->created_at)->format('h:i A') }}
            </p>
        </td>
        <td class="p-4 align-top">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full {{ $rx && $rx->status === 'revoked' ? 'bg-red-100 text-red-600' : 'bg-slate-100 text-gray-500' }} flex items-center justify-center font-bold text-xs shrink-0">
                    {{ $initials }}
                </div>
                <div>
                    <p class="font-bold {{ $rx && $rx->status === 'revoked' ? 'text-red-800' : 'text-securx-navy' }}">
                        {{ $patient->last_name }}, {{ $patient->first_name }}
                    </p>
                    <p class="text-[11px] {{ $rx && $rx->status === 'revoked' ? 'text-red-400' : 'text-gray-500' }} font-mono mt-0.5">
                        ID: {{ substr($patient->id, 0, 8) }}
                    </p>
                </div>
            </div>
        </td>
        <td class="p-4 align-top max-w-[250px] truncate">
            <p class="font-bold {{ $rx && $rx->status === 'revoked' ? 'text-red-800 line-through opacity-70' : 'text-securx-navy' }} truncate">
                {{ $encounter->assessment_note ?? 'No Diagnosis Logged' }}
            </p>
            <p class="text-xs {{ $rx && $rx->status === 'revoked' ? 'text-red-500 font-bold' : 'text-gray-500' }} mt-0.5 truncate">
                {{ $encounter->plan_note ?? '' }}
            </p>
        </td>
        <td class="p-4 align-top text-center">
            @if (!$rx)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black bg-gray-100 text-gray-500 uppercase tracking-widest border border-gray-200">No Rx</span>
            @elseif($rx->status === 'active')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black bg-blue-50 text-blue-600 uppercase tracking-widest border border-blue-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>Active
                </span>
            @elseif($rx->status === 'dispensed')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black bg-emerald-50 text-emerald-600 uppercase tracking-widest border border-emerald-100">Dispensed</span>
            @elseif($rx->status === 'revoked')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black bg-red-100 text-red-700 uppercase tracking-widest border border-red-200">Revoked</span>
            @endif
        </td>
        <td class="p-4 pr-6 align-top text-right">
            <div class="flex justify-end gap-2">
                <a href="{{ route('doctor.history.show', $encounter->id) }}" class="px-3 py-1.5 bg-white border border-gray-200 text-xs font-bold text-gray-600 rounded-lg hover:border-blue-300 hover:text-blue-600 transition shadow-sm inline-block">View</a>
                @if ($rx && $rx->status === 'active')
                    <button @click="showRevokeModal = true; activeRx = '{{ $rx->id }}'; activeRxDisplay = '{{ substr($rx->id, 0, 8) }}'" class="px-3 py-1.5 bg-red-50 border border-red-100 text-xs font-bold text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Revoke
                    </button>
                @endif
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="p-6 text-center text-gray-500 font-medium italic">No consultation history found matching your search.</td>
    </tr>
@endforelse

@if($encounters->hasPages())
    <tr class="bg-slate-50/50">
        <td colspan="5" class="p-4 border-t border-gray-100">
            {{ $encounters->links() }}
        </td>
    </tr>
@endif