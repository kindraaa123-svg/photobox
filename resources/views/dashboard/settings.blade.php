@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto space-y-8 animate-fadeIn">
    
    <!-- Header -->
    <div class="space-y-1">
        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline">← Back to Dashboard</a>
        <h1 class="text-3xl font-black font-outfit text-purple-950 mt-2">System Settings</h1>
        <p class="text-sm text-purple-500 font-medium">
            Configure global website name, brand logo, and other system configuration attributes.
        </p>
    </div>

    <!-- Check Role Warning -->
    @if(!in_array(Auth::user()->role, ['superadmin', 'admin']))
        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold flex items-center space-x-2 shadow-sm">
            <span>Warning:</span>
            <span>You are logged in as a <strong>{{ Auth::user()->role }}</strong>. Only Admins and Superadmins have permission to save modifications to system settings.</span>
        </div>
    @endif

    <!-- settings Form Panel -->
    <div class="glass-panel rounded-3xl p-6 md:p-8 space-y-6">
        <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Web Name -->
            <div>
                <label for="web_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Website Name</label>
                <input id="web_name" name="web_name" type="text" required value="{{ old('web_name', $webName) }}"
                       {{ !in_array(Auth::user()->role, ['superadmin', 'admin']) ? 'disabled' : '' }}
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm disabled:opacity-50 disabled:bg-slate-100" placeholder="Photobox Studio">
            </div>

            <!-- Current Web Logo display -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Current Website Logo</label>
                <div class="flex items-center space-x-4 p-4 rounded-2xl bg-white/40 border border-purple-50">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-tr from-pink-100 to-purple-100 border border-purple-200 flex items-center justify-center shadow-inner overflow-hidden shrink-0">
                        @if($webLogo)
                            <img src="{{ asset($webLogo) }}" alt="Logo" class="w-full h-full object-contain p-2">
                        @else
                            <span class="text-xs font-black text-purple-400">Default SVG</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-purple-950">Active Brand Mark</p>
                        <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Uploaded logos are automatically resized for navbar fit.</p>
                    </div>
                </div>
            </div>

            <!-- Logo Upload -->
            <div>
                <label for="web_logo" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Upload New Logo</label>
                <input id="web_logo" name="web_logo" type="file" accept="image/*"
                       {{ !in_array(Auth::user()->role, ['superadmin', 'admin']) ? 'disabled' : '' }}
                       class="w-full px-4 py-2.5 rounded-2xl form-input text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 disabled:opacity-50 disabled:bg-slate-100 cursor-pointer">
                <p class="text-[10px] text-slate-400 font-medium mt-1">Supports PNG, JPG, JPEG, SVG. Max file size: 2MB.</p>
            </div>

            <!-- Submit Button -->
            @if(in_array(Auth::user()->role, ['superadmin', 'admin']))
                <button type="submit" class="w-full py-3.5 bg-gradient-to-tr from-pink-400 to-purple-400 text-white font-black text-sm rounded-2xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                    Update System Settings
                </button>
            @else
                <button type="button" disabled class="w-full py-3.5 bg-slate-300 text-slate-500 font-black text-sm rounded-2xl cursor-not-allowed">
                    Save Changes (Insufficient Permission)
                </button>
            @endif
        </form>
    </div>

</div>
@endsection
