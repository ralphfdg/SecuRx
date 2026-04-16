@extends('layouts.admin')

@section('page_title', 'User Management')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 relative">

    <div class="glass-panel p-6 bg-white/80 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-1">Professional User Management</h1>
            <p class="text-gray-600 font-medium text-sm">Review, verify, or reject medical staff registrations before granting network access.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="glass-panel p-4 bg-green-50/80 border border-green-200 text-green-700 rounded-xl shadow-sm flex items-center gap-3">
            <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <span class="font-bold block text-sm">Success!</span> 
                <span class="text-sm">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="glass-panel p-4 bg-red-50/80 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <span class="font-bold text-sm block mb-1">Action Blocked:</span>
            <ul class="list-disc ml-5 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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

    <div class="glass-panel overflow-hidden bg-white/80 flex flex-col border-t-4 border-t-securx-cyan shadow-sm">
        <div class="p-5 border-b border-gray-200/60 bg-gray-50/90 flex justify-between items-center">
            <h3 class="text-lg font-bold text-securx-navy">Active Staff Registry</h3>
        </div>
        
        <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-gray-50/90 backdrop-blur-sm z-10">
                    <tr class="text-xs text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-bold border-b border-gray-200/60">Name</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">Contact / Email</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">Role</th>
                        <th class="p-4 font-bold border-b border-gray-200/60">Status</th>
                        <th class="p-4 font-bold border-b border-gray-200/60 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100/50">
                    @forelse($activeUsers as $user)
                    <tr class="hover:bg-white/60 transition">
                        <td class="p-4 font-bold text-gray-800">{{ $user->name }}</td>
                        <td class="p-4 text-gray-500 font-medium">
                            {{ $user->email }}
                        </td>
                        <td class="p-4 capitalize text-gray-600 font-medium">{{ $user->role }}</td>
                        <td class="p-4">
                            @if(($user->status ?? 'active') === 'active')
                                <span class="px-2.5 py-1 bg-green-100/80 text-green-700 border border-green-200 text-xs font-bold rounded-full shadow-sm">Active</span>
                            @else
                                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 border border-yellow-200 text-xs font-bold rounded-full shadow-sm">Pending</span>
                            @endif
                        </td>
                        <td class="p-4 text-right whitespace-nowrap">
                            <button type="button" 
                                onclick="openEditUserModal('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}', '{{ $user->status ?? 'active' }}')" 
                                class="text-xs font-bold px-3 py-1.5 bg-gray-100 hover:bg-securx-cyan hover:text-white text-gray-600 rounded-lg transition-colors shadow-sm">
                                Edit
                            </button>
                            @if(auth()->id() !== $user->id)
                                <button type="button" 
                                    onclick="openArchiveUserModal('{{ $user->id }}', '{{ addslashes($user->name) }}')" 
                                    class="text-xs font-bold px-3 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 rounded-lg transition-colors ml-1 shadow-sm">
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-400 font-medium">No active medical staff found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div> <div id="edit-user-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all border-t-4 border-t-securx-cyan">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-securx-navy">Edit Staff Credentials</h3>
            <button onclick="closeEditUserModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="edit-user-form" method="POST" action="" class="p-6 space-y-4">
            @csrf
            @method('PATCH')
            
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Full Name</label>
                <input type="text" id="edit-user-name" name="name" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Email Address</label>
                <input type="email" id="edit-user-email" name="email" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">System Role</label>
                <select id="edit-user-role" name="role" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan bg-white">
                    <option value="admin">System Administrator</option>
                    <option value="doctor">Medical Doctor</option>
                    <option value="pharmacist">Pharmacist</option>
                    <option value="secretary">Clinic Secretary</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Account Status</label>
                <select id="edit-user-status" name="status" required class="w-full border-gray-200 rounded-xl text-sm focus:ring-securx-cyan focus:border-securx-cyan bg-white">
                    <option value="active">Active (Granted Access)</option>
                    <option value="pending">Pending (Needs Verification)</option>
                </select>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeEditUserModal()" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-securx-cyan text-white font-bold rounded-xl hover:bg-securx-navy transition-colors shadow-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div id="archive-user-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden transform transition-all text-center p-6 border-t-4 border-t-red-500">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-securx-navy mb-2">Delete Staff Member?</h3>
        <p class="text-sm text-gray-500 mb-6">Are you sure you want to revoke system access for <strong id="archive-user-name" class="text-gray-800"></strong>? Their previous clinical records and logs will remain intact.</p>
        
        <form id="archive-user-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeArchiveUserModal()" class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditUserModal(id, name, email, role, status) {
        document.getElementById('edit-user-form').action = `/admin/users/${id}`;
        document.getElementById('edit-user-name').value = name;
        document.getElementById('edit-user-email').value = email;
        document.getElementById('edit-user-role').value = role;
        document.getElementById('edit-user-status').value = status;
        document.getElementById('edit-user-modal').classList.remove('hidden');
    }

    function closeEditUserModal() {
        document.getElementById('edit-user-modal').classList.add('hidden');
    }

    function openArchiveUserModal(id, name) {
        document.getElementById('archive-user-form').action = `/admin/users/${id}`;
        document.getElementById('archive-user-name').textContent = name;
        document.getElementById('archive-user-modal').classList.remove('hidden');
    }

    function closeArchiveUserModal() {
        document.getElementById('archive-user-modal').classList.add('hidden');
    }
</script>

@endsection