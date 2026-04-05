@extends('layouts.admin')

@section('page_title', 'User Management')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1">Professional User Management</h1>
            <p class="text-gray-600 font-medium text-sm">Review, verify, or reject medical staff registrations before granting network access.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="glass-panel p-4 bg-green-50/80 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <span class="font-bold">Success!</span> {{ session('success') }}
        </div>
    @endif

    <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-l-4 border-l-securx-gold">
        <div class="p-5 border-b border-gray-200/60 bg-securx-gold/5 flex justify-between items-center">
            <h3 class="text-lg font-bold text-securx-navy">Pending Verifications</h3>
            <span class="px-3 py-1 bg-securx-gold text-white text-xs font-bold rounded-full">{{ $pendingUsers->count() }} Awaiting</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/90 backdrop-blur-sm">
                    <tr class="text-xs text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-bold border-b border-gray-200/60">Name</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">Role</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">Contact / Email</th>
                        <th class="p-4 font-bold border-b border-gray-200/60 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                    @forelse($pendingUsers as $user)
                    <tr class="hover:bg-white/60 transition">
                        <td class="p-4 font-bold text-securx-navy">{{ $user->name }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-md text-xs font-bold capitalize 
                                {{ $user->role === 'doctor' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-500 font-medium">
                            {{ $user->email }}<br>
                            <span class="text-xs">{{ $user->mobile_num ?? 'N/A' }}</span>
                        </td>
                        <td class="p-4 flex items-center justify-end gap-2">
                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg shadow-sm transition">Verify</button>
                            </form>
                            <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this registration?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-bold rounded-lg transition">Reject</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400 font-medium italic">All caught up! There are no pending registrations.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="glass-panel overflow-hidden bg-white/60 flex flex-col opacity-80 hover:opacity-100 transition-opacity duration-300">
        <div class="p-5 border-b border-gray-200/60 bg-white/50">
            <h3 class="text-md font-bold text-gray-700">Active Staff Registry</h3>
        </div>
        
        <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-gray-50/90 backdrop-blur-sm z-10">
                    <tr class="text-xs text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-bold border-b border-gray-200/60">Name</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">Role</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                    @forelse($activeUsers as $user)
                    <tr class="hover:bg-white/60 transition">
                        <td class="p-4 font-bold text-gray-700">{{ $user->name }}</td>
                        <td class="p-4 capitalize text-gray-500">{{ $user->role }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Active</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-gray-400 font-medium">No active medical staff found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection