@extends('layouts.pharmacist')

@section('page_title', 'Dispense Medication')

@section('content')
@php
    $hasSevere = collect($durWarnings)->where('level', 'Severe')->isNotEmpty();
    $hasWarning = collect($durWarnings)->where('level', 'Warning')->isNotEmpty();
    $hasAdvisory = collect($durWarnings)->where('level', 'Advisory')->isNotEmpty();
    $requiresOverride = $hasSevere || $hasWarning;
    $totalAlerts = count($durWarnings);

    // Dynamic Colors for Box 3
    $notesBgClass = $hasSevere ? 'bg-red-50 border-red-300' : ($hasWarning ? 'bg-amber-50 border-amber-300' : ($hasAdvisory ? 'bg-blue-50 border-blue-300' : 'bg-slate-50 border-gray-200'));
    $notesTextClass = $hasSevere ? 'text-red-900' : ($hasWarning ? 'text-amber-900' : ($hasAdvisory ? 'text-blue-900' : 'text-slate-800'));
    $btnClass = $hasSevere ? 'bg-red-100 text-red-800 hover:bg-red-200' : ($hasWarning ? 'bg-amber-100 text-amber-800 hover:bg-amber-200' : 'bg-blue-100 text-blue-800 hover:bg-blue-200');
@endphp

    <div x-data="dispenseController('{{ $prescription->id }}', {{ json_encode($prescription->items->where('status', '!=', 'completed')->values()) }}, '{{ route('pharmacist.api.dispense', $prescription->id) }}', {{ $requiresOverride ? 'true' : 'false' }})" class="max-w-7xl mx-auto h-[calc(100vh-7rem)] relative flex flex-col pb-4">
        
        <div x-show="isSuccess" x-transition.opacity class="p-16 flex flex-col items-center justify-center text-center bg-white rounded-2xl shadow-sm border border-gray-200 h-full" style="display: none;">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-500 mb-6 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-3xl font-black text-securx-navy mb-3">Transaction Logged</h2>
            <p class="text-base text-gray-500 mb-8 max-w-md">The ledger has been securely updated. Tingi balances and override logs have been committed to the database.</p>
            <div class="flex gap-4 w-full justify-center">
                <a href="{{ route('pharmacist.scanner') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-3 px-8 rounded-xl transition text-sm shadow-sm">Scan Next Patient</a>
            </div>
        </div>

        <form x-show="!isSuccess" @submit.prevent="submitDispense" class="flex flex-col lg:flex-row gap-8 items-start h-full overflow-hidden">
            
            <div class="w-full lg:w-1/2 flex flex-col gap-4 h-full min-h-0">
                
                <div class="bg-white shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 relative flex flex-col w-full rounded-sm overflow-hidden flex-1 min-h-0">
                    <div class="h-2 w-full bg-securx-navy shrink-0"></div>

                    <div class="p-6 flex-1 flex flex-col relative z-10 min-h-0">
                        <div class="w-full flex justify-center mb-4 shrink-0">
                            <img src="{{ asset('images/logo-1.png') }}" alt="SecuRx" class="h-4 w-auto">
                        </div>

                        <div class="flex flex-row items-center gap-4 border-b-2 border-gray-800 pb-4 mb-4 shrink-0">
                            <div class="w-14 h-14 bg-white border border-gray-200 rounded-lg flex flex-col items-center justify-center shrink-0 overflow-hidden">
                                @if (!empty($prescription->doctor->doctorProfile->clinic->clinic_logo))
                                    <img src="{{ asset('storage/' . $prescription->doctor->doctorProfile->clinic->clinic_logo) }}" alt="Clinic Logo" class="w-full h-full object-contain p-1">
                                @else
                                    <svg class="w-7 h-7 text-blue-800 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                @endif
                            </div>
                            <div class="flex-1 flex flex-col min-w-0">
                                <h1 class="text-lg sm:text-xl font-serif font-black text-gray-900 tracking-wide uppercase text-center mb-1 leading-tight">{{ $prescription->doctor->doctorProfile->clinic->clinic_name ?? 'MEDICAL CLINIC INC.' }}</h1>
                                <div class="flex flex-col xl:flex-row justify-between items-center xl:items-start gap-1 w-full">
                                    <p class="text-[10px] sm:text-[11px] font-serif text-gray-600 leading-snug flex-1 text-center xl:text-left">{{ $prescription->doctor->doctorProfile->clinic->clinic_address ?? '123 Health Avenue, Medical District' }}</p>
                                    <p class="text-[10px] sm:text-[11px] font-serif text-gray-800 font-bold shrink-0 text-center xl:text-right whitespace-nowrap mt-0.5 xl:mt-0">Tel: {{ $prescription->doctor->doctorProfile->clinic->contact_number ?? '(000) 123-4567' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-[10px] font-serif text-gray-800 mb-4 border-b border-gray-300 pb-3 shrink-0">
                            <div class="col-span-2">
                                <p class="text-[8px] font-bold text-gray-500 uppercase">Name:</p>
                                <p class="font-bold border-b border-gray-300 border-dotted truncate text-gray-900">{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</p>
                            </div>
                            <div class="col-span-1">
                                <p class="text-[8px] font-bold text-gray-500 uppercase">Age/Sex:</p>
                                <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">{{ \Carbon\Carbon::parse($prescription->patient->dob)->age }}/{{ strtoupper(substr($prescription->patient->gender, 0, 1)) }}</p>
                            </div>
                            <div class="col-span-1">
                                <p class="text-[8px] font-bold text-gray-500 uppercase">Date:</p>
                                <p class="font-bold border-b border-gray-300 border-dotted text-gray-900">{{ $prescription->created_at->format('m/d/Y') }}</p>
                            </div>
                        </div>

                        <div class="mb-2 shrink-0">
                            <span class="text-4xl font-serif font-black text-gray-900 italic tracking-tighter">Rx</span>
                        </div>

                        <div class="flex-1 space-y-4 pl-1 font-serif overflow-y-auto custom-scrollbar pr-2 flex flex-col relative min-h-0">
                            @foreach ($prescription->items as $index => $item)
                                <div class="relative group border-b border-gray-100 pb-3">
                                    @if ($item->status === 'completed')
                                        <div class="absolute inset-0 bg-white/70 backdrop-blur-[1px] z-10 flex items-center justify-center">
                                            <span class="bg-gray-800 text-white text-[10px] font-sans font-bold px-3 py-1 rounded-full shadow-sm tracking-widest">FULLY DISPENSED</span>
                                        </div>
                                    @endif
                                    <p class="text-sm font-bold text-gray-900 flex items-center flex-wrap gap-2">
                                        <span>{{ $index + 1 }}.{{ $item->medication->generic_name }} </span>
                                        @if ($item->medication->dosage_strength)
                                            <span class="bg-red-100 text-red-700 border border-red-200 font-black px-1.5 py-0.5 rounded text-[9px] uppercase tracking-wider shadow-sm">{{ $item->medication->dosage_strength }}</span>
                                        @endif
                                        <span class="text-xs text-gray-500 font-medium">({{ $item->medication->brand_name }})</span>
                                    </p>
                                    <div class="flex justify-between items-end mt-1.5">
                                        <p class="text-xs text-gray-700 italic">Sig: {{ $item->sig }}</p>
                                        <p class="text-xs font-bold text-gray-900">#{{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-[11px] font-sans font-bold text-emerald-600 mt-1">Remaining: {{ $item->quantity_remaining ?? $item->quantity }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-100 shrink-0">
                            <div class="flex justify-between items-end">
                                <div class="w-14 h-14 bg-gray-50 border border-gray-200 flex flex-col items-center justify-center shrink-0 rounded-lg">
                                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-[6px] text-emerald-600 mt-1 font-sans font-bold tracking-widest">VERIFIED</span>
                                </div>
                                <div class="text-left w-[160px] ml-auto flex flex-col font-serif">
                                    <div class="relative z-0 space-y-1 text-[10px]">
                                        <div class="relative">
                                            <span class="text-gray-400 tracking-tighter">____________________, MD</span>
                                            <span class="absolute left-0.5 bottom-0.5 font-sans font-bold text-blue-800 uppercase opacity-90 truncate max-w-[140px] inline-block">DR. {{ $prescription->doctor->last_name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex justify-between gap-4 shrink-0">
                    <a href="{{ route('pharmacist.scanner') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-3 px-6 rounded-lg transition text-sm">Cancel</a>
                    <button type="submit" :disabled="!isFormValid || isSubmitting" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-sm flex items-center justify-center gap-2 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!isSubmitting">Sign & Log Transaction</span>
                        <span x-show="isSubmitting" style="display: none;" class="flex items-center gap-2">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Recording...
                        </span>
                    </button>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col h-full overflow-y-auto custom-scrollbar pr-2 pb-6 space-y-6">
                
                <div x-show="errorMessage" x-text="errorMessage" class="bg-red-50 text-red-700 p-3 rounded-lg text-sm font-bold border border-red-200 shrink-0" style="display: none;"></div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm shrink-0">
                    <h3 class="text-sm font-black text-securx-navy uppercase tracking-widest mb-5 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        1. Receiver Verification
                    </h3>
                    <div class="mb-5">
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-3">Picked up by</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" value="patient" x-model="pickup_type" class="text-securx-cyan focus:ring-securx-cyan w-4 h-4">
                                <span class="text-sm font-bold text-gray-800">Patient</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" value="proxy" x-model="pickup_type" class="text-securx-cyan focus:ring-securx-cyan w-4 h-4">
                                <span class="text-sm font-bold text-gray-800">Authorized Representative</span>
                            </label>
                        </div>
                    </div>
                    <div x-show="is_proxy" x-collapse class="mb-5">
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-2">Representative Name *</label>
                        <input type="text" x-model="representative_name" :required="is_proxy" placeholder="e.g. Jane Doe (Wife)" class="w-full bg-slate-50 border border-gray-300 text-sm font-bold text-gray-900 rounded-lg p-3 focus:ring-securx-cyan">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-2">Valid ID Presented *</label>
                        <input type="text" x-model="receiver_id_presented" required placeholder="e.g. Driver's License - N04-12-12345" class="w-full bg-slate-50 border border-gray-300 text-sm font-bold text-gray-900 rounded-lg p-3 focus:ring-securx-cyan">
                    </div>
                </div>

                <div class="space-y-4 shrink-0">
                    <h3 class="text-sm font-black text-gray-700 uppercase tracking-widest mb-2 ml-1">2. Dispensary</h3>
                    <template x-for="(row, index) in itemsForm" :key="row.item_id">
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm transition-all" :class="row.selected ? 'ring-2 ring-emerald-500/20' : 'opacity-60'">
                            <div class="p-4 border-b border-gray-100 flex items-center gap-3 cursor-pointer hover:bg-gray-50 transition" @click="row.selected = !row.selected">
                                <input type="checkbox" x-model="row.selected" class="rounded text-emerald-600 focus:ring-emerald-500 w-5 h-5 cursor-pointer">
                                <div class="flex-1">
                                    <p class="text-base font-black text-securx-navy" x-text="row.name"></p>
                                </div>
                            </div>
                            <div x-show="row.selected" x-collapse class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5 bg-white">
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-2">Actual Drug/s Dispensed *</label>
                                    <input type="text" x-model="row.actual_drug_dispensed" :required="row.selected" class="w-full bg-white border border-gray-300 text-sm font-bold text-gray-900 rounded-lg p-3 focus:ring-emerald-500 shadow-sm" placeholder="e.g. Biogesic 500mg">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-2">Quantity Dispensed *</label>
                                    <input type="number" x-model="row.quantity_dispensed" min="1" :max="row.max_qty" :required="row.selected" class="w-full bg-white border border-gray-300 text-sm font-bold text-gray-900 rounded-lg p-3 focus:ring-emerald-500 shadow-sm">
                                    <p class="text-[10px] text-gray-500 mt-1" x-text="'Max remaining: ' + row.max_qty"></p>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-2">Lot Number *</label>
                                    <input type="text" x-model="row.lot_number" :required="row.selected" class="w-full bg-white border border-gray-300 text-sm font-bold text-gray-900 rounded-lg p-3 focus:ring-emerald-500 shadow-sm">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-2">Expiry Date *</label>
                                    <input type="date" x-model="row.expiry_date" :required="row.selected" class="w-full bg-white border border-gray-300 text-sm font-bold text-gray-900 rounded-lg p-3 focus:ring-emerald-500 shadow-sm">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="{{ $notesBgClass }} border rounded-xl p-6 relative overflow-hidden shadow-sm shrink-0">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-sm font-black {{ $notesTextClass }} uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            3. Transaction Clinical Notes
                        </h3>
                        @if ($totalAlerts > 0)
                            <button type="button" @click="isDrawerOpen = true" class="{{ $btnClass }} px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition shadow-sm">See More</button>
                        @endif
                    </div>

                    @if ($totalAlerts > 0)
                        <div class="mb-5 space-y-2">
                            @foreach ($durWarnings as $warning)
                                @if ($warning['level'] === 'Severe')
                                    <div class="bg-red-100 text-red-800 border border-red-200 p-2.5 rounded-lg text-xs flex gap-2 shadow-sm truncate">
                                        <span class="font-black shrink-0">BLOCK:</span> <span class="truncate">{{ $warning['item'] }} - {{ $warning['type'] }}</span>
                                    </div>
                                @elseif ($warning['level'] === 'Warning')
                                    <div class="bg-amber-100 text-amber-800 border border-amber-200 p-2.5 rounded-lg text-xs flex gap-2 shadow-sm truncate">
                                        <span class="font-black shrink-0">WARN:</span> <span class="truncate">{{ $warning['item'] }} - {{ $warning['type'] }}</span>
                                    </div>
                                @else
                                    <div class="bg-blue-100 text-blue-800 border border-blue-200 p-2.5 rounded-lg text-xs flex gap-2 shadow-sm truncate">
                                        <span class="font-black shrink-0">INFO:</span> <span class="truncate">{{ $warning['item'] }} - {{ $warning['type'] }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <label class="block text-[11px] font-bold {{ $notesTextClass }} uppercase tracking-wide mb-2">
                            Clinical Override Notes 
                            @if($requiresOverride)
                                <span class="text-red-500 font-black">* REQUIRED</span>
                            @else
                                <span class="opacity-70 font-medium">(Optional)</span>
                            @endif
                        </label>
                        
                        <textarea x-model="global_override_reason" {{ $requiresOverride ? 'required' : '' }}
                            class="w-full bg-white border border-gray-300 text-sm rounded-xl p-4 focus:ring-securx-cyan h-28 resize-none shadow-inner"
                            placeholder="e.g. Contacted Doctor. Cleared to substitute generic."></textarea>
                    </div>

                    @if ($requiresOverride)
                        <div class="mt-4 flex items-start gap-3 bg-white/60 p-3 border border-gray-200 rounded-lg">
                            <input type="checkbox" required class="rounded text-red-600 focus:ring-red-500 border-gray-300 w-4 h-4 cursor-pointer mt-0.5">
                            <span class="text-[11px] font-bold text-gray-800 leading-tight">I acknowledge the clinical alerts above and assume professional liability for this override.</span>
                        </div>
                    @endif
                </div>
            </div>
        </form>

        <div x-show="isDrawerOpen" style="display: none;" class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div x-show="isDrawerOpen" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-40 backdrop-blur-sm transition-opacity" @click="isDrawerOpen = false"></div>
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                        <div x-show="isDrawerOpen" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-md">
                            
                            <div class="flex h-full flex-col bg-white shadow-2xl relative">
                                <div class="sticky top-0 z-50 px-6 py-5 sm:px-8 border-b border-gray-200 bg-red-50 flex items-center justify-between shadow-sm">
                                    <h2 class="text-lg font-black text-red-900 flex items-center gap-2">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        Safety Alerts Details
                                    </h2>
                                    <button type="button" @click="isDrawerOpen = false" class="bg-white border border-gray-200 rounded-lg p-2 text-gray-400 hover:text-red-600 hover:border-red-200 focus:outline-none shadow-sm transition">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                
                                <div class="relative flex-1 px-6 py-6 sm:px-8 overflow-y-auto space-y-4 bg-gray-50">
                                    @foreach ($durWarnings as $warning)
                                        @php
                                            $borderClass = $warning['level'] === 'Severe' ? 'border-red-500' : ($warning['level'] === 'Warning' ? 'border-amber-500' : 'border-blue-500');
                                            $textClass = $warning['level'] === 'Severe' ? 'text-red-900' : ($warning['level'] === 'Warning' ? 'text-amber-900' : 'text-blue-900');
                                        @endphp
                                        <div class="bg-white border-l-4 {{ $borderClass }} rounded-lg p-5 shadow-sm">
                                            <h3 class="text-xs font-black {{ $textClass }} uppercase tracking-wider mb-2">{{ $warning['level'] }}: {{ $warning['type'] }}</h3>
                                            <p class="text-sm text-gray-800 mb-3"><b>{{ $warning['item'] }}</b></p>
                                            <p class="text-xs text-gray-600 leading-relaxed">{{ $warning['message'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection