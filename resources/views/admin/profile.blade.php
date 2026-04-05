@extends('layouts.admin')

@section('page_title', 'My Profile')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden flex justify-between items-center">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1 flex items-center gap-2">
                <svg class="w-6 h-6 text-securx-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Personal Details
            </h1>
            <p class="text-gray-600 font-medium text-sm">Update your administrative account credentials and contact information.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="glass-panel p-4 bg-green-50/80 border border-green-200 text-green-700 rounded-xl shadow-sm relative">
            <span class="font-bold">Success!</span> {{ session('success') }}
        </div>
    @endif

    <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-t-4 border-t-securx-gold">
        <form action="{{ route('admin.profile.update') }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required class="w-full bg-white border border-gray-200 rounded-xl text-gray-800 focus:border-securx-cyan focus:ring-securx-cyan shadow-sm p-3">
                    @error('first_name') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required class="w-full bg-white border border-gray-200 rounded-xl text-gray-800 focus:border-securx-cyan focus:ring-securx-cyan shadow-sm p-3">
                    @error('last_name') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-white border border-gray-200 rounded-xl text-gray-800 focus:border-securx-cyan focus:ring-securx-cyan shadow-sm pl-10 p-3">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                @error('email') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-end border-t border-gray-200/60 mt-6">
                <button type="submit" class="py-3 px-8 bg-securx-cyan hover:bg-securx-navy text-white font-bold rounded-xl shadow-md transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Save Profile Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection