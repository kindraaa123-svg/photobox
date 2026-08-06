<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::getVal('web_name', 'Photobox Studio') }} - Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: radial-gradient(circle at 50% 50%, #fff5f7 0%, #f3e8ff 100%);
            min-height: 100vh;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 32px 0 rgba(214, 180, 230, 0.15);
        }
        .nav-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 50;
            min-width: 220px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(243, 232, 255, 0.8);
            box-shadow: 0 10px 25px -5px rgba(214, 180, 230, 0.3);
            border-radius: 1rem;
            padding: 0.5rem;
            animation: fadeIn 0.15s ease-out;
        }
        .nav-item-container:hover .nav-dropdown {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-input {
            background: #ffffff;
            border: 2px solid #ecdff6;
            color: #4a3856;
            transition: all 0.25s ease-in-out;
        }
        .form-input:focus {
            border-color: #ffb7b2;
            background: #ffffff;
            outline: none;
            box-shadow: 0 0 0 4px rgba(255, 183, 178, 0.25);
        }
    </style>
</head>
<body class="text-slate-700 antialiased flex flex-col">
    <!-- Navbar Header -->
    <header class="border-b border-purple-100 bg-white/40 backdrop-blur-md sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            
            <!-- Logo & Brand -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-pink-300 to-purple-300 flex items-center justify-center shadow-md shadow-pink-200/40 group-hover:scale-105 transition-transform">
                    @if(\App\Models\Setting::getVal('web_logo'))
                        <img src="{{ asset(\App\Models\Setting::getVal('web_logo')) }}" alt="Logo" class="w-7 h-7 object-contain rounded-md">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                    @endif
                </div>
                <span class="text-xl font-black font-outfit text-purple-950">{{ \App\Models\Setting::getVal('web_name', 'Photobox Studio') }}</span>
            </a>

            <!-- Navigation Links with Dropdowns -->
            <nav class="hidden md:flex items-center space-x-2">
                
                <!-- 1. Templates Dropdown -->
                <div class="relative nav-item-container py-4">
                    <button class="px-4 py-2 text-sm font-bold text-purple-900/80 hover:text-purple-950 flex items-center space-x-1.5 rounded-xl hover:bg-purple-50/50 transition-colors">
                        <span>Templates</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-purple-400">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="nav-dropdown">
                        <div class="px-3 py-2 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-purple-50/60 mb-1">Layout Presets</div>
                        <a href="{{ route('gallery.category', 'strip') }}" class="flex items-center space-x-2 px-3 py-2 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                            <span>Vertical Strip (4 Slots)</span>
                        </a>
                        <a href="{{ route('gallery.category', 'strip_3') }}" class="flex items-center space-x-2 px-3 py-2 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                            <span>3-Photo Strip (3 Slots)</span>
                        </a>
                        <a href="{{ route('gallery.category', 'grid') }}" class="flex items-center space-x-2 px-3 py-2 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                            <span>2x2 Grid (4 Slots)</span>
                        </a>
                        <a href="{{ route('gallery.category', 'grid_6') }}" class="flex items-center space-x-2 px-3 py-2 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                            <span>3x2 Grid (6 Slots)</span>
                        </a>
                        <a href="{{ route('studio.custom') }}" class="flex items-center space-x-2 px-3 py-2 text-sm font-semibold text-pink-600 rounded-lg hover:bg-pink-50 transition-colors">
                            <span>+ Custom Template</span>
                        </a>
                    </div>
                </div>

                <!-- 2. Master Data Dropdown (Admin & Superadmin Only) -->
                @if(in_array(Auth::user()->role, ['superadmin', 'admin']))
                    <div class="relative nav-item-container py-4">
                        <button class="px-4 py-2 text-sm font-bold text-purple-900/80 hover:text-purple-950 flex items-center space-x-1.5 rounded-xl hover:bg-purple-50/50 transition-colors">
                            <span>Master Data</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-purple-400">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="nav-dropdown">
                            <div class="px-3 py-2 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-purple-50/60 mb-1">Administrations</div>
                            <a href="{{ route('dashboard.users') }}" class="flex items-center space-x-2 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-purple-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 20.5a11.378 11.378 0 0 1-4.918-1.263v-.109c0-1.113.285-2.16.786-3.07M19.5 7.375a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM4 19.128v-.003c0-1.113.285-2.16.786-3.07M4 19.128v.109A11.386 11.386 0 0 1 10.089 20.5c-2.215 0-4.22-.63-5.918-1.723A4.125 4.125 0 0 0 2 18.25V18a2.25 2.25 0 0 1 2.25-2.25H6m4-3a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" />
                                </svg>
                                <span>Users Directory</span>
                            </a>
                            <a href="{{ route('dashboard.templates') }}" class="flex items-center space-x-2 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-purple-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                <span>Templates Listing</span>
                            </a>
                        </div>
                    </div>
                @endif

                <!-- 3. Settings Dropdown -->
                <div class="relative nav-item-container py-4">
                    <button class="px-4 py-2 text-sm font-bold text-purple-900/80 hover:text-purple-950 flex items-center space-x-1.5 rounded-xl hover:bg-purple-50/50 transition-colors">
                        <span>Settings</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-purple-400">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="nav-dropdown">
                        <div class="px-3 py-2 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-purple-50/60 mb-1">Configuration</div>
                        <a href="{{ route('dashboard.settings') }}" class="flex items-center space-x-2 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-purple-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.645-.869L9.594 3.94ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" />
                            </svg>
                            <span>System Settings</span>
                        </a>
                        <a href="{{ route('dashboard.backup') }}" class="flex items-center space-x-2 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-purple-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                            </svg>
                            <span>Backup Database</span>
                        </a>
                        <a href="{{ route('dashboard.logs') }}" class="flex items-center space-x-2 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-purple-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span>Activity Log</span>
                        </a>
                        <a href="{{ route('dashboard.trash') }}" class="flex items-center space-x-2 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-purple-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            <span>Tong Sampah</span>
                        </a>
                        @if(Auth::user()->role === 'superadmin')
                            <a href="{{ route('dashboard.permissions') }}" class="flex items-center space-x-2 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-purple-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-2.25 10.5h13.5c.621 0 1.125-.504 1.125-1.125v-7.25c0-.621-.504-1.125-1.125-1.125H3.75c-.621 0-1.125.504-1.125 1.125v7.25c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                <span>Hak Akses</span>
                            </a>
                        @endif
                    </div>
                </div>

            </nav>

            <!-- 4. Account Dropdown (Profile & Logout) -->
            <div class="flex items-center space-x-4">
                <div class="relative nav-item-container py-4">
                    <button class="flex items-center space-x-2 text-left focus:outline-none">
                        <div class="w-9 h-9 rounded-xl bg-purple-100 border border-purple-200 flex items-center justify-center font-bold text-purple-700 text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-xs font-black text-purple-950 leading-none">{{ Auth::user()->name }}</div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-purple-400">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="nav-dropdown right-0 left-auto">
                        <div class="px-3 py-2 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-purple-50/60 mb-1">User Account</div>
                        <a href="{{ route('dashboard.profile') }}" class="flex items-center space-x-2 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-lg hover:bg-purple-50 hover:text-purple-900 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-purple-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <span>Profile</span>
                        </a>
                        <div class="border-t border-purple-50/60 my-1"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center space-x-2 px-3 py-2.5 text-sm font-semibold text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-red-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 md:px-6 py-8">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-800 text-sm font-semibold flex items-center space-x-2 shadow-sm animate-bounce">
                <span>Success:</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold shadow-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-purple-100 bg-white/20 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-6 text-center text-xs text-purple-400/80 font-medium">
            &copy; 2026 {{ \App\Models\Setting::getVal('web_name', 'Photobox Studio') }}. All rights reserved.
        </div>
    </footer>
</body>
</html>
