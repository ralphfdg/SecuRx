@extends('layouts.pharmacist')

@section('page_title', 'Dispense Medication')

@section('content')
    <div x-data="dispenseController()" class="max-w-6xl mx-auto space-y-6 pb-12 relative">

        <div class="flex items-center justify-between mb-2">
            <a href="{{ route('pharmacist.scanner') ?? '#' }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-securx-cyan transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Scanner
            </a>
            <div class="flex items-center gap-2 text-xs font-bold text-gray-400">
                <span>Step 1: Scan</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-securx-navy">Step 2: Dispense & Log</span>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 items-start">

            <div class="w-full lg:w-5/12 space-y-6 sticky top-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest">Target Prescription</h3>
                        <span
                            class="text-[10px] font-mono font-bold bg-white border border-gray-200 px-2 py-0.5 rounded text-securx-navy">ENCTR-8F92A</span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-black text-sm shrink-0">
                                RD</div>
                            <div>
                                <p class="text-lg font-black text-securx-navy leading-none">Ralph De Guzman</p>
                                <p class="text-xs text-gray-500 font-medium mt-1">21 yrs • Male</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 border border-gray-100 rounded-xl p-4 mb-4">
                            <h4 class="text-xl font-black text-gray-900">Amoxicillin 500mg cap</h4>
                            <p class="text-sm font-bold text-blue-600 mt-1">Sig: Take 1 cap TID for 7 days.</p>
                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                                <span class="text-xs text-gray-500 font-medium">Prescribed Qty:</span>
                                <span class="text-lg font-black text-gray-900">21 caps</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 text-sm">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                            <p class="text-gray-600 italic font-medium">"Dispense exact brand only. Do not substitute with
                                generics per patient request." <span class="block text-xs font-bold text-gray-400 mt-1">—
                                    Dr. J. Santos</span></p>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-5 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-red-500"></div>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-red-800">DUR Safety Block: Allergy</h3>
                            <p class="text-xs text-red-700 font-medium mt-1 mb-2">System detected a severe verified allergy
                                to <span class="font-bold underline">Penicillin</span>. Amoxicillin has a high
                                cross-reactivity risk.</p>
                            <span
                                class="inline-block bg-red-100 text-red-800 text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded">Clinical
                                Override Required</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="w-full lg:w-7/12">

                <form @submit.prevent="submitDispense"
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full">
                    <div class="p-6 border-b border-gray-100 bg-slate-50 flex justify-between items-center">
                        <h2 class="text-xl font-black text-securx-navy">Dispensing Ledger Entry</h2>
                        <p class="text-xs font-bold text-gray-500">{{ date('M d, Y • H:i A') }}</p>
                    </div>

                    <div x-show="!isSuccess" class="p-6 space-y-8 flex-1">

                        <div>
                            <h3
                                class="text-xs font-bold text-emerald-600 uppercase tracking-widest border-b border-emerald-100 pb-2 mb-4">
                                1. Inventory Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Actual Drug
                                        Dispensed *</label>
                                    <input type="text" x-model="form.drugName" required
                                        class="w-full bg-slate-50 border border-gray-200 text-sm font-bold text-gray-900 rounded-xl p-3 focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Scan barcode or type exact NDC/Brand...">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Quantity
                                        Dispensed *</label>
                                    <input type="number" x-model="form.qty" required
                                        class="w-full bg-slate-50 border border-gray-200 text-sm font-bold text-gray-900 rounded-xl p-3 focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Refills
                                        Remaining</label>
                                    <input type="number" value="0" readonly
                                        class="w-full bg-gray-100 border border-gray-200 text-sm font-bold text-gray-500 rounded-xl p-3 cursor-not-allowed">
                                </div>

                            </div>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-amber-400"></div>
                            <h3
                                class="text-xs font-black text-amber-800 uppercase tracking-widest mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                2. Mandatory Clinical Justification
                            </h3>
                            <p class="text-[11px] text-amber-700 font-medium mb-4">You are overriding a Level 1 Safety
                                Alert (Penicillin Allergy). You must document your clinical rationale for proceeding with
                                this dispense.</p>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1.5">Intervention
                                    Details / Override Reason *</label>
                                <textarea x-model="form.override" required
                                    class="w-full bg-white border border-amber-300 text-sm rounded-xl p-3 focus:ring-amber-500 focus:border-amber-500 h-24 resize-none shadow-inner"
                                    placeholder="e.g. Contacted Dr. Santos. Patient confirmed allergy is to Amoxil brand only, cleared to take generic."></textarea>
                            </div>

                            <div class="mt-3 flex items-center gap-2">
                                <input type="checkbox" required
                                    class="rounded text-amber-600 focus:ring-amber-500 border-gray-300 w-4 h-4 cursor-pointer">
                                <span class="text-[10px] font-bold text-amber-800">I acknowledge professional liability for
                                    this DUR override.</span>
                            </div>
                        </div>

                    </div>

                    <div x-show="isSuccess" x-transition.opacity
                        class="p-12 flex flex-col items-center justify-center text-center flex-1" style="display: none;">
                        <div
                            class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-500 mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-black text-securx-navy mb-2">Transaction Logged</h2>
                        <p class="text-sm text-gray-500 mb-6">Prescription ENCTR-8F92A has been successfully marked as
                            dispensed. The ledger has been permanently updated.</p>

                        <div class="flex gap-3 w-full max-w-sm">
                            <a href="{{ route('pharmacist.scanner') ?? '#' }}"
                                class="flex-1 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 rounded-xl transition text-sm">Scan
                                Next</a>
                            <button type="button"
                                class="flex-1 bg-securx-navy hover:bg-blue-800 text-white font-bold py-3 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                    </path>
                                </svg>
                                Print Label
                            </button>
                        </div>
                    </div>

                    <div x-show="!isSuccess"
                        class="p-5 border-t border-gray-200 bg-slate-50 flex justify-end gap-3 shrink-0">
                        <a href="{{ route('pharmacist.scanner') ?? '#' }}"
                            class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 px-6 rounded-xl transition text-sm">Cancel</a>

                        <button type="submit" :disabled="isSubmitting"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-[0_4px_14px_0_rgba(16,185,129,0.39)] flex items-center justify-center gap-2 text-sm min-w-[200px] disabled:opacity-70 disabled:cursor-not-allowed">

                            <span x-show="!isSubmitting">Sign & Log Transaction</span>

                            <span x-show="isSubmitting" style="display: none;" class="flex items-center gap-2">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Recording...
                            </span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('dispenseController', () => ({
                    isSubmitting: false,
                    isSuccess: false,

                    form: {
                        drugName: 'Amoxicillin 500mg cap (Brand)', // Pre-filled but editable
                        qty: 21,
                        lotNumber: '',
                        expiry: '',
                        override: ''
                    },

                    submitDispense() {
                        // Basic validation (HTML5 'required' handles most of this, but good to have)
                        if (!this.form.override || !this.form.lotNumber || !this.form.expiry) return;

                        this.isSubmitting = true;

                        // Simulate backend API call delay for saving the ledger & override log
                        setTimeout(() => {
                            this.isSubmitting = false;
                            this.isSuccess = true;
                        }, 1500);
                    }
                }))
            })
        </script>
    @endpush
@endsection
