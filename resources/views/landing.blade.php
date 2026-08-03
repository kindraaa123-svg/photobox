<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photobox Studio - Capture & Customize Memories</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS / Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #fffafc;
            background: radial-gradient(circle at 50% -20%, #fff0f3 0%, #f7f3ff 60%, #ffffff 100%);
            overflow-x: hidden;
            color: #5d486b;
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

        .glass-panel {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.65);
            border: 2px solid rgba(237, 222, 247, 0.7);
            box-shadow: 0 15px 30px rgba(237, 222, 247, 0.3);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #ffb7b2 0%, #ffc6ff 100%);
            color: #5d4b68;
            box-shadow: 0 8px 20px rgba(255, 183, 178, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-gradient:hover {
            box-shadow: 0 10px 25px rgba(255, 183, 178, 0.45);
            transform: translateY(-2px) scale(1.02);
        }

        .ambient-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            opacity: 0.4;
            z-index: 1;
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(1deg); }
        }

        .shimmer {
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.6) 50%, rgba(255,255,255,0) 100%);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body id="home" class="antialiased selection:bg-pink-200 selection:text-pink-800">

    <!-- Ambient background glows -->
    <div class="ambient-glow w-[400px] h-[400px] bg-pink-100 top-[-80px] left-[15%]"></div>
    <div class="ambient-glow w-[500px] h-[500px] bg-purple-100 top-[350px] right-[8%]"></div>
    <div class="ambient-glow w-[350px] h-[350px] bg-emerald-100 bottom-[150px] left-[-5%]"></div>

    <!-- Navigation Header -->
    <header class="border-b border-purple-100 bg-white/40 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-pink-300 to-purple-300 flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </div>
                <span class="text-xl font-bold font-outfit text-purple-950">Photobox Studio</span>
            </div>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-purple-700/80">
                <a href="#home" class="hover:text-purple-950 transition-colors">Home</a>
                <a href="#about" class="hover:text-purple-950 transition-colors">About</a>
                <a href="#features" class="hover:text-purple-950 transition-colors">Features</a>
                <a href="#workflow" class="hover:text-purple-950 transition-colors">Workflow</a>
                <a href="#templates" class="hover:text-purple-950 transition-colors">Templates</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-sm font-bold text-purple-700 hover:text-purple-950 transition-colors px-4 py-2">
                    Sign In
                </a>
                <a href="{{ route('workspace') }}" class="btn-gradient px-5 py-2.5 rounded-2xl text-xs font-black shadow-md flex items-center space-x-1.5">
                    <span>Open Studio</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 pt-16 pb-20 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
        
        <div class="lg:col-span-6 space-y-8 text-center lg:text-left">
            <h1 class="text-4xl sm:text-6xl font-black font-outfit tracking-tight leading-none text-purple-950">
                Cute Photobooth<br>
                <span class="bg-gradient-to-r from-pink-400 via-purple-400 to-pink-500 bg-clip-text text-transparent">Directly in Your Browser</span>
            </h1>

            <p class="text-base sm:text-lg text-purple-700/80 max-w-xl mx-auto lg:mx-0 font-medium">
                Create sweet classic photostrips, 2x2 grids, or solo Polaroids. Personalize with pastel colors, custom frame designs, and sweet retro filters. Download and print instantly!
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                <a href="{{ route('workspace') }}" class="btn-gradient w-full sm:w-auto px-8 py-4 rounded-[2rem] text-sm font-black shadow-xl flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    </svg>
                    <span>Launch Studio (No Login Needed)</span>
                </a>
                
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 rounded-[2rem] bg-white hover:bg-purple-50/50 border-2 border-purple-100 hover:border-purple-200 text-sm font-black text-purple-700 transition-all flex items-center justify-center">
                    <span>Create Profile</span>
                </a>
            </div>

            <!-- Stats -->
            <div class="pt-6 grid grid-cols-3 gap-6 max-w-md mx-auto lg:mx-0 text-center lg:text-left border-t border-purple-100">
                <div>
                    <div class="text-2xl font-black font-outfit text-purple-900">100%</div>
                    <div class="text-xs text-purple-400 font-bold uppercase">No Install</div>
                </div>
                <div>
                    <div class="text-2xl font-black font-outfit text-purple-900">Sweet</div>
                    <div class="text-xs text-purple-400 font-bold uppercase">Pastel Palettes</div>
                </div>
                <div>
                    <div class="text-2xl font-black font-outfit text-purple-900">Free</div>
                    <div class="text-xs text-purple-400 font-bold uppercase">Local Downloads</div>
                </div>
            </div>
        </div>

        <!-- Hero Mockup Display -->
        <div class="lg:col-span-6 flex justify-center relative">
            
            <div class="absolute inset-0 bg-gradient-to-tr from-pink-300/10 to-purple-300/10 rounded-3xl filter blur-3xl pointer-events-none"></div>

            <div class="relative w-full max-w-md aspect-[3/4] glass-panel rounded-[2.5rem] p-4 md:p-6 shadow-2xl float-animation">
                <!-- Mockup App Header -->
                <div class="flex justify-between items-center pb-4 border-b border-purple-100 text-[10px] text-purple-400 font-bold">
                    <div class="flex items-center space-x-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-300"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-300"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-300"></span>
                    </div>
                    <span>STUDIO SANDBOX</span>
                    <span class="px-2 py-0.5 rounded bg-pink-100 text-pink-700 text-[8px]">GUEST MODE</span>
                </div>

                <!-- Mockup App Workspace Layout -->
                <div class="grid grid-cols-12 gap-4 pt-4 h-[calc(100%-2rem)]">
                    <!-- Controls Mock -->
                    <div class="col-span-4 space-y-3">
                        <div class="h-8 rounded bg-white shimmer"></div>
                        <div class="h-20 rounded bg-white shimmer"></div>
                        <div class="h-10 rounded bg-pink-200/50 border-2 border-pink-300"></div>
                        <div class="h-14 rounded bg-white shimmer"></div>
                    </div>

                    <!-- Canvas Mock (Vertical strip) -->
                    <div class="col-span-8 flex justify-center bg-purple-50/50 rounded-2xl p-4 border-2 border-purple-100">
                        <div class="w-24 h-[92%] bg-white rounded-lg shadow-md p-2 space-y-2 flex flex-col justify-between border-2 border-pink-100">
                            <div class="h-[18%] bg-pink-50 rounded-md relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-tr from-pink-200 to-purple-200 opacity-50"></div>
                            </div>
                            <div class="h-[18%] bg-pink-50 rounded-md relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-tr from-yellow-100 to-pink-200 opacity-50"></div>
                            </div>
                            <div class="h-[18%] bg-pink-50 rounded-md relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-tr from-purple-100 to-blue-100 opacity-50"></div>
                            </div>
                            <div class="h-[18%] bg-pink-50 rounded-md relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-tr from-pink-100 to-yellow-100 opacity-50"></div>
                            </div>
                            <div class="h-3 rounded-sm flex items-center justify-center">
                                <span class="text-[5px] font-black text-pink-300 tracking-wider">PHOTOBOX</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </section>

    <!-- About Section -->
    <section id="about" class="max-w-7xl mx-auto px-6 py-20 relative z-10 border-t border-purple-100 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center bg-purple-50/10 rounded-[2rem]">
        <div class="space-y-6">
            <h2 class="text-xs font-bold uppercase tracking-wider text-pink-500">Our Story</h2>
            <h3 class="text-3xl sm:text-4xl font-extrabold font-outfit text-purple-950 leading-tight">Preserving Happy Moments, Instantly</h3>
            <p class="text-sm text-purple-700/80 leading-relaxed font-medium">
                Photobox Studio started with a simple idea: bringing the nostalgic joy of physical photo booths right to your browser screen. We believe that capturing silly smiles, candid laughs, and precious memories should be simple and open to everyone.
            </p>
            <p class="text-sm text-purple-700/80 leading-relaxed font-medium">
                Designed with a soft pastel aesthetic, our application runs entirely in your local browser sandbox. No photo data is uploaded or processed on external servers unless you choose to sync them to your online account gallery.
            </p>
        </div>
        <div class="glass-panel p-8 rounded-[2.5rem] bg-gradient-to-br from-pink-100/30 to-purple-100/30 border border-purple-200 shadow-lg text-center space-y-4">
            <div class="inline-flex w-16 h-16 rounded-full bg-pink-100 items-center justify-center text-pink-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
            </div>
            <h4 class="text-lg font-bold text-purple-950">100% Free & Open</h4>
            <p class="text-xs text-purple-700/80 max-w-sm mx-auto leading-relaxed">
                Our studio booth is open to everyone. Feel free to snap as many photos as you want, style them with preset filters, and download print-ready files directly to your device!
            </p>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="max-w-7xl mx-auto px-6 py-20 relative z-10 border-t border-purple-100">
        
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <h2 class="text-xs font-bold uppercase tracking-wider text-pink-500">Sweet Features</h2>
            <p class="text-3xl sm:text-4xl font-extrabold font-outfit text-purple-950 leading-tight">Everything You Need for Happy Captures</p>
            <p class="text-sm text-purple-700/70">No software download needed! All capabilities run locally and immediately inside your browser.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Feature 1 -->
            <div class="glass-panel p-6 rounded-3xl space-y-4 hover:border-pink-300 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-pink-100 flex items-center justify-center text-pink-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 9.152c.582.448 1.148.89 1.676 1.345m-1.676-1.345c-.528-.456-1.094-.897-1.676-1.345m1.676 1.345 3.535 3.536m-3.535-3.536L9.503 14.8c-.4.4-.62 1.93-.314 2.236.305.306 1.835.086 2.235-.314l5.618-5.618Zm-5.618 5.618-3.536-3.536M6.5 21h11A2.5 2.5 0 0 0 20 18.5v-11A2.5 2.5 0 0 0 17.5 5h-11A2.5 2.5 0 0 0 4 7.5v11A2.5 2.5 0 0 0 6.5 21Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold font-outfit text-purple-950">Drag & Zoom Canvas</h3>
                <p class="text-xs text-purple-800 leading-relaxed">
                    Easily reposition and crop photos inside each frame slot. Scroll to zoom in/out and drag to align your sweet face perfectly.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="glass-panel p-6 rounded-3xl space-y-4 hover:border-pink-300 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold font-outfit text-purple-950">Chime Auto-Capture</h3>
                <p class="text-xs text-purple-800 leading-relaxed">
                    Start a photo-capturing session with bubbly sound beeps, a bouncing countdown timer, and a camera flash capture effect.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="glass-panel p-6 rounded-3xl space-y-4 hover:border-pink-300 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-1.897 2.25 2.25 0 0 1 2.4-2.244 3 3 0 0 0 5.78-1.128 2.25 2.25 0 0 1 2.4-2.245 4.5 4.5 0 0 0-8.4 1.897 2.25 2.25 0 0 1-2.4 2.244Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.91 9v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201V9M21 9H3" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold font-outfit text-purple-950">Custom PNG Overlays</h3>
                <p class="text-xs text-purple-800 leading-relaxed">
                    Design custom photostrips by uploading transparent overlay files. Customize frame background color pickers to match any custom theme.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="glass-panel p-6 rounded-3xl space-y-4 hover:border-pink-300 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold font-outfit text-purple-950">Cute Photo Filters</h3>
                <p class="text-xs text-purple-800 leading-relaxed">
                    Toggle between vintage grayscale, soft warm sepia, neon contrast, or bright chrome adjustments to give photos a beautiful color tone.
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="glass-panel p-6 rounded-3xl space-y-4 hover:border-pink-300 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold font-outfit text-purple-950">Print-Quality Downloads</h3>
                <p class="text-xs text-purple-800 leading-relaxed">
                    Download strips compiled at 2x resolution coordinates, perfect for printing at events or sharing high-quality files on social platforms.
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="glass-panel p-6 rounded-3xl space-y-4 hover:border-pink-300 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold font-outfit text-purple-950">Online History Vault</h3>
                <p class="text-xs text-purple-800 leading-relaxed">
                    Create an account to automatically sync all your jepretan to your private online history gallery! Never lose a memory.
                </p>
            </div>

        </div>

    </section>

    <!-- Workflow Section -->
    <section id="workflow" class="max-w-7xl mx-auto px-6 py-20 relative z-10 border-t border-purple-100 bg-purple-50/20">
        
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <h2 class="text-xs font-bold uppercase tracking-wider text-pink-500">Super Easy</h2>
            <p class="text-3xl sm:text-4xl font-extrabold font-outfit text-purple-950">How It Works</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            
            <!-- Connection lines for large screens -->
            <div class="hidden md:block absolute top-1/3 left-[20%] right-[20%] h-0.5 border-t-2 border-dashed border-purple-200 z-0"></div>

            <!-- Step 1 -->
            <div class="relative z-10 text-center space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-white border-2 border-pink-200 mx-auto flex items-center justify-center text-lg font-black font-outfit text-pink-500">
                    1
                </div>
                <h4 class="text-lg font-bold text-purple-950">Pick & Style Layout</h4>
                <p class="text-xs text-purple-700/80 max-w-xs mx-auto leading-relaxed">
                    Choose a vertical strip, 2x2 grid, or solo Polaroid. Adjust background pastel colors or gradient borders.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="relative z-10 text-center space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-white border-2 border-purple-200 mx-auto flex items-center justify-center text-lg font-black font-outfit text-purple-500">
                    2
                </div>
                <h4 class="text-lg font-bold text-purple-950">Cheese! Capture Photo</h4>
                <p class="text-xs text-purple-700/80 max-w-xs mx-auto leading-relaxed">
                    Smile for the camera as it counts down, or upload images directly to fit the target frame placeholder slots.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="relative z-10 text-center space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-white border-2 border-yellow-200 mx-auto flex items-center justify-center text-lg font-black font-outfit text-yellow-600">
                    3
                </div>
                <h4 class="text-lg font-bold text-purple-950">Adjust & Download</h4>
                <p class="text-xs text-purple-700/80 max-w-xs mx-auto leading-relaxed">
                    Drag and scale images to align them in slots, select photo effects, and download the print-ready image.
                </p>
            </div>

        </div>

    </section>

    <!-- Templates Section -->
    <section id="templates" class="max-w-7xl mx-auto px-6 py-20 relative z-10 border-t border-purple-100">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <h2 class="text-xs font-bold uppercase tracking-wider text-pink-500">Preset Frame Templates</h2>
            <p class="text-3xl sm:text-4xl font-extrabold font-outfit text-purple-950">Choose Your Vibe</p>
            <p class="text-sm text-purple-700/70">Pick a ready-made template and go straight to the camera session!</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($frames as $frame)
                <div class="glass-panel p-6 rounded-3xl text-center space-y-4 hover:border-pink-300 transition-all flex flex-col justify-between bg-white/70">
                    <div class="space-y-2">
                        @if($frame->layout_type === 'strip')
                            <div class="mx-auto w-24 h-48 border border-purple-200/30 rounded-xl p-2.5 flex flex-col justify-between shadow-md transition-shadow" style="background-color: {{ $frame->bg_color }};">
                                @for($i = 0; $i < count($frame->slots); $i++)
                                    <div class="bg-white/60 w-full h-10 rounded-lg border border-purple-200/40"></div>
                                @endfor
                            </div>
                        @elseif($frame->layout_type === 'grid')
                            <div class="mx-auto w-32 h-36 border border-purple-200/30 rounded-xl p-2.5 grid grid-cols-2 gap-1.5 shadow-md transition-shadow" style="background-color: {{ $frame->bg_color }};">
                                @for($i = 0; $i < count($frame->slots); $i++)
                                    <div class="bg-white/60 w-full @if(count($frame->slots) === 6) h-8 @else h-12 @endif rounded-lg border border-purple-200/40 col-span-1"></div>
                                @endfor
                            </div>
                        @else
                            <div class="mx-auto w-36 h-40 border border-purple-200/30 rounded-xl p-2.5 flex flex-col justify-between shadow-md transition-shadow" style="background-color: {{ $frame->bg_color }};">
                                <div class="bg-white/60 w-full h-24 rounded-lg border border-purple-200/40"></div>
                                <div class="h-6 mt-1 flex items-center justify-center">
                                    <span class="text-[7px] text-purple-700/60 font-bold uppercase tracking-wider">• {{ $frame->name }} •</span>
                                </div>
                            </div>
                        @endif

                        <h4 class="text-md font-extrabold text-purple-950 mt-4">{{ $frame->name }}</h4>
                        <p class="text-[11px] text-purple-700/80 leading-relaxed font-semibold">
                            Layout: <span class="capitalize font-bold">{{ $frame->layout_type }}</span>
                        </p>
                    </div>
                    <a href="#" onclick="openSourceModal(event, {{ $frame->id }})" class="mt-4 px-4 py-2.5 bg-pink-100 hover:bg-pink-200 text-[11px] text-pink-700 font-extrabold rounded-2xl transition-all block">
                        Use Template
                    </a>
                </div>
            @empty
                <div class="col-span-4 text-center text-xs text-purple-400">
                    No preset templates seeded in the database.
                </div>
            @endforelse
        </div>
    </section>



    <!-- Footer -->
    <footer class="border-t border-purple-100 bg-purple-50/30 py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-pink-300 to-purple-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        </svg>
                    </div>
                    <span class="text-md font-bold font-outfit text-purple-950">Photobox Studio</span>
                </div>
                <p class="text-xs text-purple-600/70 leading-relaxed max-w-xs">
                    A sweet browser-based photobooth app to capture happiness, style strips with colors, and customize frames.
                </p>
            </div>

            <div class="space-y-3">
                <h5 class="text-xs font-bold uppercase tracking-wider text-pink-500">App Services</h5>
                <ul class="space-y-2 text-xs text-purple-700/80">
                    <li><a href="{{ route('workspace') }}" class="hover:text-purple-950 transition-colors">Photostrip Studio</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-purple-950 transition-colors">User Account Registry</a></li>
                    <li><a href="{{ route('workspace') }}?layout=grid" class="hover:text-purple-950 transition-colors">Grid Collages</a></li>
                </ul>
            </div>

            <div class="space-y-3">
                <h5 class="text-xs font-bold uppercase tracking-wider text-pink-500">Support</h5>
                <ul class="space-y-2 text-xs text-purple-700/80">
                    <li><a href="#features" class="hover:text-purple-950 transition-colors">App Features</a></li>
                    <li><a href="#workflow" class="hover:text-purple-950 transition-colors">Workflow Guide</a></li>
                </ul>
            </div>

            <div class="space-y-4">
                <h5 class="text-xs font-bold uppercase tracking-wider text-pink-500">Newsletter</h5>
                <div class="flex space-x-2">
                    <input type="email" placeholder="you@example.com" class="bg-white border border-purple-100 rounded-xl px-3 py-2 text-xs text-purple-950 focus:outline-none focus:border-pink-300 w-full">
                    <button class="btn-gradient px-4 py-2 rounded-xl text-xs font-bold shadow-md">Join</button>
                </div>
                <span class="text-[10px] text-purple-400 block leading-tight">Join our newsletter to receive happy updates.</span>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-6 mt-8 pt-8 border-t border-purple-100 text-center text-xs text-purple-400 flex flex-col md:flex-row justify-between items-center gap-4">
            <span>© 2026 Photobox Studio Inc. All rights reserved.</span>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-purple-700 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-purple-700 transition-colors">Terms of Service</a>
            </div>
        </div>
    </footer>

    <!-- Modal: Choose Photo Source -->
    <div id="sourceModal" class="fixed inset-0 z-50 flex items-center justify-center bg-purple-950/20 backdrop-blur-md hidden p-4">
        <div class="bg-white/95 border-2 border-purple-100 w-full max-w-sm rounded-[2.5rem] p-8 text-center space-y-6 shadow-2xl text-slate-700 relative">
            <button onclick="closeSourceModal()" class="absolute top-4 right-4 text-purple-400 hover:text-purple-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="space-y-2">
                <div class="inline-flex w-16 h-16 rounded-full bg-pink-100 items-center justify-center text-pink-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-black font-outfit text-purple-950">Add Photos to Frame</h3>
                <p class="text-xs text-purple-600 font-semibold">Choose how you want to add photos to this template.</p>
            </div>

            <div class="flex flex-col gap-3">
                <!-- Option 1: Ambil Foto -->
                <button onclick="navigateWithAction('capture')" class="w-full py-4 bg-pink-400 hover:bg-pink-500 text-white rounded-2xl font-black text-sm shadow-md transition-all flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                    <span>Ambil Foto (Camera)</span>
                </button>

                <!-- Option 2: Pilih File -->
                <button onclick="navigateWithAction('upload')" class="w-full py-4 bg-white border-2 border-purple-200 hover:border-purple-300 text-purple-700 rounded-2xl font-black text-sm transition-all flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
                    </svg>
                    <span>Pilih File (Upload)</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        let selectedFrameId = null;

        function openSourceModal(event, frameId) {
            event.preventDefault();
            selectedFrameId = frameId;
            document.getElementById('sourceModal').classList.remove('hidden');
        }

        function closeSourceModal() {
            document.getElementById('sourceModal').classList.add('hidden');
        }

        function navigateWithAction(action) {
            if (selectedFrameId) {
                window.location.href = `{{ route('workspace') }}?frame_id=${selectedFrameId}&action=${action}`;
            }
        }
    </script>

</body>
</html>
