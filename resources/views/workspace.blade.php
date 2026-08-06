<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::getVal('web_name', 'Photobox Studio') }} - Workspace</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS / Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if(request('action') === 'capture')
    <style id="foucPreventer">
        #appHeader, #appMain {
            display: none !important;
        }
    </style>
    @endif

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #fffafc;
            background: radial-gradient(circle at 50% 50%, #fff0f3 0%, #f6effc 100%);
            min-height: 100vh;
            color: #5d4b68;
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

        .glass-panel {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.65);
            border: 2px solid rgba(237, 222, 247, 0.7);
            box-shadow: 0 10px 25px rgba(237, 222, 247, 0.25);
        }

        .glass-panel-hover:hover {
            border-color: rgba(255, 183, 178, 0.4);
            background: rgba(255, 255, 255, 0.85);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #ffb7b2 0%, #ffc6ff 100%);
            color: #5d4b68;
            box-shadow: 0 6px 15px rgba(255, 183, 178, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-weight: bold;
        }
        .btn-gradient:hover {
            box-shadow: 0 8px 20px rgba(255, 183, 178, 0.45);
            transform: translateY(-1px);
        }

        .canvas-container {
            max-height: 62vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            width: 100%;
        }
        #photoboxCanvas {
            max-height: 60vh;
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 12px 30px rgba(93, 75, 104, 0.15));
            border-radius: 4px;
        }

        /* Customize scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.02);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(93, 75, 104, 0.1);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(93, 75, 104, 0.2);
        }

        .toast-notification {
            animation: slideIn 0.3s ease forwards;
        }
        @keyframes slideIn {
            from { transform: translateY(100px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .active-filter {
            border-color: #ffb7b2 !important;
            background: rgba(255, 183, 178, 0.25) !important;
            color: #5d4b68 !important;
        }
    </style>
</head>
<body class="text-slate-700 flex flex-col min-height-screen">

    <!-- Header Navigation -->
    <header id="appHeader" class="border-b border-purple-100 bg-white/40 backdrop-blur-md sticky top-0 z-30 @if(request('action') === 'capture') hidden @endif">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-pink-300 to-purple-300 flex items-center justify-center shadow-md overflow-hidden">
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
            </div>
            
            <div class="flex items-center space-x-6">
                @auth
                    <div class="hidden sm:flex flex-col text-right items-end justify-center">
                        <span class="text-sm font-bold text-purple-950">{{ Auth::user()->name }}</span>
                    </div>
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-100 transition-all">
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl border border-purple-100 text-purple-700 hover:bg-purple-50/50 transition-all">
                            Sign Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-bold rounded-xl border border-purple-200 text-purple-700 bg-white hover:bg-purple-50 transition-all">
                        Sign In / Register
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Workspace -->
    <main id="appMain" class="flex-1 max-w-7xl w-full mx-auto px-4 md:px-6 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6 overflow-hidden @if(request('action') === 'capture') hidden @endif">
        
        <!-- Left Sidebar: Controls & Options -->
        <section id="leftSidebar" class="{{ request('action') === 'custom' ? 'lg:col-span-3' : 'lg:col-span-4' }} flex flex-col space-y-6 overflow-y-auto max-h-[calc(100vh-7rem)] pr-2">
            
            @if(request('action') === 'custom')
                <!-- Custom Canvas / Frame Creator Panel -->
                <form id="customFrameForm" onsubmit="submitCustomFrame(event)" class="space-y-4">
                    @csrf
                    
                    <!-- Card 1: Frame Name -->
                    <div class="glass-panel rounded-2xl p-5 space-y-3">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-purple-700">1. Frame Name</h2>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Template Name</label>
                            <input type="text" name="name" required class="w-full bg-white border-2 border-purple-100 rounded-xl px-3 py-2 text-xs text-purple-950 focus:outline-none focus:border-pink-300 shadow-sm" placeholder="My Birthday Frame">
                        </div>
                    </div>

                    <!-- Card 2: Frame Layout -->
                    <div class="glass-panel rounded-2xl p-5 space-y-3">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-purple-700">2. Frame Layout</h2>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Layout Template</label>
                            <select name="layout_type" onchange="previewCustomLayout(this.value)" class="w-full bg-white border-2 border-purple-100 rounded-xl px-3 py-2 text-xs text-purple-950 focus:outline-none focus:border-pink-300 shadow-sm">
                                <option value="strip">Vertical Strip (4 slots)</option>
                                <option value="strip_3">3-Photo Strip (3 slots)</option>
                                <option value="grid">2x2 Grid (4 slots)</option>
                                <option value="grid_6">3x2 Grid (6 slots)</option>
                                <option value="single">Solo Landscape (1 slot)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Card 3: Frame Styling -->
                    <div class="glass-panel rounded-2xl p-5 space-y-3">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-purple-700">3. Frame Styling</h2>
                        
                        <!-- Background Color -->
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Background Color</label>
                            <div class="flex items-center space-x-2">
                                <input type="color" name="bg_color" value="#ffffff" onchange="previewCustomBg(this.value)" class="w-8 h-8 rounded-lg cursor-pointer bg-transparent border-0">
                                <input type="text" id="customBgColorHex" onchange="previewCustomBg(this.value)" class="flex-1 bg-white border-2 border-purple-100 rounded-xl px-3 py-1.5 text-xs text-purple-950 uppercase focus:outline-none focus:border-purple-300" placeholder="#FFFFFF" value="#FFFFFF">
                            </div>
                        </div>

                        <!-- Slot Shape -->
                        <div class="space-y-2 pt-2 border-t border-purple-100">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Slot Shape</label>
                            <select name="slot_shape" id="slotShapeSelector" onchange="updateSlotShape(this.value)" class="w-full bg-white border-2 border-purple-100 rounded-xl px-3 py-2 text-xs text-purple-950 focus:outline-none focus:border-pink-300 shadow-sm">
                                <option value="rect">Rectangle / Kotak</option>
                                <option value="circle">Circle / Bulat</option>
                                <option value="heart">Heart / Hati</option>
                                <option value="star">Star / Bintang</option>
                            </select>
                        </div>

                        <!-- Overlay PNG (Optional) -->
                        <div class="space-y-2 pt-2 border-t border-purple-100">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Overlay PNG (Optional)</label>
                            <input type="file" name="overlay_image" accept="image/png,image/svg+xml" onchange="previewCustomOverlay(this)" class="w-full text-[10px] text-purple-600 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer">
                        </div>

                        <!-- Hidden slots JSON input -->
                        <input type="hidden" name="slots" id="slotsJsonInput">

                        <button type="submit" class="w-full py-3 bg-gradient-to-tr from-pink-400 to-purple-400 text-white font-black text-xs rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all mt-3">
                            Save Layout / Template
                        </button>
                    </div>
                </form>
            @else
            <!-- Capture / Upload Options -->
            <div class="glass-panel rounded-2xl p-5 space-y-4">
                <h2 class="text-xs font-bold uppercase tracking-wider text-purple-700">1. Fill Photo Slots</h2>
                
                <div class="grid grid-cols-2 gap-2 text-xs">
                    @if(request('action') !== 'upload')
                        <button onclick="startAutoCapture()" class="col-span-2 py-3 rounded-xl font-bold text-center text-white bg-pink-400 hover:bg-pink-500 shadow-md flex items-center justify-center space-x-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                            <span>Start Auto-Capture</span>
                        </button>

                        <button onclick="openWebcam()" class="py-2.5 rounded-xl border border-purple-100 bg-white hover:bg-purple-50/50 font-bold text-center text-purple-700 transition-colors">
                            Camera Feed
                        </button>
                    @endif
                    
                    <label class="{{ request('action') === 'upload' ? 'col-span-2' : '' }} py-2.5 rounded-xl border border-purple-100 bg-white hover:bg-purple-50/50 font-bold text-center text-purple-700 cursor-pointer block text-center transition-colors">
                        Upload Files
                        <input type="file" id="bulkFileInput" multiple accept="image/*" class="hidden" onchange="uploadBulkImages(event)">
                    </label>
                </div>

                <div class="border-t border-purple-100 pt-3">
                    <div class="text-xs text-purple-700 font-bold mb-2">Slot Manager (Select to upload)</div>
                    <div class="grid grid-cols-4 gap-2" id="slotSelector">
                        <!-- Filled by layout selection dynamically -->
                    </div>
                </div>
            </div>

            <!-- Filters Panel -->
            <div class="glass-panel rounded-2xl p-5 space-y-4">
                <h2 class="text-xs font-bold uppercase tracking-wider text-purple-700">2. Effects Filter</h2>
                <div class="grid grid-cols-3 gap-1.5 text-center text-[10px]">
                    <button onclick="applyImageFilter('normal')" class="filter-btn p-2 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-purple-950 active-filter font-semibold">Normal</button>
                    <button onclick="applyImageFilter('grayscale')" class="filter-btn p-2 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-purple-900 font-semibold">Mono</button>
                    <button onclick="applyImageFilter('sepia')" class="filter-btn p-2 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-amber-800 font-semibold">Retro</button>
                    <button onclick="applyImageFilter('chrome')" class="filter-btn p-2 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-blue-900 font-semibold">Chrome</button>
                    <button onclick="applyImageFilter('neon')" class="filter-btn p-2 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-pink-700 font-semibold">Neon</button>
                    <button onclick="applyImageFilter('vintage')" class="filter-btn p-2 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-amber-900 font-semibold">Vintage</button>
                </div>
            </div>
            @endif

        </section>

        <!-- Center Main Workspace: Live Canvas Sandbox -->
        <section id="centerSandbox" class="{{ request('action') === 'custom' ? 'lg:col-span-6' : 'lg:col-span-8' }} flex flex-col justify-between items-center max-h-[calc(100vh-7rem)] relative">
            
            <!-- Canvas container -->
            <div class="flex-1 flex items-center justify-center w-full min-h-[250px] md:min-h-[420px]">
                <div class="relative canvas-container max-w-[480px] w-full flex items-center justify-center" id="canvasWrapper">
                    <canvas id="photoboxCanvas" class="cursor-grab active:cursor-grabbing block"></canvas>
                </div>
            </div>

            <!-- Edit Instruction Overlay -->
            <div class="text-center mt-4 mb-2">
                <p class="text-xs text-purple-700/80 font-semibold flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-purple-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 9.152c.582.448 1.148.89 1.676 1.345m-1.676-1.345c-.528-.456-1.094-.897-1.676-1.345m1.676 1.345 3.535 3.536m-3.535-3.536L9.503 14.8c-.4.4-.62 1.93-.314 2.236.305.306 1.835.086 2.235-.314l5.618-5.618Zm-5.618 5.618-3.536-3.536M6.5 21h11A2.5 2.5 0 0 0 20 18.5v-11A2.5 2.5 0 0 0 17.5 5h-11A2.5 2.5 0 0 0 4 7.5v11A2.5 2.5 0 0 0 6.5 21Z" />
                    </svg>
                    <span>Scroll to Zoom image inside slot. Drag to Pan.</span>
                </p>
            </div>

            <!-- Save / Download Actions -->
            <div id="editorActions" class="w-full flex space-x-3 mt-2">
                <button onclick="resetCanvas()" class="px-5 py-3.5 rounded-2xl border border-purple-200 bg-white hover:bg-purple-50 font-bold text-sm transition-colors text-purple-700">
                    Clear Layout
                </button>
                <button onclick="saveAndCompileCreation()" class="flex-1 py-3.5 rounded-2xl font-bold text-sm text-white btn-gradient shadow-lg flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                    </svg>
                    <span>Save & Download Creation</span>
                </button>
            </div>

            <!-- Results Mode Actions -->
            <div id="resultsActions" class="w-full flex flex-col sm:flex-row gap-3 mt-2 hidden max-w-sm">
                <button onclick="downloadResult()" class="flex-1 py-4 rounded-2xl font-black text-sm text-white btn-gradient shadow-lg flex items-center justify-center space-x-2 transition-transform active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Download Photo</span>
                </button>
                
                <button onclick="retakeSession()" class="flex-1 py-4 bg-white border-2 border-purple-200 hover:border-purple-300 text-purple-700 rounded-2xl font-black text-sm transition-all flex items-center justify-center space-x-2 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Ambil Foto Lagi</span>
                </button>
            </div>

            <!-- Focused Booth Mode Toolbar -->
            <div id="boothToolbar" class="w-full mt-6 p-5 glass-panel rounded-[2rem] space-y-4 hidden">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <!-- Slot Manager -->
                    <div class="w-full sm:w-auto">
                        <div class="text-[10px] text-purple-700 font-bold uppercase tracking-wider mb-2 text-center sm:text-left">Select Slot to Edit</div>
                        <div class="grid grid-cols-4 gap-2" id="boothSlotSelector">
                            <!-- Populated dynamically -->
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="flex space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                        <button onclick="chooseAmbilFoto()" class="px-4 py-2.5 bg-pink-400 hover:bg-pink-500 text-white rounded-xl text-xs font-bold shadow-md flex items-center space-x-1.5 transition-colors">
                            <span>Ambil Foto</span>
                        </button>
                        <button onclick="choosePilihFile()" class="px-4 py-2.5 bg-white border border-purple-200 text-purple-700 rounded-xl text-xs font-bold hover:bg-purple-50 flex items-center space-x-1.5 transition-colors">
                            <span>Pilih File</span>
                        </button>
                    </div>
                </div>

                <!-- Inline Filters -->
                <div class="border-t border-purple-100 pt-3">
                    <div class="text-[10px] text-purple-700 font-bold uppercase tracking-wider mb-2">Apply Effect Filter</div>
                    <div class="grid grid-cols-6 gap-1 text-center text-[10px]">
                        <button onclick="applyImageFilter('normal')" class="filter-btn p-1.5 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-purple-950 active-filter font-semibold">Normal</button>
                        <button onclick="applyImageFilter('grayscale')" class="filter-btn p-1.5 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-purple-900 font-semibold font-semibold">Mono</button>
                        <button onclick="applyImageFilter('sepia')" class="filter-btn p-1.5 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-amber-800 font-semibold font-semibold font-semibold">Retro</button>
                        <button onclick="applyImageFilter('chrome')" class="filter-btn p-1.5 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-blue-900 font-semibold font-semibold font-semibold">Chrome</button>
                        <button onclick="applyImageFilter('neon')" class="filter-btn p-1.5 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-pink-700 font-semibold font-semibold">Neon</button>
                        <button onclick="applyImageFilter('vintage')" class="filter-btn p-1.5 rounded-lg border border-purple-100/50 glass-panel glass-panel-hover text-amber-900 font-semibold font-semibold">Vintage</button>
                    </div>
                </div>
            </div>

        </section>

        @if(request('action') === 'custom')
        <!-- Right Sidebar: Graphics Elements Library (For Custom Creator Mode Only) -->
        <section id="rightSidebar" class="lg:col-span-3 flex flex-col space-y-6 overflow-y-auto max-h-[calc(100vh-7rem)] pl-2">
            
            <div class="glass-panel rounded-2xl p-5 space-y-4 bg-white/85">
                <div class="space-y-1">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-purple-700">Graphics Elements</h2>
                    <p class="text-[10px] text-purple-400 font-medium">Click to add graphics on your canvas. Drag to move them around.</p>
                </div>
                
                <div class="grid grid-cols-2 gap-3" id="elementsGrid">
                    <!-- Fish Element -->
                    <button type="button" onclick="addGraphicElement('fish')" class="p-3 rounded-xl border border-purple-100 bg-white hover:bg-purple-50 hover:border-pink-300 transition-all flex flex-col items-center text-center space-y-2 group shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-10 h-10">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 11v1c0 1.66 1.34 3 3 3v2.93zm5.9-3.41c-.13-.3-.39-.52-.71-.62L16 13.5v-1c0-1.66-1.34-3-3-3H9.5L7.5 7.5h6.21c.56 0 1.08.34 1.3.85l1.64 3.73c.18.42.54.73.98.83l.89.2c-.37 1.06-.99 2.01-1.78 2.76l-.84-.33z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600">Fish Graphic</span>
                    </button>

                    <!-- Wave Element -->
                    <button type="button" onclick="addGraphicElement('wave')" class="p-3 rounded-xl border border-purple-100 bg-white hover:bg-purple-50 hover:border-pink-300 transition-all flex flex-col items-center text-center space-y-2 group shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12c3-4 6 4 9 0s6-4 9 0" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600">Wave Graphic</span>
                    </button>

                    <!-- Heart Element -->
                    <button type="button" onclick="addGraphicElement('heart')" class="p-3 rounded-xl border border-purple-100 bg-white hover:bg-purple-50 hover:border-pink-300 transition-all flex flex-col items-center text-center space-y-2 group shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center text-pink-400 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-10 h-10">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600">Heart Graphic</span>
                    </button>

                    <!-- Tree Element -->
                    <button type="button" onclick="addGraphicElement('tree')" class="p-3 rounded-xl border border-purple-100 bg-white hover:bg-purple-50 hover:border-pink-300 transition-all flex flex-col items-center text-center space-y-2 group shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-10 h-10">
                                <path d="M11 21h2v-4h-2v4zm8-10h-2.17c-.41-1.16-1.52-2-2.83-2s-2.42.84-2.83 2H9c-1.66 0-3 1.34-3 3v2h16v-2c0-1.66-1.34-3-3-3zm-6-8c-2.76 0-5 2.24-5 5 0 2.05 1.23 3.81 3 4.58V11c0-1.1.9-2 2-2s2 .9 2 2v1.58c1.77-.77 3-2.53 3-4.58 0-2.76-2.24-5-5-5z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600">Tree Graphic</span>
                    </button>

                    <!-- Star Element -->
                    <button type="button" onclick="addGraphicElement('star')" class="p-3 rounded-xl border border-purple-100 bg-white hover:bg-purple-50 hover:border-pink-300 transition-all flex flex-col items-center text-center space-y-2 group shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center text-yellow-400 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-10 h-10">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600">Star Graphic</span>
                    </button>

                    <!-- Flower Element -->
                    <button type="button" onclick="addGraphicElement('flower')" class="p-3 rounded-xl border border-purple-100 bg-white hover:bg-purple-50 hover:border-pink-300 transition-all flex flex-col items-center text-center space-y-2 group shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center text-pink-500 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v3m0 12v3m9-9h-3M6 12H3m15.364-6.364l-2.121 2.121M8.757 15.243L6.636 17.364M18.364 18.364l-2.121-2.121M8.757 8.757L6.636 6.636M12 15a3 3 0 100-6 3 3 0 000 6z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600">Flower</span>
                    </button>

                    <!-- Cloud Element -->
                    <button type="button" onclick="addGraphicElement('cloud')" class="p-3 rounded-xl border border-purple-100 bg-white hover:bg-purple-50 hover:border-pink-300 transition-all flex flex-col items-center text-center space-y-2 group shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center text-blue-300 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-10 h-10">
                                <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600">Cloud</span>
                    </button>

                    <!-- Sun Element -->
                    <button type="button" onclick="addGraphicElement('sun')" class="p-3 rounded-xl border border-purple-100 bg-white hover:bg-purple-50 hover:border-pink-300 transition-all flex flex-col items-center text-center space-y-2 group shadow-sm">
                        <div class="w-12 h-12 flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-10 h-10">
                                <path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58a.996.996 0 000 1.41l1.06 1.06c.39.39 1.03.39 1.41 0s.39-1.03 0-1.41L7.4 4.58a.996.996 0 00-1.41 0zM16.54 15.13c.39-.39.39-1.03 0-1.41l-1.06-1.06c-.39-.39-1.03-.39-1.41 0s-.39 1.03 0 1.41l1.06 1.06c.38.39 1.03.39 1.41 0zM5.99 19.42c.39.39 1.03.39 1.41 0l1.06-1.06c.39-.39.39-1.03 0-1.41s-1.03-.39-1.41 0l-1.06 1.06c-.39.38-.39 1.02 0 1.41zm10.55-13.48c-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06c.39-.39.39-1.02 0-1.41z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600">Sun</span>
                    </button>

                    <!-- Birthday Text Element -->
                    <button type="button" onclick="addGraphicElement('birthday')" class="p-3 rounded-xl border border-purple-100 bg-white hover:bg-purple-50 hover:border-pink-300 transition-all flex flex-col items-center text-center space-y-2 group shadow-sm col-span-2">
                        <div class="w-full h-12 flex items-center justify-center text-pink-500 group-hover:scale-105 transition-transform font-black font-outfit text-xs tracking-widest border border-dashed border-pink-200 rounded-lg">
                            HAPPY BIRTHDAY!
                        </div>
                        <span class="text-[10px] font-bold text-slate-600">Birthday Banner</span>
                    </button>
                </div>
            </div>

            <!-- Active Element Settings -->
            <div id="elementSettingsPanel" class="glass-panel rounded-2xl p-5 space-y-4 hidden bg-white/85">
                <div class="flex justify-between items-center border-b border-purple-50 pb-2">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-purple-700">Element Controls</h3>
                    <button type="button" onclick="deselectElement()" class="text-[10px] text-slate-400 hover:text-slate-600 font-bold">Deselect</button>
                </div>
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-slate-500">Selected:</span>
                        <span id="selectedElType" class="font-black text-purple-950 uppercase tracking-wider">Heart</span>
                    </div>

                    <!-- Actions Row -->
                    <div class="grid grid-cols-3 gap-2 pt-2">
                        <button type="button" onclick="flipSelectedElement()" class="py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-[10px] font-bold rounded-xl flex flex-col items-center justify-center space-y-1 transition-colors">
                            <span class="text-sm">⇄</span>
                            <span>Flip H</span>
                        </button>
                        <button type="button" onclick="duplicateSelectedElement()" class="py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-[10px] font-bold rounded-xl flex flex-col items-center justify-center space-y-1 transition-colors">
                            <span class="text-sm">⎘</span>
                            <span>Clone</span>
                        </button>
                        <button type="button" onclick="deleteSelectedElement()" class="py-2 bg-red-50 hover:bg-red-100 text-red-600 text-[10px] font-bold rounded-xl flex flex-col items-center justify-center space-y-1 transition-colors">
                            <span class="text-sm">🗑️</span>
                            <span>Delete</span>
                        </button>
                    </div>

                    <!-- Size Control Row -->
                    <div class="flex items-center justify-between pt-2 border-t border-purple-50">
                        <span class="font-bold text-slate-500">Size:</span>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="resizeSelectedElement(-15)" class="w-8 h-8 rounded-lg bg-purple-50 hover:bg-purple-100 font-black text-purple-700 flex items-center justify-center text-sm">-</button>
                            <span id="selectedElSize" class="font-bold text-purple-950">80px</span>
                            <button type="button" onclick="resizeSelectedElement(15)" class="w-8 h-8 rounded-lg bg-purple-50 hover:bg-purple-100 font-black text-purple-700 flex items-center justify-center text-sm">+</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        @else
        <!-- Right Sidebar: Hidden Dummy Container (For Non-Custom Session) -->
        <div id="rightSidebar" class="hidden"></div>
        @endif

        <!-- Results Mode Right Panel: Frame Overlays Selection -->
        <section id="resultsOverlayPanel" class="lg:col-span-4 flex flex-col space-y-4 overflow-y-auto max-h-[calc(100vh-7rem)] hidden">
            <div class="glass-panel rounded-3xl p-6 space-y-4 bg-white/80 border border-purple-200">
                <h3 class="text-sm font-black font-outfit text-purple-950 uppercase tracking-widest">Select Frame Design</h3>
                <p class="text-[11px] text-purple-700/80 leading-relaxed font-semibold">
                    Add a cute custom overlay frame to your photo strip before downloading.
                </p>

                <div class="space-y-3">
                    <button onclick="selectResultsOverlay(null)" class="overlay-select-btn w-full p-3 rounded-2xl border-2 border-purple-100 bg-white hover:border-pink-300 transition-all text-left flex items-center space-x-3 text-xs font-bold text-purple-950">
                        <div class="w-12 h-16 bg-slate-100 rounded-lg border border-slate-200/50 flex items-center justify-center text-[10px] text-slate-500 font-extrabold uppercase">None</div>
                        <div>
                            <div>Plain Background</div>
                            <div class="text-[10px] text-purple-500/70 font-semibold mt-0.5">Classic solid color border</div>
                        </div>
                    </button>

                    @foreach($overlays as $overlay)
                        <button onclick="selectResultsOverlay('{{ asset($overlay->image_path) }}')" class="overlay-select-btn w-full p-3 rounded-2xl border-2 border-purple-100 bg-white hover:border-pink-300 transition-all text-left flex items-center space-x-3 text-xs font-bold text-purple-950" data-layout="{{ $overlay->category ? $overlay->category->slug : '' }}">
                            <div class="w-12 h-16 bg-pink-100/50 rounded-lg border border-purple-200/20 relative overflow-hidden flex items-center justify-center">
                                <img src="{{ asset($overlay->image_path) }}" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <div>{{ $overlay->name }}</div>
                                <div class="text-[10px] text-purple-500/70 font-semibold mt-0.5">{{ $overlay->description }}</div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

    </main>

    <!-- Modal: Create Custom Frame -->
    <div id="customFrameModal" class="fixed inset-0 z-50 flex items-center justify-center bg-purple-900/10 backdrop-blur-sm hidden p-4">
        <div class="bg-white/95 border-2 border-purple-100 w-full max-w-md rounded-[2.5rem] p-6 md:p-8 space-y-6 relative shadow-2xl text-slate-700">
            <button onclick="closeModal('customFrameModal')" class="absolute top-4 right-4 text-purple-400 hover:text-purple-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            <div>
                <h3 class="text-xl font-bold font-outfit text-purple-950">Create Custom Frame</h3>
                <p class="text-xs text-purple-600 mt-1">Design a customized photo booth frame layout.</p>
            </div>

            <form id="customFrameForm" onsubmit="submitCustomFrame(event)" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-purple-700 uppercase tracking-wider">Frame Name</label>
                    <input type="text" name="name" required class="w-full bg-white border-2 border-purple-100 rounded-2xl px-4 py-2.5 text-sm text-purple-950 focus:outline-none focus:border-pink-300" placeholder="My Birthday Frame">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-purple-700 uppercase tracking-wider">Layout Template</label>
                    <select name="layout_type" class="w-full bg-white border-2 border-purple-100 rounded-2xl px-4 py-2.5 text-sm text-purple-950 focus:outline-none focus:border-pink-300">
                        <option value="strip" class="bg-white text-purple-950">Vertical Strip (4 slots)</option>
                        <option value="grid" class="bg-white text-purple-950">2x2 Grid (4 slots)</option>
                        <option value="single" class="bg-white text-purple-950">Solo Landscape (1 slot)</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-purple-700 uppercase tracking-wider">Background Color</label>
                    <input type="color" name="bg_color" value="#ffffff" class="w-full bg-transparent border-0 h-10 rounded-xl cursor-pointer">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-purple-700 uppercase tracking-wider">Transparent Overlay PNG (Optional)</label>
                    <input type="file" name="overlay_image" accept="image/png,image/svg+xml" class="w-full text-xs text-purple-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200">
                    <span class="text-[10px] text-purple-500/80 block mt-1">Recommended: PNG image with transparent center slots. Dimensions: 1200x1800 (for grid/single) or 400x1200 (for strip).</span>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl text-sm font-semibold text-white shadow-lg btn-gradient mt-4">
                    Create Frame
                </button>
            </form>
        </div>
    </div>

    <!-- Dedicated Camera Session Screen (Booth Mode Viewfinder) -->
    <div id="fullScreenCameraView" class="fixed inset-0 z-50 bg-gradient-to-tr from-[#fff0f3] to-[#f6effc] @if(request('action') === 'capture') flex @else hidden @endif flex-col items-center justify-between p-6 md:p-12">
        <!-- Top header area: Progress indicators -->
        <div class="w-full max-w-2xl flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full bg-pink-500 animate-ping"></span>
                <span class="text-sm font-black font-outfit text-purple-950 uppercase tracking-widest" id="boothProgressTitle">Photo Session</span>
            </div>
            <button onclick="exitFullScreenCamera()" class="px-4 py-2 text-xs font-bold rounded-xl border border-purple-200 text-purple-700 bg-white hover:bg-purple-50 transition-all shadow-sm">
                Cancel Session
            </button>
        </div>

        <!-- Center: Camera Feed Viewfinder -->
        <div class="relative w-full max-w-xl aspect-video bg-slate-900 rounded-[2.5rem] overflow-hidden border-4 border-white shadow-2xl flex items-center justify-center">
            <!-- Live stream video tag -->
            <video id="boothWebcamStream" autoplay playsinline class="w-full h-full object-cover scale-x-[-1]"></video>
            
            <!-- Countdown Overlay -->
            <div id="boothCountdownOverlay" class="absolute inset-0 bg-black/35 flex items-center justify-center hidden">
                <div id="boothCountdownNumber" class="text-[120px] md:text-[160px] font-black text-pink-400 font-outfit drop-shadow-[0_4px_20px_rgba(236,72,153,0.6)] animate-bounce">
                    3
                </div>
            </div>

            <!-- Flash effect overlay -->
            <div id="boothFlashOverlay" class="absolute inset-0 bg-white opacity-0 transition-opacity duration-150 pointer-events-none"></div>

            <!-- Sequence status box -->
            <div id="boothActiveStatus" class="absolute top-6 left-6 px-4 py-1.5 rounded-full bg-pink-500 text-[10px] font-black text-white uppercase tracking-widest flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                <span id="boothStatusText">Pose 1 of 4</span>
            </div>
        </div>

        <!-- Bottom: Shutter Button and instructions -->
        <div class="w-full max-w-md text-center space-y-5">
            <!-- Camera Filters Selection Toolbar -->
            <div class="space-y-1.5">
                <label class="block text-[9px] font-bold text-purple-950/70 uppercase tracking-widest">Camera Filters</label>
                <div class="flex justify-center space-x-1.5 overflow-x-auto py-1 px-2 bg-white/60 backdrop-blur-md rounded-2xl border border-purple-100 max-w-md mx-auto shadow-sm">
                    <button onclick="setCameraFilter('normal')" id="cam-filter-normal" class="px-3 py-1.5 rounded-xl border border-purple-100 text-[10px] font-bold text-slate-600 bg-white hover:bg-pink-50/50 hover:text-pink-600 transition-all shadow-sm bg-pink-100 border-pink-400 text-pink-700">Normal</button>
                    <button onclick="setCameraFilter('grayscale')" id="cam-filter-grayscale" class="px-3 py-1.5 rounded-xl border border-purple-100 text-[10px] font-bold text-slate-600 bg-white hover:bg-pink-50/50 hover:text-pink-600 transition-all shadow-sm">Mono</button>
                    <button onclick="setCameraFilter('sepia')" id="cam-filter-sepia" class="px-3 py-1.5 rounded-xl border border-purple-100 text-[10px] font-bold text-slate-600 bg-white hover:bg-pink-50/50 hover:text-pink-600 transition-all shadow-sm">Sepia</button>
                    <button onclick="setCameraFilter('chrome')" id="cam-filter-chrome" class="px-3 py-1.5 rounded-xl border border-purple-100 text-[10px] font-bold text-slate-600 bg-white hover:bg-pink-50/50 hover:text-pink-600 transition-all shadow-sm">Chrome</button>
                    <button onclick="setCameraFilter('vintage')" id="cam-filter-vintage" class="px-3 py-1.5 rounded-xl border border-purple-100 text-[10px] font-bold text-slate-600 bg-white hover:bg-pink-50/50 hover:text-pink-600 transition-all shadow-sm">Vintage</button>
                    <button onclick="setCameraFilter('neon')" id="cam-filter-neon" class="px-3 py-1.5 rounded-xl border border-purple-100 text-[10px] font-bold text-slate-600 bg-white hover:bg-pink-50/50 hover:text-pink-600 transition-all shadow-sm">Neon</button>
                </div>
            </div>

            <p class="text-xs text-purple-700 font-bold uppercase tracking-wider" id="boothCameraPrompt">
                Ready? Press the button or wait for auto-capture!
            </p>
            
            <div class="flex justify-center items-center">
                <!-- Large Shutter Button -->
                <button onclick="boothCaptureCurrentFrame()" class="w-20 h-20 rounded-full bg-white border-[6px] border-pink-400 hover:border-pink-500 shadow-xl active:scale-95 transition-all flex items-center justify-center group">
                    <div class="w-12 h-12 rounded-full bg-pink-400 group-hover:bg-pink-500 transition-colors"></div>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Image Zoom Preview -->
    <div id="imagePreviewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 hidden p-4" onclick="closeModal('imagePreviewModal')">
        <button class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <img id="modalPreviewImg" src="" class="max-w-full max-h-[90vh] object-contain rounded-lg" onclick="event.stopPropagation()">
    </div>

    <!-- Modal: Choose Photo Source -->
    <div id="sourceModal" class="fixed inset-0 z-50 flex items-center justify-center bg-purple-950/20 backdrop-blur-md hidden p-4">
        <div class="bg-white/95 border-2 border-purple-100 w-full max-w-sm rounded-[2.5rem] p-8 text-center space-y-6 shadow-2xl text-slate-700 relative">
            <button onclick="closeModal('sourceModal')" class="absolute top-4 right-4 text-purple-400 hover:text-purple-600 transition-colors">
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
                <button onclick="chooseAmbilFoto()" class="w-full py-4 bg-pink-400 hover:bg-pink-500 text-white rounded-2xl font-black text-sm shadow-md transition-all flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                    <span>Ambil Foto (Camera)</span>
                </button>

                <!-- Option 2: Pilih File -->
                <button onclick="choosePilihFile()" class="w-full py-4 bg-white border-2 border-purple-200 hover:border-purple-300 text-purple-700 rounded-2xl font-black text-sm transition-all flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
                    </svg>
                    <span>Pilih File (Upload)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Notification Toast Container -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col space-y-2 pointer-events-none" id="toastContainer"></div>

    <!-- Audio Effects for camera shutter and count down -->
    <!-- Mock Shutter Audio using Javascript Synth to avoid missing assets -->
    <script>
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        
        function playBeep(freq, duration) {
            try {
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
                gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration);
                osc.start();
                osc.stop(audioCtx.currentTime + duration);
            } catch (e) {}
        }

        function playShutterSound() {
            try {
                // Shutter snap sound synthesizer
                const bufferSize = audioCtx.sampleRate * 0.1; // 0.1 seconds
                const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
                const data = buffer.getChannelData(0);
                for (let i = 0; i < bufferSize; i++) {
                    data[i] = Math.random() * 2 - 1;
                }
                const whiteNoise = audioCtx.createBufferSource();
                whiteNoise.buffer = buffer;
                
                const filter = audioCtx.createBiquadFilter();
                filter.type = 'bandpass';
                filter.frequency.value = 1000;
                
                const gain = audioCtx.createGain();
                gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);
                
                whiteNoise.connect(filter);
                filter.connect(gain);
                gain.connect(audioCtx.destination);
                whiteNoise.start();
            } catch (e) {}
        }
    </script>

    <!-- Canvas Engine & Interactive Logic -->
    <script>
        // DOM Elements
        let canvas, ctx, frameBgColorPicker, frameBgColorHex, slotSelector;
        
        // App State
        let activeFrameId = null;
        let activeLayout = 'strip'; // strip, grid, single
        let activeBgColor = '#ffffff';
        let activeOverlayImg = null; // HTMLImageElement
        let activeOverlaySrc = null;
        let activeSlots = [];
        let slotImages = {}; // slotIndex -> { img: HTMLImageElement, zoom: 1, x: 0, y: 0 }
        let currentActiveSlotIndex = 0;
        let activeFilter = 'normal';
        let frameScale = 1;
        
        // Webcam state
        let stream = null;
        const webcamStream = document.getElementById('webcamStream');
        let autoCaptureInterval = null;

        // Interaction state
        let isDragging = false;
        let startDragX = 0;
        let startDragY = 0;
        let dragSlotIndex = -1;
        let dragOriginalX = 0;
        let dragOriginalY = 0;
        let dragElementIndex = -1;
        let dragStartOffset = { x: 0, y: 0 };
        let canvasElements = [];
        let selectedElementIndex = -1;
        let isResizingElement = false;
        let framePanX = 0;
        let framePanY = 0;

        // Canvas Scale (for rendering hires vs preview)
        let canvasWidth = 400;
        let canvasHeight = 1200;

        // Initialize App
        window.addEventListener('DOMContentLoaded', () => {
            canvas = document.getElementById('photoboxCanvas');
            ctx = canvas.getContext('2d');
            frameBgColorPicker = document.getElementById('frameBgColorPicker');
            frameBgColorHex = document.getElementById('frameBgColorHex');
            slotSelector = document.getElementById('slotSelector');

            // Check for frame_id query parameter
            const urlParams = new URLSearchParams(window.location.search);
            const targetFrameId = urlParams.get('frame_id');
            let frameSelected = false;
            
            if (targetFrameId) {
                const targetFrameBtn = document.querySelector(`.frame-select-btn[data-frame-id="${targetFrameId}"]`);
                if (targetFrameBtn) {
                    targetFrameBtn.click();
                    frameSelected = true;
                    
                    // Activate Booth Mode (Hide sidebars, center canvas layout, show booth toolbar)
                    document.getElementById('leftSidebar').style.display = 'none';
                    document.getElementById('rightSidebar').style.display = 'none';
                    
                    const center = document.getElementById('centerSandbox');
                    center.classList.remove('lg:col-span-6');
                    center.classList.add('lg:col-span-8', 'lg:col-start-3');
                    
                    document.getElementById('boothToolbar').classList.remove('hidden');
                    
                    // Trigger the selected action immediately
                    const action = urlParams.get('action');
                    setTimeout(() => {
                        if (action === 'capture') {
                            chooseAmbilFoto();
                        } else if (action === 'upload') {
                            choosePilihFile();
                        }
                    }, 450);
                }
            }

            // Check for custom action to initialize preview layout
            if (urlParams.get('action') === 'custom') {
                frameSelected = true;
                setTimeout(() => {
                    previewCustomLayout('strip');
                }, 500);
            }

            // Check for layout parameter to initialize specific layout preset
            const urlLayout = urlParams.get('layout');
            if (urlLayout) {
                frameSelected = true;
                setTimeout(() => {
                    previewCustomLayout(urlLayout);
                }, 500);
            }

            // Check for overlay_id parameter to automatically select overlay design
            const urlOverlayId = urlParams.get('overlay_id');
            if (urlOverlayId) {
                const overlaysList = @json($overlays);
                const selectedOverlay = overlaysList.find(o => o.id == urlOverlayId);
                if (selectedOverlay) {
                    setTimeout(() => {
                        selectResultsOverlay(selectedOverlay.image_path);
                        // Also find the button and highlight it
                        document.querySelectorAll('.overlay-select-btn').forEach(btn => {
                            if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(selectedOverlay.image_path)) {
                                btn.classList.add('border-pink-300', 'bg-pink-50/50');
                            }
                        });
                    }, 600);
                }
            }
            
            if (!frameSelected) {
                // Select first frame in list if exists
                const firstFrameBtn = document.querySelector('.frame-select-btn');
                if (firstFrameBtn) {
                    firstFrameBtn.click();
                } else {
                    // Fallback to basic classic strip if database empty
                    selectFrame(null, 'strip', '#ffffff', null, [
                        {x: 40, y: 50, width: 320, height: 240},
                        {x: 40, y: 330, width: 320, height: 240},
                        {x: 40, y: 610, width: 320, height: 240},
                        {x: 40, y: 890, width: 320, height: 240}
                    ]);
                }
            }

            // Listen to touchpad scroll / pinch events on canvas wrapper to zoom/pan frame
            const canvasWrapper = document.getElementById('canvasWrapper');
            if (canvasWrapper) {
                canvas.style.transformOrigin = 'center center';
                
                canvasWrapper.addEventListener('wheel', (e) => {
                    if (e.ctrlKey) {
                        e.preventDefault();
                        // Pinch to zoom (trackpad)
                        const speed = 0.015;
                        frameScale -= e.deltaY * speed;
                        frameScale = Math.min(Math.max(0.4, frameScale), 3.0);
                        canvas.style.transform = `translate(${framePanX}px, ${framePanY}px) scale(${frameScale})`;
                    } else {
                        // Touchpad scroll to pan frame vertically/horizontally
                        e.preventDefault();
                        framePanY -= e.deltaY;
                        framePanX -= e.deltaX;
                        canvas.style.transform = `translate(${framePanX}px, ${framePanY}px) scale(${frameScale})`;
                    }
                }, { passive: false });
            }

            // Mouse interaction on canvas
            canvas.addEventListener('mousedown', startDrag);
            canvas.addEventListener('mousemove', dragImage);
            canvas.addEventListener('mouseup', endDrag);
            canvas.addEventListener('mouseleave', endDrag);
            canvas.addEventListener('wheel', zoomImage, { passive: false });

            // Touch interaction
            canvas.addEventListener('touchstart', (e) => {
                const t = e.touches[0];
                const rect = canvas.getBoundingClientRect();
                const mouseEvent = new MouseEvent('mousedown', {
                    clientX: t.clientX,
                    clientY: t.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            });
            canvas.addEventListener('touchmove', (e) => {
                const t = e.touches[0];
                const mouseEvent = new MouseEvent('mousemove', {
                    clientX: t.clientX,
                    clientY: t.clientY
                });
                canvas.dispatchEvent(mouseEvent);
                e.preventDefault();
            }, { passive: false });
            canvas.addEventListener('touchend', () => {
                const mouseEvent = new MouseEvent('mouseup', {});
                canvas.dispatchEvent(mouseEvent);
            });
        });

        // Toast Notification System
        function showNotification(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast-notification px-4 py-3 rounded-2xl shadow-xl border flex items-center space-x-3 pointer-events-auto max-w-sm text-sm font-semibold transition-all ${
                type === 'success' ? 'bg-purple-950/85 border-purple-500/25 text-purple-200' : 'bg-red-950/85 border-red-500/25 text-red-200'
            }`;
            
            const checkIcon = type === 'success' 
                ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-purple-400"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-red-400"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>`;

            toast.innerHTML = `${checkIcon} <span>${message}</span>`;
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Modal Utility
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Select Frame Layout & Styles
        function selectFrame(id, layoutType, bgColor, overlayImage, slots) {
            activeFrameId = id;
            activeLayout = layoutType;
            activeBgColor = bgColor;
            activeSlots = slots;
            slotImages = {}; // reset slot images to be safe or map existing

            // Adjust Canvas default width/height based on layout ratio
            if (layoutType === 'strip' || layoutType === 'strip_3') {
                canvasWidth = 400;
                canvasHeight = 1200;
            } else if (layoutType === 'grid' || layoutType === 'grid_6') {
                canvasWidth = 1000;
                canvasHeight = 1200;
            } else {
                // single portrait
                canvasWidth = 1000;
                canvasHeight = 800;
            }

            // Sync hidden slots input
            const slotsInput = document.getElementById('slotsJsonInput');
            if (slotsInput) {
                slotsInput.value = JSON.stringify(slots);
            }

            canvas.width = canvasWidth;
            canvas.height = canvasHeight;

            // Load colors
            if (frameBgColorPicker) {
                frameBgColorPicker.value = bgColor;
            }
            if (frameBgColorHex) {
                frameBgColorHex.value = bgColor.toUpperCase();
            }

            // Set overlay image if exists
            activeOverlayImg = null;
            activeOverlaySrc = overlayImage;
            processedOverlayCanvas = null;
            if (overlayImage && overlayImage !== 'null') {
                const img = new Image();
                img.onload = () => {
                    activeOverlayImg = img;
                    processOverlayImage(img);
                    drawCanvas();
                };
                img.src = '/' + overlayImage;
            }

            // Highlighting selected button style
            document.querySelectorAll('.frame-select-btn').forEach(btn => {
                btn.classList.remove('border-pink-300', 'bg-pink-100/50');
                if (btn.getAttribute('data-frame-id') == id) {
                    btn.classList.add('border-pink-300', 'bg-pink-100/50');
                }
            });

            // Regenerate Slot Selectors UI
            regenerateSlotSelectors();

            // Select Slot 0 by default
            selectActiveSlot(0);

            // Redraw everything
            drawCanvas();

            // Filter overlay designs matching the chosen layout category
            filterOverlayDesigns(layoutType);
        }

        // Filter overlays based on active layout type
        function filterOverlayDesigns(layoutType) {
            document.querySelectorAll('.overlay-select-btn').forEach(btn => {
                const targetLayout = btn.getAttribute('data-layout');
                if (!targetLayout || targetLayout === 'all' || targetLayout === layoutType) {
                    btn.style.display = 'flex';
                } else {
                    btn.style.display = 'none';
                }
            });
        }

        // Apply camera filter visually to webcam stream and save filter state
        function setCameraFilter(filterName) {
            document.querySelectorAll('[id^="cam-filter-"]').forEach(btn => {
                btn.classList.remove('bg-pink-100', 'border-pink-400', 'text-pink-700');
            });
            const activeBtn = document.getElementById(`cam-filter-${filterName}`);
            if (activeBtn) {
                activeBtn.classList.add('bg-pink-100', 'border-pink-400', 'text-pink-700');
            }

            activeFilter = filterName;

            const video = document.getElementById('boothWebcamStream');
            const mainVideo = document.getElementById('webcamStream');
            let cssFilter = 'none';
            switch (filterName) {
                case 'grayscale':
                    cssFilter = 'grayscale(1)';
                    break;
                case 'sepia':
                    cssFilter = 'sepia(0.8)';
                    break;
                case 'chrome':
                    cssFilter = 'contrast(1.2) saturate(1.4)';
                    break;
                case 'vintage':
                    cssFilter = 'sepia(0.4) contrast(0.9) brightness(0.95)';
                    break;
                case 'neon':
                    cssFilter = 'saturate(2) hue-rotate(-20deg) contrast(1.1)';
                    break;
                default:
                    cssFilter = 'none';
            }

            if (video) {
                video.style.filter = cssFilter;
            }
            if (mainVideo) {
                mainVideo.style.filter = cssFilter;
            }
        }

        // Preview helpers for custom layout creation
        function previewCustomLayout(layoutType) {
            let slots = [];
            let bgColor = document.querySelector('input[name="bg_color"]') ? document.querySelector('input[name="bg_color"]').value : '#ffffff';
            const shapeSelector = document.getElementById('slotShapeSelector');
            const shape = shapeSelector ? shapeSelector.value : 'rect';

            if (layoutType === 'strip') {
                slots = [
                    {x: 40, y: 50, width: 320, height: 240, shape: shape},
                    {x: 40, y: 330, width: 320, height: 240, shape: shape},
                    {x: 40, y: 610, width: 320, height: 240, shape: shape},
                    {x: 40, y: 890, width: 320, height: 240, shape: shape}
                ];
            } else if (layoutType === 'strip_3') {
                slots = [
                    {x: 40, y: 80, width: 320, height: 250, shape: shape},
                    {x: 40, y: 390, width: 320, height: 250, shape: shape},
                    {x: 40, y: 700, width: 320, height: 250, shape: shape}
                ];
            } else if (layoutType === 'grid') {
                slots = [
                    {x: 50, y: 50, width: 420, height: 315, shape: shape},
                    {x: 530, y: 50, width: 420, height: 315, shape: shape},
                    {x: 50, y: 415, width: 420, height: 315, shape: shape},
                    {x: 530, y: 415, width: 420, height: 315, shape: shape}
                ];
            } else if (layoutType === 'grid_6') {
                slots = [
                    {x: 50, y: 50, width: 420, height: 315, shape: shape},
                    {x: 530, y: 50, width: 420, height: 315, shape: shape},
                    {x: 50, y: 425, width: 420, height: 315, shape: shape},
                    {x: 530, y: 425, width: 420, height: 315, shape: shape},
                    {x: 50, y: 800, width: 420, height: 315, shape: shape},
                    {x: 530, y: 800, width: 420, height: 315, shape: shape}
                ];
            } else if (layoutType === 'single') {
                slots = [
                    {x: 50, y: 50, width: 900, height: 675, shape: shape}
                ];
            }
            selectFrame(null, layoutType, bgColor, null, slots);
        }

        function previewCustomBg(bgColor) {
            activeBgColor = bgColor;
            const picker = document.querySelector('input[type="color"][name="bg_color"]');
            const textInput = document.getElementById('customBgColorHex');
            if (picker) picker.value = bgColor;
            if (textInput) textInput.value = bgColor.toUpperCase();
            drawCanvas();
        }

        function previewCustomOverlay(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = () => {
                        activeOverlayImg = img;
                        processOverlayImage(img);
                        drawCanvas();
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function regenerateSlotSelectors() {
            if (!slotSelector) return;
            slotSelector.innerHTML = '';
            activeSlots.forEach((slot, index) => {
                const btn = document.createElement('button');
                btn.className = `slot-btn border border-purple-100 rounded-xl py-2 px-1 text-center font-bold relative transition-colors ${index === currentActiveSlotIndex ? 'bg-pink-100/50 border-pink-300 text-pink-700 font-extrabold' : 'bg-white hover:bg-purple-50 text-purple-700'}`;
                btn.id = `slot-btn-${index}`;
                btn.onclick = () => selectActiveSlot(index);
                btn.innerHTML = `
                    ${index + 1}
                    <input type="file" id="slot-file-${index}" accept="image/*" class="hidden" onchange="loadImageToSlot(event, ${index})">
                `;
                slotSelector.appendChild(btn);
            });
        }

        function selectActiveSlot(index) {
            currentActiveSlotIndex = index;
            document.querySelectorAll('.slot-btn').forEach((btn, i) => {
                if (i === index) {
                    btn.className = 'slot-btn border border-pink-300 rounded-xl py-2 px-1 text-center font-extrabold bg-pink-100/50 text-pink-700 relative';
                } else {
                    btn.className = 'slot-btn border border-purple-100 rounded-xl py-2 px-1 text-center font-bold bg-white hover:bg-purple-50 text-purple-700 relative';
                }
            });
        }

        function updateFrameBgColor(color) {
            if (/^#[0-9A-F]{6}$/i.test(color)) {
                activeBgColor = color;
                if (frameBgColorPicker) {
                    frameBgColorPicker.value = color;
                }
                if (frameBgColorHex) {
                    frameBgColorHex.value = color.toUpperCase();
                }
                drawCanvas();
            }
        }

        // File loading to slots
        function loadImageToSlot(event, slotIndex) {
            const file = event.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    // Set default scale & positioning in slot
                    const slot = activeSlots[slotIndex];
                    // Calculate zoom to cover slot perfectly
                    const zoom = Math.max(slot.width / img.width, slot.height / img.height);
                    
                    slotImages[slotIndex] = {
                        img: img,
                        zoom: zoom,
                        x: 0,
                        y: 0
                    };
                    drawCanvas();
                    showNotification(`Loaded image into slot ${slotIndex + 1}!`);
                    checkAllSlotsFilled();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        // Bulk load files (allows dropping or selecting multiple files at once)
        function uploadBulkImages(event) {
            const files = event.target.files;
            if (!files.length) return;

            let loaded = 0;
            Array.from(files).forEach((file, index) => {
                if (index >= activeSlots.length) return; // ignore excess files

                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
                    img.onload = () => {
                        const slot = activeSlots[index];
                        const zoom = Math.max(slot.width / img.width, slot.height / img.height);
                        
                        slotImages[index] = {
                            img: img,
                            zoom: zoom,
                            x: 0,
                            y: 0
                        };
                        loaded++;
                        if (loaded === Math.min(files.length, activeSlots.length)) {
                            drawCanvas();
                            showNotification(`Loaded ${loaded} photos!`);
                            checkAllSlotsFilled();
                        }
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        // Canvas Rendering engine
        function drawCanvas() {
            // 1. Draw Background
            ctx.fillStyle = activeBgColor;
            ctx.fillRect(0, 0, canvasWidth, canvasHeight);

            // 2. Draw Photos inside Slots
            activeSlots.forEach((slot, index) => {
                ctx.save();
                
                // Create clipping region for the slot
                createSlotPath(ctx, slot);
                ctx.clip();

                const slotImg = slotImages[index];
                if (slotImg) {
                    // Render image based on zoom, pan (x, y) coordinates centered in slot
                    const drawWidth = slotImg.img.width * slotImg.zoom;
                    const drawHeight = slotImg.img.height * slotImg.zoom;
                    
                    // Center point calculation
                    const centerX = slot.x + slot.width / 2;
                    const centerY = slot.y + slot.height / 2;
                    
                    // Top-left draw coordinates
                    const x = centerX - drawWidth / 2 + slotImg.x;
                    const y = centerY - drawHeight / 2 + slotImg.y;

                    // Apply filters to slot if rendering
                    applyCanvasFilter(ctx);
                    
                    ctx.drawImage(slotImg.img, x, y, drawWidth, drawHeight);
                    
                    // Reset filter
                    ctx.filter = 'none';
                } else {
                    // Fill slot with clean white to look like a template slot cutout
                    ctx.fillStyle = '#ffffff';
                    createSlotPath(ctx, slot);
                    ctx.fill();
                    
                    // Draw slot placeholder subtle border
                    ctx.strokeStyle = 'rgba(0, 0, 0, 0.1)';
                    ctx.lineWidth = 1.5;
                    ctx.stroke();
                    
                    // Text placeholder
                    ctx.fillStyle = 'rgba(0, 0, 0, 0.3)';
                    ctx.font = 'bold 16px "Instrument Sans"';
                    ctx.textAlign = 'center';
                    ctx.fillText(`${index + 1}`, slot.x + slot.width / 2, slot.y + slot.height / 2 - 4);
                    ctx.font = '10px "Instrument Sans"';
                    ctx.fillText('Click to fill', slot.x + slot.width / 2, slot.y + slot.height / 2 + 12);
                }
                ctx.restore();
            });

            // 3. Draw Overlay Image if exists (Draw on top, using processed transparent-slotted canvas!)
            if (activeOverlayImg) {
                if (processedOverlayCanvas) {
                    ctx.drawImage(processedOverlayCanvas, 0, 0, canvasWidth, canvasHeight);
                } else {
                    ctx.drawImage(activeOverlayImg, 0, 0, canvasWidth, canvasHeight);
                }
            }

            // 4. Draw frame border style (classic aesthetic details)
            if (activeLayout === 'strip') {
                // Classic branding bottom text
                ctx.fillStyle = 'rgba(0, 0, 0, 0.25)';
                ctx.font = 'italic bold 14px "Outfit"';
                ctx.textAlign = 'center';
                ctx.fillText('• PHOTOBOX STUDIO •', canvasWidth / 2, canvasHeight - 40);
            }

            // 5. Draw Custom Graphic Elements
            canvasElements.forEach((el, index) => {
                if (el.type === 'heart') {
                    drawHeart(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'star') {
                    drawStar(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'fish') {
                    drawFish(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'wave') {
                    drawWave(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'tree') {
                    drawTree(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'flower') {
                    drawFlower(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'cloud') {
                    drawCloud(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'sun') {
                    drawSun(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'pen') {
                    drawPen(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'pencil') {
                    drawPencil(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'apple') {
                    drawApple(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                } else if (el.type === 'birthday') {
                    drawBirthday(ctx, el.x, el.y, el.width, el.height, el.flippedH);
                }

                // If selected, draw selection border box & corner resize handle
                if (index === selectedElementIndex) {
                    ctx.save();
                    ctx.strokeStyle = '#ec4899';
                    ctx.lineWidth = 2;
                    ctx.setLineDash([6, 4]);
                    ctx.strokeRect(el.x - el.width / 2, el.y - el.height / 2, el.width, el.height);
                    
                    // Draw resize handle circle at bottom right
                    ctx.fillStyle = '#ec4899';
                    ctx.beginPath();
                    ctx.arc(el.x + el.width / 2, el.y + el.height / 2, 7, 0, 2 * Math.PI);
                    ctx.fill();
                    ctx.restore();
                }
            });
        }

        // Vector drawings for custom elements
        function drawHeart(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.fillStyle = '#ff758f';
            c.beginPath();
            c.moveTo(0, -h/4);
            c.bezierCurveTo(-w/2, -h/2, -w/2, h/4, 0, h/2);
            c.bezierCurveTo(w/2, h/4, w/2, -h/2, 0, -h/4);
            c.fill();
            c.restore();
        }

        function drawStar(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.fillStyle = '#ffca3a';
            c.beginPath();
            let spikes = 5;
            let outerRadius = w/2;
            let innerRadius = w/4;
            let rot = Math.PI / 2 * 3;
            let cx = 0, cy = 0;
            let step = Math.PI / spikes;
            c.moveTo(0, -outerRadius);
            for (let i = 0; i < spikes; i++) {
                cx = Math.cos(rot) * outerRadius;
                cy = Math.sin(rot) * outerRadius;
                c.lineTo(cx, cy);
                rot += step;
                cx = Math.cos(rot) * innerRadius;
                cy = Math.sin(rot) * innerRadius;
                c.lineTo(cx, cy);
                rot += step;
            }
            c.lineTo(0, -outerRadius);
            c.closePath();
            c.fill();
            c.restore();
        }

        function drawFish(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.fillStyle = '#8ecae6';
            c.beginPath();
            c.ellipse(0, 0, w/2, h/3, 0, 0, 2 * Math.PI);
            c.fill();
            c.beginPath();
            c.moveTo(-w/2, 0);
            c.lineTo(-w*0.7, -h/3);
            c.lineTo(-w*0.7, h/3);
            c.closePath();
            c.fill();
            c.fillStyle = '#ffffff';
            c.beginPath();
            c.arc(w/4, -h/8, 4, 0, 2 * Math.PI);
            c.fill();
            c.fillStyle = '#000000';
            c.beginPath();
            c.arc(w/4, -h/8, 2, 0, 2 * Math.PI);
            c.fill();
            c.restore();
        }

        function drawWave(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.strokeStyle = '#219ebc';
            c.lineWidth = 4;
            c.lineCap = 'round';
            c.beginPath();
            c.moveTo(-w/2, 0);
            c.bezierCurveTo(-w/4, -h/2, 0, h/2, w/2, 0);
            c.stroke();
            c.restore();
        }

        function drawTree(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.fillStyle = '#b7094c';
            c.fillRect(-w/10, h/10, w/5, h/3);
            c.fillStyle = '#38b000';
            c.beginPath();
            c.moveTo(0, -h/2);
            c.lineTo(-w/2, -h/10);
            c.lineTo(w/2, -h/10);
            c.closePath();
            c.fill();
            c.beginPath();
            c.moveTo(0, -h/4);
            c.lineTo(-w/2.5, h/10);
            c.lineTo(w/2.5, h/10);
            c.closePath();
            c.fill();
            c.restore();
        }

        function drawFlower(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.strokeStyle = '#fb8500';
            c.lineWidth = 2;
            
            // Draw petals (5 circles)
            let petalColor = '#ff758f';
            c.fillStyle = petalColor;
            for (let i = 0; i < 5; i++) {
                c.save();
                c.rotate(i * 2 * Math.PI / 5);
                c.beginPath();
                c.arc(0, -h/4, w/5, 0, 2*Math.PI);
                c.fill();
                c.stroke();
                c.restore();
            }
            // Draw center disk
            c.fillStyle = '#ffca3a';
            c.beginPath();
            c.arc(0, 0, w/6, 0, 2*Math.PI);
            c.fill();
            c.stroke();
            
            c.restore();
        }

        function drawCloud(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.fillStyle = '#eaf4f4';
            c.strokeStyle = '#a8dadc';
            c.lineWidth = 3;
            c.beginPath();
            c.arc(-w/4, h/10, w/4, 0.5 * Math.PI, 1.5 * Math.PI);
            c.arc(0, -h/10, w/3, 1.0 * Math.PI, 2.0 * Math.PI);
            c.arc(w/4, h/10, w/4, 1.5 * Math.PI, 0.5 * Math.PI);
            c.closePath();
            c.fill();
            c.stroke();
            c.restore();
        }

        function drawSun(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.fillStyle = '#ffb703';
            c.strokeStyle = '#fb8500';
            c.lineWidth = 3;
            c.beginPath();
            c.arc(0, 0, w/4, 0, 2*Math.PI);
            c.fill();
            c.stroke();
            
            for (let i = 0; i < 8; i++) {
                c.rotate(Math.PI / 4);
                c.beginPath();
                c.moveTo(0, -w/3);
                c.lineTo(0, -w/2);
                c.stroke();
            }
            c.restore();
        }

        function drawPen(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.rotate(-Math.PI / 4);
            c.fillStyle = '#4361ee';
            c.strokeStyle = '#3f37c9';
            c.lineWidth = 2;
            
            c.fillRect(-w/10, -h/3, w/5, h*0.6);
            c.strokeRect(-w/10, -h/3, w/5, h*0.6);
            
            c.fillStyle = '#e0e0e0';
            c.beginPath();
            c.moveTo(-w/10, h*0.27);
            c.lineTo(0, h/2);
            c.lineTo(w/10, h*0.27);
            c.closePath();
            c.fill();
            c.stroke();
            
            c.fillStyle = '#000000';
            c.beginPath();
            c.moveTo(-w/25, h*0.43);
            c.lineTo(0, h/2);
            c.lineTo(w/25, h*0.43);
            c.closePath();
            c.fill();
            
            c.restore();
        }

        function drawPencil(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.rotate(-Math.PI / 4);
            c.fillStyle = '#ffb703';
            c.strokeStyle = '#d48a00';
            c.lineWidth = 2;
            
            c.fillRect(-w/10, -h/3, w/5, h*0.5);
            c.strokeRect(-w/10, -h/3, w/5, h*0.5);
            
            c.fillStyle = '#ff758f';
            c.fillRect(-w/10, -h*0.42, w/5, h*0.09);
            c.strokeRect(-w/10, -h*0.42, w/5, h*0.09);
            
            c.fillStyle = '#ffeedd';
            c.beginPath();
            c.moveTo(-w/10, h*0.17);
            c.lineTo(0, h/2);
            c.lineTo(w/10, h*0.17);
            c.closePath();
            c.fill();
            c.stroke();
            
            c.fillStyle = '#2b2d42';
            c.beginPath();
            c.moveTo(-w/25, h*0.4);
            c.lineTo(0, h/2);
            c.lineTo(w/25, h*0.4);
            c.closePath();
            c.fill();
            
            c.restore();
        }

        function drawApple(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            c.fillStyle = '#d90429';
            c.strokeStyle = '#b7094c';
            c.lineWidth = 2;
            c.beginPath();
            c.arc(-w/6, 0, w/3, 0, 2*Math.PI);
            c.arc(w/6, 0, w/3, 0, 2*Math.PI);
            c.fill();
            c.stroke();
            
            c.strokeStyle = '#6f4e37';
            c.lineWidth = 3;
            c.beginPath();
            c.arc(-w/10, -h/2.2, w/4, 0, 0.4*Math.PI);
            c.stroke();
            
            c.fillStyle = '#38b000';
            c.beginPath();
            c.ellipse(w/12, -h/2, w/6, h/10, Math.PI/4, 0, 2*Math.PI);
            c.fill();
            
            c.restore();
        }

        function drawBirthday(c, x, y, w, h, flippedH) {
            c.save();
            c.translate(x, y);
            if (flippedH) c.scale(-1, 1);
            
            c.fillStyle = 'rgba(251, 113, 133, 0.15)';
            c.fillRect(-w/2, -h/2, w, h);
            
            c.strokeStyle = '#fb7185';
            c.lineWidth = 2;
            c.setLineDash([4, 4]);
            c.strokeRect(-w/2, -h/2, w, h);
            c.setLineDash([]);
            
            c.fillStyle = '#e11d48';
            c.font = 'bold italic 13px "Outfit", sans-serif';
            c.textAlign = 'center';
            c.textBaseline = 'middle';
            c.fillText('🎉 HAPPY BIRTHDAY! 🎉', 0, 0);
            
            c.restore();
        }

        function addGraphicElement(type) {
            canvasElements.push({
                type: type,
                x: canvasWidth / 2,
                y: canvasHeight / 2,
                width: 80,
                height: 80,
                flippedH: false
            });
            selectElement(canvasElements.length - 1);
        }

        function clearGraphicElements() {
            canvasElements = [];
            selectElement(-1);
        }

        // Selected element controls
        function selectElement(index) {
            selectedElementIndex = index;
            if (index === -1) {
                document.getElementById('elementSettingsPanel').classList.add('hidden');
            } else {
                const el = canvasElements[index];
                document.getElementById('elementSettingsPanel').classList.remove('hidden');
                document.getElementById('selectedElType').innerText = el.type;
                document.getElementById('selectedElSize').innerText = el.width + 'px';
            }
            drawCanvas();
        }

        function deselectElement() {
            selectElement(-1);
        }

        function flipSelectedElement() {
            if (selectedElementIndex !== -1) {
                const el = canvasElements[selectedElementIndex];
                el.flippedH = !el.flippedH;
                drawCanvas();
            }
        }

        function duplicateSelectedElement() {
            if (selectedElementIndex !== -1) {
                const el = canvasElements[selectedElementIndex];
                canvasElements.push({
                    type: el.type,
                    x: el.x + 20,
                    y: el.y + 20,
                    width: el.width,
                    height: el.height,
                    flippedH: el.flippedH
                });
                selectElement(canvasElements.length - 1);
            }
        }

        function deleteSelectedElement() {
            if (selectedElementIndex !== -1) {
                canvasElements.splice(selectedElementIndex, 1);
                selectElement(-1);
            }
        }

        function resizeSelectedElement(delta) {
            if (selectedElementIndex !== -1) {
                const el = canvasElements[selectedElementIndex];
                el.width = Math.max(20, el.width + delta);
                el.height = Math.max(20, el.height + delta);
                document.getElementById('selectedElSize').innerText = el.width + 'px';
                drawCanvas();
            }
        }

        function updateSlotShape(shape) {
            activeSlots.forEach(slot => {
                slot.shape = shape;
            });
            drawCanvas();
        }

        function createSlotPath(c, slot) {
            c.beginPath();
            const shape = slot.shape || 'rect';
            if (shape === 'circle') {
                const r = Math.min(slot.width, slot.height) / 2;
                c.arc(slot.x + slot.width / 2, slot.y + slot.height / 2, r, 0, 2 * Math.PI);
            } else if (shape === 'heart') {
                const cx = slot.x + slot.width / 2;
                const cy = slot.y + slot.height / 2;
                const w = slot.width;
                const h = slot.height;
                c.moveTo(cx, cy - h/4);
                c.bezierCurveTo(cx - w/2, cy - h/2, cx - w/2, cy + h/4, cx, cy + h/2);
                c.bezierCurveTo(cx + w/2, cy + h/4, cx + w/2, cy - h/2, cx, cy - h/4);
            } else if (shape === 'star') {
                const cx = slot.x + slot.width / 2;
                const cy = slot.y + slot.height / 2;
                const spikes = 5;
                const outerRadius = Math.min(slot.width, slot.height) / 2;
                const innerRadius = outerRadius / 2;
                let rot = Math.PI / 2 * 3;
                let step = Math.PI / spikes;
                c.moveTo(cx, cy - outerRadius);
                for (let i = 0; i < spikes; i++) {
                    c.lineTo(cx + Math.cos(rot) * outerRadius, cy + Math.sin(rot) * outerRadius);
                    rot += step;
                    c.lineTo(cx + Math.cos(rot) * innerRadius, cy + Math.sin(rot) * innerRadius);
                    rot += step;
                }
                c.closePath();
            } else {
                c.rect(slot.x, slot.y, slot.width, slot.height);
            }
        }

        function createHiresSlotPath(c, slot, scale) {
            c.beginPath();
            const shape = slot.shape || 'rect';
            const sX = slot.x * scale;
            const sY = slot.y * scale;
            const sW = slot.width * scale;
            const sH = slot.height * scale;
            
            if (shape === 'circle') {
                const r = Math.min(sW, sH) / 2;
                c.arc(sX + sW / 2, sY + sH / 2, r, 0, 2 * Math.PI);
            } else if (shape === 'heart') {
                const cx = sX + sW / 2;
                const cy = sY + sH / 2;
                c.moveTo(cx, cy - sH/4);
                c.bezierCurveTo(cx - sW/2, cy - sH/2, cx - sW/2, cy + sH/4, cx, cy + sH/2);
                c.bezierCurveTo(cx + sW/2, cy + sH/4, cx + sW/2, cy - sH/2, cx, cy - sH/4);
            } else if (shape === 'star') {
                const cx = sX + sW / 2;
                const cy = sY + sH / 2;
                const spikes = 5;
                const outerRadius = Math.min(sW, sH) / 2;
                const innerRadius = outerRadius / 2;
                let rot = Math.PI / 2 * 3;
                let step = Math.PI / spikes;
                c.moveTo(cx, cy - outerRadius);
                for (let i = 0; i < spikes; i++) {
                    c.lineTo(cx + Math.cos(rot) * outerRadius, cy + Math.sin(rot) * outerRadius);
                    rot += step;
                    c.lineTo(cx + Math.cos(rot) * innerRadius, cy + Math.sin(rot) * innerRadius);
                    rot += step;
                }
                c.closePath();
            } else {
                c.rect(sX, sY, sW, sH);
            }
        }

        // Apply visual CSS filters to canvas context
        function applyCanvasFilter(context) {
            switch (activeFilter) {
                case 'grayscale':
                    context.filter = 'grayscale(100%)';
                    break;
                case 'sepia':
                    context.filter = 'sepia(80%)';
                    break;
                case 'chrome':
                    context.filter = 'contrast(120%) saturate(140%) hue-rotate(10deg)';
                    break;
                case 'neon':
                    context.filter = 'saturate(200%) hue-rotate(-20deg) contrast(110%)';
                    break;
                case 'vintage':
                    context.filter = 'sepia(40%) contrast(90%) brightness(95%) saturate(110%)';
                    break;
                default:
                    context.filter = 'none';
            }
        }

        function applyImageFilter(filter) {
            activeFilter = filter;
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active-filter', 'border-purple-500'));
            event.target.classList.add('active-filter', 'border-purple-500');
            drawCanvas();
        }

        // Drag and Zoom Interaction Logic
        function getCanvasMouseCoords(event) {
            const rect = canvas.getBoundingClientRect();
            // Scale coords to match internal canvas width/height
            const x = (event.clientX - rect.left) * (canvas.width / rect.width);
            const y = (event.clientY - rect.top) * (canvas.height / rect.height);
            return { x, y };
        }

        function getSlotAtCoords(x, y) {
            for (let i = 0; i < activeSlots.length; i++) {
                const slot = activeSlots[i];
                if (x >= slot.x && x <= slot.x + slot.width && y >= slot.y && y <= slot.y + slot.height) {
                    return i;
                }
            }
            return -1;
        }

        function startDrag(e) {
            const coords = getCanvasMouseCoords(e);
            
            // 1. Check if user clicked on the corner resize handle of the currently selected element
            if (selectedElementIndex !== -1) {
                const el = canvasElements[selectedElementIndex];
                const handleX = el.x + el.width / 2;
                const handleY = el.y + el.height / 2;
                const dist = Math.hypot(coords.x - handleX, coords.y - handleY);
                if (dist <= 15) {
                    isDragging = true;
                    isResizingElement = true;
                    dragElementIndex = selectedElementIndex;
                    return;
                }
            }

            // 2. Check if user clicked inside any graphic element to select and drag it
            for (let i = canvasElements.length - 1; i >= 0; i--) {
                const el = canvasElements[i];
                const dx = coords.x - el.x;
                const dy = coords.y - el.y;
                if (Math.abs(dx) <= el.width / 2 && Math.abs(dy) <= el.height / 2) {
                    isDragging = true;
                    dragElementIndex = i;
                    dragStartOffset.x = dx;
                    dragStartOffset.y = dy;
                    selectElement(i);
                    return;
                }
            }

            // 3. Fallback to slot image panning
            const slotIdx = getSlotAtCoords(coords.x, coords.y);
            if (slotIdx !== -1 && slotImages[slotIdx]) {
                isDragging = true;
                dragSlotIndex = slotIdx;
                startDragX = coords.x;
                startDragY = coords.y;
                dragOriginalX = slotImages[slotIdx].x;
                dragOriginalY = slotImages[slotIdx].y;
                selectElement(-1); // clicked on slot, deselect element
            } else {
                selectElement(-1); // clicked on background, deselect element
            }
        }

        function dragImage(e) {
            if (!isDragging) return;
            const coords = getCanvasMouseCoords(e);

            if (isResizingElement && dragElementIndex !== -1) {
                // Resize element: distance from center to handle
                const el = canvasElements[dragElementIndex];
                const newW = Math.max(20, (coords.x - el.x) * 2);
                const newH = Math.max(20, (coords.y - el.y) * 2);
                el.width = newW;
                el.height = newH;
                document.getElementById('selectedElSize').innerText = Math.round(newW) + 'px';
                drawCanvas();
                return;
            }

            if (dragElementIndex !== -1) {
                // Drag the graphic element
                canvasElements[dragElementIndex].x = coords.x - dragStartOffset.x;
                canvasElements[dragElementIndex].y = coords.y - dragStartOffset.y;
                drawCanvas();
                return;
            }

            if (dragSlotIndex !== -1) {
                const dx = coords.x - startDragX;
                const dy = coords.y - startDragY;

                slotImages[dragSlotIndex].x = dragOriginalX + dx;
                slotImages[dragSlotIndex].y = dragOriginalY + dy;
                
                drawCanvas();
            }
        }

        function endDrag() {
            isDragging = false;
            dragSlotIndex = -1;
            dragElementIndex = -1;
            isResizingElement = false;
        }

        function zoomImage(e) {
            e.preventDefault();
            const coords = getCanvasMouseCoords(e);
            const slotIdx = getSlotAtCoords(coords.x, coords.y);
            
            if (slotIdx !== -1 && slotImages[slotIdx]) {
                const factor = e.deltaY < 0 ? 1.05 : 0.95;
                const slotImg = slotImages[slotIdx];
                const newZoom = slotImg.zoom * factor;

                // Restrict zoom limits (don't scale smaller than slot layout size)
                const slot = activeSlots[slotIdx];
                const minZoom = Math.max(slot.width / slotImg.img.width, slot.height / slotImg.img.height);
                
                slotImg.zoom = Math.max(newZoom, minZoom);
                drawCanvas();
            }
        }

        // Camera Logic
        function openWebcam() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                document.getElementById('fullScreenCameraView').classList.remove('hidden');
                document.getElementById('fullScreenCameraView').classList.add('flex');
                document.getElementById('boothCameraPrompt').innerText = "Align your face & press capture";
                
                // Hide header and main layout to prevent flashing
                document.getElementById('appHeader').classList.add('hidden');
                document.getElementById('appMain').classList.add('hidden');
                
                navigator.mediaDevices.getUserMedia({ video: { width: 1280, height: 720 } })
                    .then(s => {
                        stream = s;
                        document.getElementById('boothWebcamStream').srcObject = s;
                    })
                    .catch(err => {
                        const urlParams = new URLSearchParams(window.location.search);
                        if (urlParams.get('frame_id')) {
                            showNotification("Camera access denied or unavailable. Redirecting home...", "error");
                            setTimeout(() => {
                                window.location.href = "{{ route('landing') }}";
                            }, 2000);
                        } else {
                            showNotification("Camera access denied or unavailable. You can upload files instead.", "error");
                            closeWebcam();
                        }
                    });
            } else {
                showNotification("Camera not supported on this browser.", "error");
            }
        }

        function closeWebcam() {
            document.getElementById('fullScreenCameraView').classList.add('hidden');
            document.getElementById('fullScreenCameraView').classList.remove('flex');
            
            // Restore header and main layout
            document.getElementById('appHeader').classList.remove('hidden');
            document.getElementById('appMain').classList.remove('hidden');
            
            // Destroy FOUC preventer style block
            const foucStyle = document.getElementById('foucPreventer');
            if (foucStyle) {
                foucStyle.remove();
            }
            
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            if (autoCaptureInterval) {
                clearInterval(autoCaptureInterval);
                autoCaptureInterval = null;
                document.getElementById('boothActiveStatus').classList.add('hidden');
            }
        }

        // Take a sequential session of photos
        function startAutoCapture() {
            selectActiveSlot(0);
            openWebcam();
            
            // Set prompt text
            document.getElementById('boothCameraPrompt').innerText = "Pose & click the shutter button!";
            document.getElementById('boothStatusText').innerText = `Pose 1 of ${activeSlots.length}`;
            
            // Hide the countdown overlay entirely
            document.getElementById('boothCountdownOverlay').classList.add('hidden');
            // Show the active status
            document.getElementById('boothActiveStatus').classList.remove('hidden');
        }

        // Captures video frame to the active slot
        function capturePhotoToSlot(slotIndex) {
            if (!stream) return;
            const videoElement = document.getElementById('boothWebcamStream');

            const offscreenCanvas = document.createElement('canvas');
            offscreenCanvas.width = videoElement.videoWidth;
            offscreenCanvas.height = videoElement.videoHeight;
            const tempCtx = offscreenCanvas.getContext('2d');
            
            // Mirror camera frame
            tempCtx.translate(offscreenCanvas.width, 0);
            tempCtx.scale(-1, 1);
            tempCtx.drawImage(videoElement, 0, 0);

            const dataUrl = offscreenCanvas.toDataURL('image/png');
            
            const img = new Image();
            img.onload = () => {
                const slot = activeSlots[slotIndex];
                const zoom = Math.max(slot.width / img.width, slot.height / img.height);
                slotImages[slotIndex] = {
                    img: img,
                    zoom: zoom,
                    x: 0,
                    y: 0
                };
                drawCanvas();
                // Check if all slots are filled to transition to Results Mode
                checkAllSlotsFilled();
            };
            img.src = dataUrl;
        }

        // Manual capture current frame to active slot
        function boothCaptureCurrentFrame() {
            if (!stream) return;
            
            // Snap shutter sound & flash
            const flash = document.getElementById('boothFlashOverlay');
            flash.style.opacity = '1';
            playShutterSound();
            setTimeout(() => flash.style.opacity = '0', 100);

            capturePhotoToSlot(currentActiveSlotIndex);
            showNotification(`Slot ${currentActiveSlotIndex + 1} captured!`);

            // Advance slot
            let nextSlot = currentActiveSlotIndex + 1;
            if (nextSlot < activeSlots.length) {
                selectActiveSlot(nextSlot);
                document.getElementById('boothStatusText').innerText = `Pose ${nextSlot + 1} of ${activeSlots.length}`;
                document.getElementById('boothCameraPrompt').innerText = "Pose for the next shot!";
            } else {
                // All slots are captured!
                showNotification("All photos captured! Generating print strip...");
                setTimeout(() => {
                    closeWebcam();
                    enterResultsMode();
                }, 1000);
            }
        }

        function exitFullScreenCamera() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('frame_id')) {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
                window.location.href = "{{ route('landing') }}";
            } else {
                closeWebcam();
            }
        }

        // Save & Compile creation via base64 upload
        function saveAndCompileCreation() {
            // Check if slots are filled
            let filledSlots = Object.keys(slotImages).length;
            if (filledSlots === 0) {
                showNotification("Add at least one photo to save creation!", "error");
                return;
            }

            // Create a high resolution compile canvas to ensure printing quality
            const hiresCanvas = document.createElement('canvas');
            const scale = 2; // 2x resolution scale
            hiresCanvas.width = canvasWidth * scale;
            hiresCanvas.height = canvasHeight * scale;
            const hCtx = hiresCanvas.getContext('2d');

            // Draw Background (Hires)
            hCtx.fillStyle = activeBgColor;
            hCtx.fillRect(0, 0, hiresCanvas.width, hiresCanvas.height);

            // Draw Slots scaled
            activeSlots.forEach((slot, index) => {
                hCtx.save();
                
                // Hires clipping region
                createHiresSlotPath(hCtx, slot, scale);
                hCtx.clip();

                const slotImg = slotImages[index];
                if (slotImg) {
                    const drawWidth = slotImg.img.width * slotImg.zoom * scale;
                    const drawHeight = slotImg.img.height * slotImg.zoom * scale;
                    
                    const centerX = (slot.x + slot.width / 2) * scale;
                    const centerY = (slot.y + slot.height / 2) * scale;
                    
                    const x = centerX - drawWidth / 2 + slotImg.x * scale;
                    const y = centerY - drawHeight / 2 + slotImg.y * scale;

                    // Filter
                    applyCanvasFilter(hCtx);
                    
                    hCtx.drawImage(slotImg.img, x, y, drawWidth, drawHeight);
                    hCtx.filter = 'none';
                } else {
                    hCtx.fillStyle = '#ffffff';
                    createHiresSlotPath(hCtx, slot, scale);
                    hCtx.fill();
                }
                hCtx.restore();
            });

            // Draw Overlay (Hires) - Draw it AFTER photos so transparent slots reveal them and stickers sit on top!
            if (activeOverlayImg) {
                if (processedOverlayCanvas) {
                    hCtx.drawImage(processedOverlayCanvas, 0, 0, hiresCanvas.width, hiresCanvas.height);
                } else {
                    hCtx.drawImage(activeOverlayImg, 0, 0, hiresCanvas.width, hiresCanvas.height);
                }
            }

            // Draw branding text
            if (activeLayout === 'strip') {
                hCtx.fillStyle = 'rgba(0, 0, 0, 0.25)';
                hCtx.font = `italic bold ${14 * scale}px "Outfit"`;
                hCtx.textAlign = 'center';
                hCtx.fillText('• PHOTOBOX STUDIO •', hiresCanvas.width / 2, hiresCanvas.height - 40 * scale);
            }

            // Draw Custom Graphic Elements on Hires Canvas
            canvasElements.forEach((el) => {
                const scaledX = el.x * scale;
                const scaledY = el.y * scale;
                const scaledW = el.width * scale;
                const scaledH = el.height * scale;

                if (el.type === 'heart') {
                    drawHeart(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'star') {
                    drawStar(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'fish') {
                    drawFish(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'wave') {
                    drawWave(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'tree') {
                    drawTree(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'flower') {
                    drawFlower(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'cloud') {
                    drawCloud(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'sun') {
                    drawSun(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'pen') {
                    drawPen(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'pencil') {
                    drawPencil(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'apple') {
                    drawApple(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                } else if (el.type === 'birthday') {
                    drawBirthday(hCtx, scaledX, scaledY, scaledW, scaledH, el.flippedH);
                }
            });

            const base64Image = hiresCanvas.toDataURL('image/png');

            // Download locally
            const link = document.createElement('a');
            link.download = `photobox-creation-${Date.now()}.png`;
            link.href = base64Image;
            link.click();

            // Save to database via AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch("{{ route('creation.save') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    image: base64Image,
                    frame_id: activeFrameId,
                    metadata: JSON.stringify({
                        bg_color: activeBgColor,
                        layout: activeLayout,
                        filter: activeFilter
                    })
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    
                    if (!data.saved) {
                        // Guest user: skip local history display addition
                        return;
                    }
                    
                    // Dynamically append new card to gallery history
                    const grid = document.getElementById('creationsGrid');
                    const noCreations = document.getElementById('noCreationsPlaceholder');
                    if (noCreations) noCreations.remove();

                    const countVal = document.getElementById('creationsCount');
                    countVal.innerText = parseInt(countVal.innerText) + 1;

                    const newCard = document.createElement('div');
                    newCard.id = `creation-card-${data.creation.id}`;
                    newCard.className = 'relative group aspect-square rounded-xl overflow-hidden glass-panel border border-purple-100';
                    newCard.innerHTML = `
                        <img src="/${data.creation.image_path}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" alt="Creation">
                        <div class="absolute inset-0 bg-white/90 opacity-0 group-hover:opacity-100 flex flex-col justify-end p-2 transition-opacity space-y-1">
                            <button onclick="previewCreation('/${data.creation.image_path}')" class="w-full py-1 bg-purple-50 hover:bg-purple-100 text-center text-[10px] font-bold text-purple-700 border border-purple-100 rounded-lg transition-colors">
                                Zoom Preview
                            </button>
                            <div class="flex space-x-1">
                                <a href="/${data.creation.image_path}" download="photobox-${data.creation.id}.png" class="flex-1 py-1 bg-pink-300 hover:bg-pink-400 text-center text-[10px] font-bold text-white rounded-lg transition-colors shadow-sm">
                                    Save File
                                </a>
                                <button onclick="deleteCreation(${data.creation.id})" class="px-2 py-1 bg-red-50 hover:bg-red-100 border border-red-200 text-red-500 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                </button>
                            </div>
                        </div>
                    `;
                    grid.insertBefore(newCard, grid.firstChild);
                }
            })
            .catch(err => {
                showNotification("Could not sync creation with server.", "error");
            });
        }

        // AJAX: Submit custom frame
        function submitCustomFrame(event) {
            event.preventDefault();
            const form = document.getElementById('customFrameForm');
            const formData = new FormData(form);

            // Intercept layout type to pass backend validation
            const layoutType = formData.get('layout_type');
            if (layoutType === 'strip_3') {
                formData.set('layout_type', 'strip');
            } else if (layoutType === 'grid_6') {
                formData.set('layout_type', 'grid');
            }

            // Sync the active slots JSON data
            formData.set('slots', JSON.stringify(activeSlots));

            fetch("{{ route('frame.save') }}", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    if (document.getElementById('customFrameModal')) {
                        closeModal('customFrameModal');
                    }
                    form.reset();
                    
                    // If in custom creator mode, redirect back to custom dashboard
                    if (new URLSearchParams(window.location.search).get('action') === 'custom') {
                        setTimeout(() => {
                            window.location.href = "{{ route('studio.custom') }}";
                        }, 1200);
                        return;
                    }
                    
                    // Add new frame option to left sidebar
                    const container = document.getElementById('frameContainer');
                    const newFrame = data.frame;

                    const frameBtn = document.createElement('button');
                    frameBtn.className = 'frame-select-btn p-3 rounded-xl border text-left flex flex-col justify-between transition-all glass-panel glass-panel-hover border-purple-100/50';
                    frameBtn.setAttribute('onclick', `selectFrame(${newFrame.id}, '${newFrame.layout_type}', '${newFrame.bg_color}', '${newFrame.overlay_image}', ${JSON.stringify(newFrame.slots)})`);
                    frameBtn.setAttribute('data-frame-id', newFrame.id);
                    frameBtn.innerHTML = `
                        <div>
                            <div class="text-xs font-bold truncate text-purple-950">${newFrame.name}</div>
                            <div class="text-[10px] text-purple-500/70 uppercase mt-0.5 font-semibold">${newFrame.layout_type}</div>
                        </div>
                        <div class="flex justify-between items-center mt-3">
                            <span class="w-3 h-3 rounded-full border border-purple-100" style="background-color: ${newFrame.bg_color};"></span>
                            <button onclick="event.stopPropagation(); deleteFrame(${newFrame.id})" class="text-[10px] text-red-500 hover:text-red-600 font-semibold">
                                Delete
                            </button>
                        </div>
                    `;
                    container.insertBefore(frameBtn, container.firstChild);
                    
                    // Auto select the new frame
                    frameBtn.click();
                } else {
                    showNotification("Failed to create frame.", "error");
                }
            })
            .catch(err => {
                showNotification("Error uploading custom frame.", "error");
            });
        }

        // AJAX: Delete custom frame
        function deleteFrame(id) {
            if (!confirm("Are you sure you want to delete this custom frame?")) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/frame/delete/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    
                    // Remove button from DOM
                    const btn = document.querySelector(`[data-frame-id="${id}"]`);
                    if (btn) btn.remove();
                    
                    // Select default frame
                    const firstFrameBtn = document.querySelector('.frame-select-btn');
                    if (firstFrameBtn) {
                        firstFrameBtn.click();
                    } else {
                        resetCanvas();
                    }
                }
            })
            .catch(err => {
                showNotification("Error deleting frame.", "error");
            });
        }

        // AJAX: Delete creation
        function deleteCreation(id) {
            if (!confirm("Delete this creation from history?")) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/creation/delete/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    
                    // Remove card from DOM
                    const card = document.getElementById(`creation-card-${id}`);
                    if (card) card.remove();

                    // Adjust count indicator
                    const countVal = document.getElementById('creationsCount');
                    countVal.innerText = Math.max(0, parseInt(countVal.innerText) - 1);

                    if (parseInt(countVal.innerText) === 0) {
                        const grid = document.getElementById('creationsGrid');
                        grid.innerHTML = `
                            <div class="col-span-2 py-12 text-center text-xs text-gray-500" id="noCreationsPlaceholder">
                                No creations yet.<br>Take some photos!
                            </div>
                        `;
                    }
                }
            })
            .catch(err => {
                showNotification("Error deleting creation.", "error");
            });
        }

        // Preview creation image in full size
        function previewCreation(src) {
            const modal = document.getElementById('imagePreviewModal');
            const img = document.getElementById('modalPreviewImg');
            img.src = src;
            modal.classList.remove('hidden');
        }

        // Reset canvas slots
        function resetCanvas() {
            slotImages = {};
            drawCanvas();
        }

        // Custom frame modal (checks authentication)
        function openCustomFrameModal() {
            @auth
                openModal('customFrameModal');
            @else
                showNotification("Please sign in to create custom frames.", "error");
                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 1500);
            @endauth
        }

        // Custom choice handlers
        function chooseAmbilFoto() {
            closeModal('sourceModal');
            startAutoCapture(); // Triggers user camera permission request and countdown sequence
        }

        function choosePilihFile() {
            closeModal('sourceModal');
            // Trigger the bulk uploader hidden file input inside Section 3
            const fileInput = document.querySelector('input[type="file"][multiple]');
            if (fileInput) {
                fileInput.click();
            }
        }

        // Check if all slots are filled to enter results mode
        function checkAllSlotsFilled() {
            let allFilled = true;
            for (let i = 0; i < activeSlots.length; i++) {
                if (!slotImages[i]) {
                    allFilled = false;
                    break;
                }
            }
            if (allFilled) {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('frame_id')) {
                    setTimeout(() => {
                        enterResultsMode();
                    }, 800);
                }
            }
        }

        // Enter Booth Result Mode
        function enterResultsMode() {
            // Hide sidebars and toolbar
            document.getElementById('leftSidebar').style.display = 'none';
            document.getElementById('rightSidebar').style.display = 'none';
            document.getElementById('boothToolbar').classList.add('hidden');
            
            // Hide editor actions & drag instructions
            document.getElementById('editorActions').classList.add('hidden');
            const instructionOverlay = document.querySelector('.text-center.mt-4.mb-2');
            if (instructionOverlay) instructionOverlay.style.display = 'none';
            
            // Center canvas layout side-by-side with overlay selection panel (60% / 40% split)
            const center = document.getElementById('centerSandbox');
            center.classList.remove('lg:col-span-6', 'lg:col-span-8', 'lg:col-start-2', 'lg:col-start-3');
            center.classList.add('lg:col-span-7');
            
            // Show results actions
            document.getElementById('resultsActions').classList.remove('hidden');

            // Show results overlay panel (40% width)
            const overlayPanel = document.getElementById('resultsOverlayPanel');
            overlayPanel.classList.remove('hidden', 'lg:col-span-4');
            overlayPanel.classList.add('lg:col-span-5');

            // Hide header to maximize vertical screen space in Results Mode
            document.getElementById('appHeader').classList.add('hidden');
            document.getElementById('appMain').classList.remove('hidden');

            // Scale up canvas display size for high visual impact
            const canvasEl = document.getElementById('photoboxCanvas');
            canvasEl.style.maxHeight = '74vh';
            
            const wrapperEl = document.getElementById('canvasWrapper');
            wrapperEl.style.maxWidth = '540px';
            wrapperEl.style.maxHeight = '76vh';
            
            // Reset overlay highlight state to 'None'
            document.querySelectorAll('.overlay-select-btn').forEach(btn => {
                btn.classList.remove('border-pink-300', 'bg-pink-50/50');
            });
            const defaultOverlayBtn = document.querySelector('.overlay-select-btn');
            if (defaultOverlayBtn) {
                defaultOverlayBtn.classList.add('border-pink-300', 'bg-pink-50/50');
            }
            activeOverlayImg = null;
            activeOverlaySrc = null;
            drawCanvas();

            // Destroy FOUC preventer style block
            const foucStyle = document.getElementById('foucPreventer');
            if (foucStyle) {
                foucStyle.remove();
            }
        }

        // Retake/restart the session
        function retakeSession() {
            // Restore default max heights for editor/booth mode
            const canvasEl = document.getElementById('photoboxCanvas');
            canvasEl.style.maxHeight = '';
            
            const wrapperEl = document.getElementById('canvasWrapper');
            wrapperEl.style.maxWidth = '';
            wrapperEl.style.maxHeight = '';

            // Restore canvas center column sizes
            const center = document.getElementById('centerSandbox');
            center.classList.remove('lg:col-span-7', 'lg:col-span-8', 'lg:col-start-2', 'lg:col-start-3');
            center.classList.add('lg:col-span-8', 'lg:col-start-3');

            // Hide results overlay panel
            const overlayPanel = document.getElementById('resultsOverlayPanel');
            overlayPanel.classList.add('hidden');
            overlayPanel.classList.remove('lg:col-span-5');

            // Reset canvas
            resetCanvas();
            
            // Re-show editor layout actions for booth mode in case
            document.getElementById('editorActions').classList.remove('hidden');
            const instructionOverlay = document.querySelector('.text-center.mt-4.mb-2');
            if (instructionOverlay) instructionOverlay.style.display = 'block';
            
            // Hide Results Actions
            document.getElementById('resultsActions').classList.add('hidden');
            
            // Re-show booth toolbar
            document.getElementById('boothToolbar').classList.remove('hidden');
            
            // Open camera and start again!
            startAutoCapture();
        }

        // Trigger download
        function downloadResult() {
            saveAndCompileCreation();
        }

        // Key out pure white inside overlay template slots so photos show behind but stickers stay on top
        let processedOverlayCanvas = null;

        function detectSlotsFromOverlay(img) {
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = canvasWidth;
            tempCanvas.height = canvasHeight;
            const tempCtx = tempCanvas.getContext('2d');
            tempCtx.drawImage(img, 0, 0, canvasWidth, canvasHeight);
            
            const imgData = tempCtx.getImageData(0, 0, canvasWidth, canvasHeight);
            const data = imgData.data;

            // 1. Sample target color at center of first slot
            const cx = activeSlots[0] ? Math.floor(activeSlots[0].x + activeSlots[0].width/2) : 200;
            const cy = activeSlots[0] ? Math.floor(activeSlots[0].y + activeSlots[0].height/2) : 170;
            const idx = (cy * canvasWidth + cx) * 4;
            const target = { r: data[idx], g: data[idx+1], b: data[idx+2] };

            function matchesTarget(r, g, b) {
                return Math.abs(r - target.r) < 8 && 
                       Math.abs(g - target.g) < 8 && 
                       Math.abs(b - target.b) < 8;
            }

            // 2. Scan columns to find slot horizontal range
            let minX = canvasWidth;
            let maxX = 0;
            for (let x = 0; x < canvasWidth; x++) {
                let matchCount = 0;
                for (let y = 0; y < canvasHeight; y++) {
                    const i = (y * canvasWidth + x) * 4;
                    if (matchesTarget(data[i], data[i+1], data[i+2])) {
                        matchCount++;
                    }
                }
                if (matchCount > 100) {
                    if (x < minX) minX = x;
                    if (x > maxX) maxX = x;
                }
            }

            if (minX >= maxX) return;

            const slotX = minX;
            const slotWidth = maxX - minX + 1;
            const centerColX = Math.floor((minX + maxX) / 2);

            // 3. Scan vertically to detect Y ranges
            const detectedYRanges = [];
            let inSlot = false;
            let startY = 0;

            for (let y = 0; y < canvasHeight; y++) {
                const i = (y * canvasWidth + centerColX) * 4;
                const isMatch = matchesTarget(data[i], data[i+1], data[i+2]);

                if (isMatch && !inSlot) {
                    inSlot = true;
                    startY = y;
                } else if (!isMatch && inSlot) {
                    inSlot = false;
                    const height = y - startY;
                    if (height > 50) {
                        detectedYRanges.push({ y: startY, height: height });
                    }
                }
            }
            if (inSlot) {
                const height = canvasHeight - startY;
                if (height > 50) {
                    detectedYRanges.push({ y: startY, height: height });
                }
            }

            // Update slot boundaries dynamically if detected slot count matches current layout expectation
            if (detectedYRanges.length === activeSlots.length) {
                activeSlots = detectedYRanges.map(range => ({
                    x: slotX,
                    y: range.y,
                    width: slotWidth,
                    height: range.height
                }));
                
                // Recalculate zoom factors for all existing photos to prevent border gaps
                activeSlots.forEach((slot, index) => {
                    if (slotImages[index]) {
                        const imgEl = slotImages[index].img;
                        slotImages[index].zoom = Math.max(slot.width / imgEl.width, slot.height / imgEl.height);
                    }
                });
            }
        }

        function processOverlayImage(img) {
            // Adjust slot boundaries to fit the template file perfectly before processing
            detectSlotsFromOverlay(img);

            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = canvasWidth;
            tempCanvas.height = canvasHeight;
            const tempCtx = tempCanvas.getContext('2d');
            
            // Draw original stretched
            tempCtx.drawImage(img, 0, 0, canvasWidth, canvasHeight);
            
            const imgData = tempCtx.getImageData(0, 0, tempCanvas.width, tempCanvas.height);
            const data = imgData.data;
            
            // Clone original pixel data to read the target center colors safely
            const originalData = new Uint8ClampedArray(data);
            
            // Pre-calculate target colors for each slot to optimize loop performance
            const slotTargetColors = activeSlots.map(slot => {
                const cx = Math.floor(slot.x + slot.width / 2);
                const cy = Math.floor(slot.y + slot.height / 2);
                const idx = (cy * canvasWidth + cx) * 4;
                return {
                    r: originalData[idx],
                    g: originalData[idx+1],
                    b: originalData[idx+2]
                };
            });
            
            // Chroma key out only the exact slot background color inside slot boundaries
            for (let i = 0; i < data.length; i += 4) {
                const pixelIndex = i / 4;
                const x = pixelIndex % canvasWidth;
                const y = Math.floor(pixelIndex / canvasWidth);
                
                // Find if pixel is inside a slot, and get its index
                const slotIdx = activeSlots.findIndex(slot => 
                    x >= slot.x && x < (slot.x + slot.width) &&
                    y >= slot.y && y < (slot.y + slot.height)
                );
                
                if (slotIdx !== -1) {
                    const target = slotTargetColors[slotIdx];
                    const r = data[i];
                    const g = data[i+1];
                    const b = data[i+2];
                    
                    // Match with a very small tolerance to handle lossy compression artifacts
                    const matches = Math.abs(r - target.r) < 5 && 
                                    Math.abs(g - target.g) < 5 && 
                                    Math.abs(b - target.b) < 5;
                                    
                    if (matches) {
                        data[i+3] = 0; // set alpha channel to 0 (transparent)
                    }
                }
            }
            
            tempCtx.putImageData(imgData, 0, 0);
            processedOverlayCanvas = tempCanvas;
        }

        // Apply selected frame design overlay in Results Mode
        function selectResultsOverlay(overlayPath) {
            // Highlight selected button
            document.querySelectorAll('.overlay-select-btn').forEach(btn => {
                btn.classList.remove('border-pink-300', 'bg-pink-50/50');
            });
            
            // Find clicked button
            const eventTarget = window.event ? window.event.currentTarget : null;
            if (eventTarget) {
                eventTarget.classList.add('border-pink-300', 'bg-pink-50/50');
            }

            activeOverlayImg = null;
            activeOverlaySrc = overlayPath;
            processedOverlayCanvas = null;
            
            if (overlayPath) {
                const img = new Image();
                img.onload = () => {
                    activeOverlayImg = img;
                    processOverlayImage(img);
                    drawCanvas();
                    showNotification("Frame overlay applied!");
                };
                img.src = '/' + overlayPath;
            } else {
                drawCanvas();
                showNotification("Background set to plain solid color");
            }
        }
    </script>

</body>
</html>
