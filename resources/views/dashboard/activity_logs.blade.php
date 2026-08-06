@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fadeIn">
    
    <!-- Header -->
    <div class="space-y-1">
        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline">← Back to Dashboard</a>
        <h1 class="text-3xl font-black font-outfit text-purple-950 mt-2">Activity Log</h1>
        <p class="text-sm text-purple-500 font-medium">
            Monitor and audit all administrative actions, logins, and system events.
        </p>
    </div>

    <!-- Logs Table Card -->
    <div class="glass-panel rounded-3xl p-6 md:p-8 space-y-6">
        <div class="overflow-x-auto rounded-2xl border border-purple-100 bg-white/50 backdrop-blur-sm">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-purple-950/5 text-purple-950 font-bold border-b border-purple-100 uppercase tracking-wider text-[10px]">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Activity</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">IP Address</th>
                        <th class="px-6 py-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-50/60 font-semibold text-slate-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-purple-50/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 font-black flex items-center justify-center text-[11px] uppercase shadow-sm">
                                        {{ substr($log->user ? $log->user->name : 'SYS', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-purple-950 text-xs">{{ $log->user ? $log->user->name : 'System' }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $log->user ? $log->user->email : '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] uppercase font-bold tracking-wider {{ 
                                    ($log->user && $log->user->role === 'superadmin') ? 'bg-pink-100 text-pink-700' : 
                                    (($log->user && $log->user->role === 'admin') ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600') 
                                }}">
                                    {{ $log->user ? $log->user->role : 'system' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-purple-900 text-xs">
                                {{ $log->activity }}
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-medium max-w-xs truncate" title="{{ $log->description }}">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-400">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-400">
                                {{ $log->created_at->format('M d, Y H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-semibold">
                                No activity logs recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="pt-4 border-t border-purple-50">
            {{ $logs->links() }}
        </div>
    </div>

</div>
@endsection
