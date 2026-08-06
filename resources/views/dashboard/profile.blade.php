@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto space-y-8 animate-fadeIn">
    
    <!-- Header -->
    <div class="space-y-1">
        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline">← Back to Dashboard</a>
        <h1 class="text-3xl font-black font-outfit text-purple-950 mt-2">Manage Profile Settings</h1>
        <p class="text-sm text-purple-500 font-medium">
            Update your personal account credentials, email address, and secure password.
        </p>
    </div>

    <!-- Profile Form Panel -->
    <div class="glass-panel rounded-3xl p-6 md:p-8 space-y-6">
        <form action="{{ route('dashboard.profile.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Level (Readonly badge) -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Account Level / Role</label>
                <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-xl bg-purple-50 border border-purple-100 text-purple-700 text-xs font-black uppercase tracking-wider">
                    <span> {{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <p class="text-[10px] text-slate-400 font-semibold mt-1">To request a role upgrade, contact the lead superadministrator.</p>
            </div>

            <!-- Name -->
            <div>
                <label for="profile_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Full Name</label>
                <input id="profile_name" name="name" type="text" required value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="John Doe">
            </div>

            <!-- Email -->
            <div>
                <label for="profile_email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                <input id="profile_email" name="email" type="email" required value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="you@example.com">
            </div>

            <div class="border-t border-purple-100/60 my-6"></div>

            <!-- Password Fields Info -->
            <div class="space-y-1">
                <h3 class="text-sm font-bold text-purple-950">Change Password</h3>
                <p class="text-xs text-slate-400 font-medium">Leave password fields blank if you do not wish to change your current password.</p>
            </div>

            <!-- New Password -->
            <div>
                <label for="profile_password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">New Password</label>
                <input id="profile_password" name="password" type="password"
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="•••••••• (Min. 8 chars)">
            </div>

            <!-- Confirm New Password -->
            <div>
                <label for="profile_password_confirmation" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Confirm New Password</label>
                <input id="profile_password_confirmation" name="password_confirmation" type="password"
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="••••••••">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 bg-gradient-to-tr from-pink-400 to-purple-400 text-white font-black text-sm rounded-2xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                Save Changes
            </button>
        </form>
    </div>

</div>
@endsection
