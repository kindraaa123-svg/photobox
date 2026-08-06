@extends('layouts.dashboard')

@section('content')
<div class="space-y-8 animate-fadeIn">
    
    <!-- Welcome Panel -->
    <div class="glass-panel rounded-[2rem] p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6 bg-gradient-to-tr from-purple-50/50 to-pink-50/50">
        <div class="space-y-2 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-black font-outfit text-purple-950">
                Welcome back, {{ Auth::user()->name }}! 
            </h1>
            <p class="text-sm text-purple-500 font-medium max-w-xl">
                Manage frames, view analytics, customize layout presets, and launch the Photobox Studio workspace from your centralized dashboard.
            </p>
            <div class="inline-flex items-center space-x-2 mt-2">
                <span class="text-xs font-bold text-purple-400">Current Role:</span>
                @if(Auth::user()->role === 'superadmin')
                    <span class="px-2.5 py-0.5 rounded-full bg-red-100 border border-red-200 text-red-700 text-[10px] font-black uppercase tracking-wider">Superadmin</span>
                @elseif(Auth::user()->role === 'admin')
                    <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 border border-indigo-200 text-indigo-700 text-[10px] font-black uppercase tracking-wider">Admin</span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full bg-purple-100 border border-purple-200 text-purple-700 text-[10px] font-black uppercase tracking-wider">Ordinary User</span>
                @endif
            </div>
        </div>
        
        <div class="shrink-0">
            <a href="{{ route('workspace') }}" class="inline-flex items-center space-x-2 px-8 py-4 bg-gradient-to-tr from-pink-400 to-purple-400 text-white font-black text-sm rounded-[2rem] shadow-lg shadow-pink-300/40 hover:shadow-xl hover:shadow-pink-300/50 transform hover:-translate-y-0.5 transition-all">
                <span>Launch Photobox Studio</span>
                <span></span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Users Card -->
        <div class="glass-panel rounded-2xl p-6 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.5a11.378 11.378 0 0 1-4.918-1.263v-.109c0-1.113.285-2.16.786-3.07M19.5 7.375a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM4 19.128v-.003c0-1.113.285-2.16.786-3.07M4 19.128v.109A11.386 11.386 0 0 1 10.089 20.5c-2.215 0-4.22-.63-5.918-1.723A4.125 4.125 0 0 0 2 18.25V18a2.25 2.25 0 0 1 2.25-2.25H6m4-3a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" />
                </svg>
            </div>
            <div>
                <div class="text-xs font-bold uppercase tracking-wider text-purple-400">Total Users</div>
                <div class="text-2xl font-black font-outfit text-purple-950 mt-0.5">{{ $stats['total_users'] }}</div>
            </div>
        </div>

        <!-- Total Templates Card -->
        <div class="glass-panel rounded-2xl p-6 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-pink-100 flex items-center justify-center text-pink-600 font-bold text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </div>
            <div>
                <div class="text-xs font-bold uppercase tracking-wider text-pink-400">Templates</div>
                <div class="text-2xl font-black font-outfit text-purple-950 mt-0.5">{{ $stats['total_frames'] }}</div>
            </div>
        </div>

        <!-- Total Creations Card -->
        <div class="glass-panel rounded-2xl p-6 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
                </svg>
            </div>
            <div>
                <div class="text-xs font-bold uppercase tracking-wider text-indigo-400">Global Creations</div>
                <div class="text-2xl font-black font-outfit text-purple-950 mt-0.5">{{ $stats['total_creations'] }}</div>
            </div>
        </div>

        <!-- My Creations Card -->
        <div class="glass-panel rounded-2xl p-6 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600 font-bold text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                </svg>
            </div>
            <div>
                <div class="text-xs font-bold uppercase tracking-wider text-green-400">My Saved Photos</div>
                <div class="text-2xl font-black font-outfit text-purple-950 mt-0.5">{{ $stats['my_creations'] }}</div>
            </div>
        </div>

    </div>

    <!-- Quick Tools / Content grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Quick Links -->
        <div class="lg:col-span-8 space-y-6">
            <div class="glass-panel rounded-3xl p-6 md:p-8 space-y-6">
                <h2 class="text-lg font-black font-outfit text-purple-950 border-b border-purple-50 pb-3">
                    Recent Activity Logs
                </h2>
                
                @if($recentCreations->isEmpty())
                    <div class="text-center py-12 text-slate-400">
                        <span class="block text-3xl mb-2"></span>
                        <p class="text-sm font-semibold">No recent creations captured yet.</p>
                        <a href="{{ route('workspace') }}" class="text-xs font-bold text-purple-600 hover:underline mt-1 inline-block">Go capture one!</a>
                    </div>
                @else
                    <div class="flow-root">
                        <ul role="list" class="-my-5 divide-y divide-purple-50/50">
                            @foreach($recentCreations as $creation)
                                <li class="py-4 flex items-center justify-between gap-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-14 h-14 rounded-xl border border-purple-100 overflow-hidden bg-purple-50 shrink-0">
                                            <img src="{{ asset($creation->image_path) }}" alt="Creation" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-purple-950">Captured Photoshoot</p>
                                            <p class="text-xs text-slate-400 font-medium">By: {{ $creation->user->name ?? 'Guest User' }} ({{ $creation->created_at->diffForHumans() }})</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset($creation->image_path) }}" target="_blank" class="px-3 py-1.5 text-xs font-bold text-purple-700 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                        View Image
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Shortcuts / Documentation info -->
        <div class="lg:col-span-4 space-y-6">
            <div class="glass-panel rounded-3xl p-6 space-y-4">
                <h3 class="text-sm font-black uppercase tracking-wider text-purple-700">Quick Shortcuts</h3>
                <div class="space-y-2">
                    <a href="{{ route('dashboard.profile') }}" class="w-full flex items-center justify-between p-3 rounded-xl bg-white/50 border border-purple-50 hover:bg-white transition-colors">
                        <span class="text-xs font-bold text-purple-950">My User Profile</span>
                        <span class="text-xs text-purple-400">➔</span>
                    </a>
                    <a href="{{ route('dashboard.settings') }}" class="w-full flex items-center justify-between p-3 rounded-xl bg-white/50 border border-purple-50 hover:bg-white transition-colors">
                        <span class="text-xs font-bold text-purple-950">Configure Website Settings</span>
                        <span class="text-xs text-purple-400">➔</span>
                    </a>
                    @if(in_array(Auth::user()->role, ['superadmin', 'admin']))
                        <a href="{{ route('dashboard.users') }}" class="w-full flex items-center justify-between p-3 rounded-xl bg-white/50 border border-purple-50 hover:bg-white transition-colors">
                            <span class="text-xs font-bold text-purple-950">Manage Registered Users</span>
                            <span class="text-xs text-purple-400">➔</span>
                        </a>
                        <a href="{{ route('dashboard.templates') }}" class="w-full flex items-center justify-between p-3 rounded-xl bg-white/50 border border-purple-50 hover:bg-white transition-colors">
                            <span class="text-xs font-bold text-purple-950">Manage Preset Templates</span>
                            <span class="text-xs text-purple-400">➔</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Role Permissions Cheat Sheet -->
            <div class="glass-panel rounded-3xl p-6 space-y-3">
                <h3 class="text-sm font-black uppercase tracking-wider text-purple-700">Role Permissions Guide</h3>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 shrink-0"></span>
                        <p class="text-slate-600 font-medium"><strong>Superadmin:</strong> Access all administration screens, manage users and layout templates, change website configuration.</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 shrink-0"></span>
                        <p class="text-slate-600 font-medium"><strong>Admin:</strong> View list of users, review preset templates, change website configuration.</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500 shrink-0"></span>
                        <p class="text-slate-600 font-medium"><strong>Ordinary User:</strong> Access dashboard summary, edit profile settings, perform photoshoots in Studio.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
