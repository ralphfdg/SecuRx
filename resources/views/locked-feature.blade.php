@extends('layouts.master')

@section('header', 'Feature In Development')

@section('content')
<div class="flex flex-col items-center justify-center h-full text-center">
    <div class="bg-blue-50 text-blue-600 p-6 rounded-full mb-6">
        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
    </div>
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Locked for Phase 2</h2>
    <p class="text-gray-500 max-w-md mx-auto mb-8">
        This module is part of the extended system architecture and is not required for the Phase 1 MVP Capstone Defense.
    </p>
    <a href="{{ url()->previous() }}" class="px-6 py-2 bg-slate-900 text-white rounded shadow hover:bg-slate-800 transition">
        Go Back
    </a>
</div>
@endsection