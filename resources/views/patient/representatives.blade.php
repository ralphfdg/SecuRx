@extends('layouts.patient')

@section('page_title', 'Authorized Representatives')

@section('content')
<div class="w-full space-y-6">

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl border border-green-200 font-medium text-sm flex items-center gap-2 w-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="glass-panel p-6 bg-white/80 flex flex-col md:flex-row md:items-center justify-between gap-4 w-full">
        <div>
            <h2 class="text-2xl font-extrabold text-securx-navy">My Representatives</h2>
            <p class="text-sm text-gray-500 mt-1">Manage family members or caregivers authorized to pick up your SecuRx prescriptions.</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 w-full items-start">
        
        <div class="w-full lg:w-[35%] shrink-0">
            <div class="glass-panel bg-white p-6 shadow-sm sticky top-6 w-full">
                <h3 class="text-lg font-bold text-securx-navy mb-4 border-b border-gray-100 pb-2">Add New Representative</h3>
                
                <form action="{{ route('patient.representatives.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Full Name</label>
                        <input type="text" name="full_name" required placeholder="e.g., Jane Doe"
                            class="w-full py-2.5 px-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-securx-cyan outline-none transition">
                        @error('full_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Relationship</label>
                        <input type="text" name="relationship" required placeholder="e.g., Spouse, Caregiver"
                            class="w-full py-2.5 px-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-securx-cyan outline-none transition">
                        @error('relationship') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-securx-cyan hover:bg-cyan-500 text-white font-bold py-2.5 px-4 rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Authorize Person
                    </button>
                    <p class="text-[10px] text-gray-400 text-center mt-3 leading-tight">
                        By adding a representative, you grant them legal permission to decrypt and claim your medications at verified pharmacies.
                    </p>
                </form>
            </div>
        </div>

        <div class="w-full lg:w-[65%] space-y-4">
            @forelse($representatives as $rep)
                <div class="glass-panel bg-white/60 p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-l-4 {{ $rep->is_active ? 'border-securx-cyan' : 'border-gray-300 opacity-60' }} transition-all w-full">
                    
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 {{ $rep->is_active ? 'bg-blue-50 text-securx-cyan' : 'bg-gray-100 text-gray-400' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-securx-navy {{ !$rep->is_active ? 'line-through text-gray-500' : '' }}">{{ $rep->full_name }}</h3>
                            <p class="text-sm font-medium text-gray-500">{{ $rep->relationship }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-3 sm:pt-0 border-t sm:border-0 border-gray-200">
                        <form action="{{ route('patient.representatives.toggle', $rep->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border transition-colors {{ $rep->is_active ? 'bg-amber-50 text-amber-600 border-amber-200 hover:bg-amber-100' : 'bg-green-50 text-green-600 border-green-200 hover:bg-green-100' }}">
                                {{ $rep->is_active ? 'Revoke' : 'Reactivate' }}
                            </button>
                        </form>

                        <form action="{{ route('patient.representatives.destroy', $rep->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently remove this representative?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors" title="Delete Representative">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="glass-panel bg-white/50 border-dashed border-2 border-gray-300 flex flex-col items-center justify-center py-16 px-4 text-center rounded-2xl w-full">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3 border border-gray-200">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-securx-navy mb-1">No Representatives Found</h3>
                    <p class="text-gray-500 max-w-sm text-sm">You haven't authorized anyone to pick up your prescriptions yet. Add someone using the form.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection