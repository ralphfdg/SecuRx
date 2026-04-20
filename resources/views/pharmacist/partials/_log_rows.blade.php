@forelse($logs as $log)
    @php
        // Prepare the patient name based on your schema
        $patientName = 'Unknown / Walk-in';
        if ($log->prescriptionItem && $log->prescriptionItem->prescription && $log->prescriptionItem->prescription->patient) {
            $patientName = $log->prescriptionItem->prescription->patient->last_name . ', ' . $log->prescriptionItem->prescription->patient->first_name;
        }

        // Format a clean array of data to pass to Alpine.js for the Drawer
        $drawerData = [
            'uuid' => strtoupper(substr($log->prescription_item_id, 0, 8)),
            'time' => $log->dispensed_at ? $log->dispensed_at->format('M d, Y • h:i A') : 'N/A',
            'patient' => $patientName,
            'drug' => $log->actual_drug_dispensed,
            'qty' => $log->quantity_dispensed,
            'prescriber' => 'SecuRx Verified Doctor', // Fallback until doctor relationship is added
            'status' => 'Standard Dispense'
        ];
    @endphp

    <tr class="hover:bg-slate-50 transition group">
        <td class="p-4 pl-6 align-middle">
            <p class="font-bold text-securx-navy">{{ $log->dispensed_at ? $log->dispensed_at->format('h:i A') : 'N/A' }}</p>
            <p class="text-[10px] font-mono text-gray-500 mt-0.5 bg-white border border-gray-200 px-1.5 py-0.5 rounded inline-block">
                {{ strtoupper(substr($log->prescription_item_id, 0, 8)) }}
            </p>
        </td>
        <td class="p-4 align-middle">
            <p class="font-bold text-securx-navy">{{ $patientName }}</p>
            <p class="text-[10px] text-gray-500 mt-0.5 uppercase tracking-wider">
                Receiver: {{ $log->receiver_name_snapshot }}
            </p>
        </td>
        <td class="p-4 align-middle">
            <p class="font-bold text-gray-900">{{ $log->actual_drug_dispensed }}</p>
            <p class="text-xs text-gray-500 mt-0.5 font-mono">Qty: {{ $log->quantity_dispensed }}</p>
        </td>
        <td class="p-4 align-middle">
            <p class="font-medium text-gray-700">System Verified</p>
        </td>
        <td class="p-4 align-middle text-center">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black bg-emerald-50 text-emerald-700 uppercase tracking-widest border border-emerald-100">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Dispensed
            </div>
        </td>
        <td class="p-4 pr-6 align-middle text-right">
            <button @click="activeLog = {{ json_encode($drawerData) }}; showLogDrawer = true"
                class="px-3 py-1.5 bg-white border border-gray-200 text-xs font-bold text-gray-700 rounded-lg hover:border-securx-navy hover:text-securx-navy transition shadow-sm inline-block">
                View Log
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="p-8 text-center text-gray-400 font-medium">No dispensing logs match your search criteria.</td>
    </tr>
@endforelse

@if($logs->hasPages())
    <tr>
        <td colspan="6" class="p-4 border-t border-gray-100 bg-slate-50">
            {{ $logs->links() }}
        </td>
    </tr>
@endif