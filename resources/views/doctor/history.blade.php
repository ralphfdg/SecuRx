@extends('layouts.doctor')

@section('page_title', 'Rx History & Revocation')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 relative">

    <div class="glass-panel p-6 bg-white/80 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-securx-navy">Prescription Ledger</h2>
            <p class="text-sm text-gray-500 mt-1">Monitor dispensing status and cryptographically revoke active prescriptions if an error was made.</p>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Search by patient or UUID..." class="glass-input w-full py-2 pl-10 pr-4">
            </div>
            <button class="glass-btn-secondary py-2 px-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
        </div>
    </div>

    <div class="glass-panel overflow-hidden bg-white/90">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-securx-navy text-xs text-white uppercase tracking-wider">
                        <th class="p-4 font-bold rounded-tl-lg">Date Issued</th>
                        <th class="p-4 font-bold">Patient Details</th>
                        <th class="p-4 font-bold">Medication & Sig</th>
                        <th class="p-4 font-bold">Cryptographic UUID</th>
                        <th class="p-4 font-bold text-center">Status</th>
                        <th class="p-4 font-bold text-right rounded-tr-lg">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200/60">
                    
                    <tr class="hover:bg-blue-50/50 transition" id="row-8F92A">
                        <td class="p-4 align-top">
                            <p class="font-bold text-securx-navy">Today</p>
                            <p class="text-xs text-gray-500">09:15 AM</p>
                        </td>
                        <td class="p-4 align-top">
                            <p class="font-bold text-securx-navy">Ralph De Guzman</p>
                            <p class="text-xs text-gray-500">DOB: Jan 15, 2005</p>
                        </td>
                        <td class="p-4 align-top">
                            <p class="font-bold text-securx-navy">Amoxicillin 500mg</p>
                            <p class="text-xs text-gray-600">Take 1 cap 3x a day for 7 days</p>
                            <p class="text-xs text-gray-400 mt-1">Qty: 21 | Refills: 0</p>
                        </td>
                        <td class="p-4 align-top font-mono font-bold text-gray-600">
                            8F92A-4B7C1
                        </td>
                        <td class="p-4 align-top text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-cyan-100 text-cyan-700 border border-cyan-200" id="status-8F92A">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse"></span> Active
                            </span>
                        </td>
                        <td class="p-4 align-top text-right">
                            <button onclick="openRevokeModal('8F92A-4B7C1', 'Ralph De Guzman', 'Amoxicillin 500mg')" id="btn-8F92A" class="text-xs font-bold bg-white text-red-600 border border-red-200 shadow-sm py-2 px-4 rounded-md hover:bg-red-50 hover:border-red-300 transition-colors flex items-center gap-2 ml-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Revoke Key
                            </button>
                        </td>
                    </tr>

                    <tr class="bg-gray-50/50">
                        <td class="p-4 align-top">
                            <p class="font-bold text-gray-600">Oct 24, 2026</p>
                            <p class="text-xs text-gray-400">14:30 PM</p>
                        </td>
                        <td class="p-4 align-top">
                            <p class="font-bold text-gray-600">Maria Clara</p>
                            <p class="text-xs text-gray-400">DOB: Oct 02, 1990</p>
                        </td>
                        <td class="p-4 align-top">
                            <p class="font-bold text-gray-600">Lisinopril 10mg</p>
                            <p class="text-xs text-gray-500">Take 1 tab daily</p>
                            <p class="text-xs text-gray-400 mt-1">Qty: 30 | Refills: 2</p>
                        </td>
                        <td class="p-4 align-top font-mono text-gray-500">
                            2C44F-9A1B2
                        </td>
                        <td class="p-4 align-top text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                Dispensed
                            </span>
                        </td>
                        <td class="p-4 align-top text-right">
                            <button class="text-xs font-bold text-gray-400 bg-gray-100 border border-gray-200 py-2 px-4 rounded-md cursor-not-allowed ml-auto">
                                Locked
                            </button>
                        </td>
                    </tr>

                    <tr class="bg-red-50/30">
                        <td class="p-4 align-top">
                            <p class="font-bold text-gray-600">Oct 20, 2026</p>
                            <p class="text-xs text-gray-400">08:10 AM</p>
                        </td>
                        <td class="p-4 align-top">
                            <p class="font-bold text-gray-600">Juan Dela Cruz</p>
                            <p class="text-xs text-gray-400">DOB: Mar 12, 1985</p>
                        </td>
                        <td class="p-4 align-top">
                            <p class="font-bold text-gray-600 line-through decoration-red-400">Ibuprofen 800mg</p>
                            <p class="text-xs text-gray-500">Take 1 tab every 6 hours</p>
                        </td>
                        <td class="p-4 align-top font-mono text-gray-500">
                            9X77D-3P2M1
                        </td>
                        <td class="p-4 align-top text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                Revoked
                            </span>
                        </td>
                        <td class="p-4 align-top text-right">
                            <p class="text-xs text-red-500 font-medium italic mt-2">Invalidated</p>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div id="revoke-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeRevokeModal()"></div>
        
        <div class="bg-white rounded-2xl shadow-2xl z-10 w-full max-w-md mx-4 overflow-hidden transform scale-95 transition-transform duration-300" id="revoke-modal-panel">
            <div class="bg-red-50 border-b border-red-100 p-6 flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center text-red-600 mb-4 border-4 border-white shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-red-700">Revoke Prescription?</h3>
                <p class="text-sm text-red-500 font-medium mt-1">This action is permanent and immediate.</p>
            </div>
            
            <div class="p-6 bg-white">
                <p class="text-sm text-gray-600 mb-4 text-center">You are about to cryptographically invalidate the following prescription UUID. The patient will no longer be able to claim this medication.</p>
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 font-bold">Patient:</span>
                        <span class="text-securx-navy font-bold" id="modal-patient"></span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 font-bold">Drug:</span>
                        <span class="text-securx-navy font-bold" id="modal-drug"></span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200 mt-2">
                        <span class="text-gray-500 font-bold">UUID:</span>
                        <span class="text-red-600 font-mono font-bold" id="modal-uuid"></span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button onclick="closeRevokeModal()" class="w-1/2 py-2.5 px-4 bg-white border border-gray-300 rounded-lg text-gray-700 font-bold hover:bg-gray-50 transition">Cancel</button>
                    <button onclick="executeRevocation()" class="w-1/2 py-2.5 px-4 bg-red-600 border border-red-600 rounded-lg text-white font-bold hover:bg-red-700 shadow-md shadow-red-500/30 transition">Yes, Revoke Key</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    let currentUUID = '';

    function openRevokeModal(uuid, patient, drug) {
        currentUUID = uuid;
        document.getElementById('modal-uuid').innerText = uuid;
        document.getElementById('modal-patient').innerText = patient;
        document.getElementById('modal-drug').innerText = drug;
        
        const modal = document.getElementById('revoke-modal');
        const panel = document.getElementById('revoke-modal-panel');
        
        modal.classList.remove('hidden');
        // Slight delay to allow display:block to apply before animating opacity
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            panel.classList.remove('scale-95');
            panel.classList.add('scale-100');
        }, 10);
    }

    function closeRevokeModal() {
        const modal = document.getElementById('revoke-modal');
        const panel = document.getElementById('revoke-modal-panel');
        
        modal.classList.add('opacity-0');
        panel.classList.remove('scale-100');
        panel.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function executeRevocation() {
        closeRevokeModal();
        
        // Target the specific row we are revoking (in this mock, the top row)
        const rowIdBase = currentUUID.split('-')[0]; // Grabs '8F92A'
        
        const statusBadge = document.getElementById('status-' + rowIdBase);
        const actionBtn = document.getElementById('btn-' + rowIdBase);
        const tableRow = document.getElementById('row-' + rowIdBase);

        if(statusBadge && actionBtn) {
            // Change Status Badge to Revoked
            statusBadge.className = "inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200";
            statusBadge.innerHTML = "Revoked";

            // Remove the Revoke Button and replace with text
            actionBtn.outerHTML = `<p class="text-xs text-red-500 font-medium italic mt-2">Invalidated Just Now</p>`;
            
            // Change Row Background to indicate it is dead
            tableRow.classList.remove('hover:bg-blue-50/50');
            tableRow.classList.add('bg-red-50/30');
        }
    }
</script>
@endsection