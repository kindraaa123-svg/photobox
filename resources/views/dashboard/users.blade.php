@extends('layouts.dashboard')

@section('content')
<div class="space-y-8 animate-fadeIn">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="space-y-1">
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline">← Back to Dashboard</a>
            <h1 class="text-3xl font-black font-outfit text-purple-950 mt-2">Users Directory</h1>
            <p class="text-sm text-purple-500 font-medium">
                Review and audit registered accounts, user roles, levels, and administrative credentials.
            </p>
        </div>
        
        <!-- Add User Trigger Button -->
        <button onclick="openAddUserModal()" class="px-5 py-3 bg-gradient-to-tr from-pink-400 to-purple-400 hover:from-pink-500 hover:to-purple-500 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Add New User</span>
        </button>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2 shadow-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1 shadow-sm">
            @foreach($errors->all() as $error)
                <div class="flex items-center space-x-2">
                    <span>• {{ $error }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Users Table Panel -->
    <div class="glass-panel rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-purple-100 bg-purple-50/30 text-xs font-bold uppercase tracking-wider text-purple-900/70">
                        <th class="p-4 pl-6">ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role/Level</th>
                        <th class="p-4">Registered Date</th>
                        <th class="p-4 pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-50/50 text-sm">
                    @foreach($users as $u)
                        <tr class="hover:bg-purple-50/20 transition-colors">
                            <td class="p-4 pl-6 font-bold text-purple-400">#{{ $u->id }}</td>
                            <td class="p-4 font-bold text-purple-950">{{ $u->name }}</td>
                            <td class="p-4 font-semibold text-slate-500">{{ $u->email }}</td>
                            <td class="p-4">
                                @if($u->role === 'superadmin')
                                    <span class="px-2 py-0.5 rounded-full bg-red-100 border border-red-200 text-red-700 text-[10px] font-black uppercase tracking-wider">Superadmin</span>
                                @elseif($u->role === 'admin')
                                    <span class="px-2 py-0.5 rounded-full bg-indigo-100 border border-indigo-200 text-indigo-700 text-[10px] font-black uppercase tracking-wider">Admin</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-purple-100 border border-purple-200 text-purple-700 text-[10px] font-black uppercase tracking-wider">User</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-400 font-medium">{{ $u->created_at->format('M d, Y H:i') }}</td>
                            <td class="p-4 pr-6 text-right space-x-2">
                                <!-- Edit Button -->
                                <button onclick="openEditUserModal({{ json_encode($u) }})" class="px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-700 font-bold text-xs rounded-lg transition-colors inline-flex items-center space-x-1">
                                    <span>Edit</span>
                                </button>
                                
                                <!-- Delete Form Button -->
                                @if(Auth::id() !== $u->id)
                                    <form action="{{ route('dashboard.users.delete', $u->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete user {{ $u->name }}? This action is irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-lg transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 font-bold px-3 py-1.5 cursor-not-allowed">Self</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="p-4 border-t border-purple-50 bg-white/30">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal: Add User -->
<div id="addUserModal" class="fixed inset-0 bg-purple-950/40 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="glass-panel w-full max-w-md p-6 md:p-8 rounded-3xl space-y-6 shadow-2xl relative m-4 transform scale-95 transition-transform duration-300">
        <!-- Close Button -->
        <button onclick="closeModal('addUserModal')" class="absolute top-4 right-4 text-purple-400 hover:text-purple-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="space-y-1">
            <h3 class="text-xl font-black font-outfit text-purple-950">Add New User</h3>
            <p class="text-xs text-purple-500 font-semibold">Create a new credentials profile to access system privileges.</p>
        </div>

        <form action="{{ route('dashboard.users.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Full Name</label>
                <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold" placeholder="e.g. John Doe">
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Email Address</label>
                <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold" placeholder="e.g. john@example.com">
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold" placeholder="Minimum 8 characters">
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Role/Level</label>
                <select name="role" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold bg-white">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Superadmin</option>
                </select>
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-tr from-pink-400 to-purple-400 text-white font-black text-xs rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all mt-2">
                Save User Account
            </button>
        </form>
    </div>
</div>

<!-- Modal: Edit User -->
<div id="editUserModal" class="fixed inset-0 bg-purple-950/40 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="glass-panel w-full max-w-md p-6 md:p-8 rounded-3xl space-y-6 shadow-2xl relative m-4 transform scale-95 transition-transform duration-300">
        <!-- Close Button -->
        <button onclick="closeModal('editUserModal')" class="absolute top-4 right-4 text-purple-400 hover:text-purple-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="space-y-1">
            <h3 class="text-xl font-black font-outfit text-purple-950">Edit User Details</h3>
            <p class="text-xs text-purple-500 font-semibold">Modify permissions, email, and password credentials settings.</p>
        </div>

        <form id="editUserForm" method="POST" class="space-y-4">
            @csrf
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Full Name</label>
                <input type="text" name="name" id="edit_name" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold">
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Email Address</label>
                <input type="email" name="email" id="edit_email" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold">
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">New Password (Optional)</label>
                <input type="password" name="password" class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold" placeholder="Leave empty to keep current password">
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Role/Level</label>
                <select name="role" id="edit_role" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold bg-white">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Superadmin</option>
                </select>
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-tr from-pink-400 to-purple-400 text-white font-black text-xs rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all mt-2">
                Save Changes
            </button>
        </form>
    </div>
</div>

<script>
    function openAddUserModal() {
        const modal = document.getElementById('addUserModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    }

    function openEditUserModal(user) {
        // Set Action URL dynamically
        const form = document.getElementById('editUserForm');
        form.action = `/dashboard/users/${user.id}`;

        // Populate Fields
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;

        const modal = document.getElementById('editUserModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('opacity-0');
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
