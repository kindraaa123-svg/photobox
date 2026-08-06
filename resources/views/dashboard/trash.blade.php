@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fadeIn">
    
    <!-- Header -->
    <div class="space-y-1">
        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline">← Back to Dashboard</a>
        <h1 class="text-3xl font-black font-outfit text-purple-950 mt-2">Tong Sampah (Trash Bin)</h1>
        <p class="text-sm text-purple-500 font-medium">
            Restore recently deleted master data records or delete them permanently from the system database.
        </p>
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
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Section 1: Deleted Users -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-purple-950 font-outfit">Deleted Users</h2>
        <div class="glass-panel rounded-3xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-purple-100 bg-purple-50/30 text-xs font-bold uppercase tracking-wider text-purple-900/70">
                            <th class="p-4 pl-6">ID</th>
                            <th class="p-4">Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Deleted Date</th>
                            <th class="p-4 pr-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-50/50 text-sm">
                        @forelse($deletedUsers as $u)
                            <tr class="hover:bg-purple-50/20 transition-colors">
                                <td class="p-4 pl-6 font-bold text-purple-400">#{{ $u->id }}</td>
                                <td class="p-4 font-bold text-purple-950">{{ $u->name }}</td>
                                <td class="p-4 font-semibold text-slate-500">{{ $u->email }}</td>
                                <td class="p-4 text-slate-400 font-medium">{{ $u->deleted_at->format('M d, Y H:i') }}</td>
                                <td class="p-4 pr-6 text-right space-x-2">
                                    <!-- Restore Button -->
                                    <form action="{{ route('dashboard.trash.restore', ['type' => 'user', 'id' => $u->id]) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs rounded-lg transition-colors">
                                            Restore
                                        </button>
                                    </form>
                                    
                                    <!-- Force Delete Button -->
                                    <form action="{{ route('dashboard.trash.force_delete', ['type' => 'user', 'id' => $u->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to permanently delete user {{ $u->name }}? This action CANNOT be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-lg transition-colors">
                                            Delete Permanent
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400 font-semibold">
                                    No deleted users found in the trash bin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 2: Deleted Templates -->
    <div class="space-y-4 pt-4">
        <h2 class="text-lg font-bold text-purple-950 font-outfit">Deleted Frame Templates</h2>
        <div class="glass-panel rounded-3xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-purple-100 bg-purple-50/30 text-xs font-bold uppercase tracking-wider text-purple-900/70">
                            <th class="p-4 pl-6">ID</th>
                            <th class="p-4">Template Name</th>
                            <th class="p-4">Layout Type</th>
                            <th class="p-4">Deleted Date</th>
                            <th class="p-4 pr-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-50/50 text-sm">
                        @forelse($deletedFrames as $f)
                            <tr class="hover:bg-purple-50/20 transition-colors">
                                <td class="p-4 pl-6 font-bold text-purple-400">#{{ $f->id }}</td>
                                <td class="p-4 font-bold text-purple-950">{{ $f->name }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 text-[10px] font-black uppercase tracking-wider">
                                        {{ $f->layout_type }}
                                    </span>
                                </td>
                                <td class="p-4 text-slate-400 font-medium">{{ $f->deleted_at->format('M d, Y H:i') }}</td>
                                <td class="p-4 pr-6 text-right space-x-2">
                                    <!-- Restore Button -->
                                    <form action="{{ route('dashboard.trash.restore', ['type' => 'template', 'id' => $f->id]) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs rounded-lg transition-colors">
                                            Restore
                                        </button>
                                    </form>
                                    
                                    <!-- Force Delete Button -->
                                    <form action="{{ route('dashboard.trash.force_delete', ['type' => 'template', 'id' => $f->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to permanently delete template {{ $f->name }}? This action CANNOT be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-lg transition-colors">
                                            Delete Permanent
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400 font-semibold">
                                    No deleted templates found in the trash bin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
