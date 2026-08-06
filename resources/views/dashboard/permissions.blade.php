@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fadeIn">
    
    <!-- Header -->
    <div class="space-y-1">
        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline">← Back to Dashboard</a>
        <h1 class="text-3xl font-black font-outfit text-purple-950 mt-2">Hak Akses Role (Permissions Matrix)</h1>
        <p class="text-sm text-purple-500 font-medium">
            Configure feature privileges and authorization levels for system roles: Superadmin, Admin, and User.
        </p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2 shadow-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Permissions Matrix Panel -->
    <div class="glass-panel rounded-3xl p-6 md:p-8 shadow-sm">
        <form action="{{ route('dashboard.permissions.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="overflow-x-auto rounded-2xl border border-purple-100 bg-white/50 backdrop-blur-sm">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-purple-950/5 text-purple-950 font-bold border-b border-purple-100 uppercase tracking-wider text-[10px]">
                            <th class="px-6 py-4 w-1/2">Permission Module</th>
                            <th class="px-4 py-4 text-center">Superadmin</th>
                            <th class="px-4 py-4 text-center">Admin</th>
                            <th class="px-4 py-4 text-center">User</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-50/60 font-semibold text-slate-700">
                        @foreach($permissionsList as $key => $details)
                            <tr class="hover:bg-purple-50/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-purple-950 text-sm">{{ $details['name'] }}</div>
                                    <div class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $details['description'] }}</div>
                                </td>
                                
                                <!-- Superadmin Checkbox (Force checked and disabled or optional) -->
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="permissions[superadmin][]" value="{{ $key }}"
                                           {{ isset($matrix['superadmin'][$key]) ? 'checked' : '' }}
                                           class="w-4 h-4 rounded text-pink-500 border-purple-200 focus:ring-pink-400 cursor-pointer">
                                </td>

                                <!-- Admin Checkbox -->
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="permissions[admin][]" value="{{ $key }}"
                                           {{ isset($matrix['admin'][$key]) ? 'checked' : '' }}
                                           class="w-4 h-4 rounded text-pink-500 border-purple-200 focus:ring-pink-400 cursor-pointer">
                                </td>

                                <!-- User Checkbox -->
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="permissions[user][]" value="{{ $key }}"
                                           {{ isset($matrix['user'][$key]) ? 'checked' : '' }}
                                           class="w-4 h-4 rounded text-pink-500 border-purple-200 focus:ring-pink-400 cursor-pointer">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Action buttons -->
            <div class="flex justify-end pt-4 border-t border-purple-50">
                <button type="submit" class="px-6 py-3 bg-gradient-to-tr from-pink-400 to-purple-400 hover:from-pink-500 hover:to-purple-500 text-white font-black text-xs rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                    Save Permission Settings
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
