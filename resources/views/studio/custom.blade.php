@extends('layouts.dashboard')

@section('content')
<div class="space-y-8 animate-fadeIn">
    
    <!-- Header with Dropdown Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-purple-100">
        <div class="space-y-1">
            <h1 class="text-3xl font-black font-outfit text-purple-950">Custom Templates & Results</h1>
            <p class="text-sm text-purple-500 font-medium">
                Create new custom templates, import existing photo captures, or review your active draft designs.
            </p>
        </div>

        <!-- Add Button with Dropdown -->
        <div class="relative shrink-0" id="addTemplateDropdown">
            <button onclick="toggleAddDropdown()" class="inline-flex items-center space-x-2 px-6 py-3.5 bg-gradient-to-tr from-pink-400 to-purple-400 text-white font-black text-sm rounded-2xl shadow-lg shadow-pink-300/40 hover:shadow-xl hover:shadow-pink-300/50 transform hover:-translate-y-0.5 transition-all focus:outline-none">
                <span>+ Tambah</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="addDropdownMenu" class="hidden absolute right-0 mt-2 w-56 rounded-2xl bg-white border border-purple-100 shadow-xl p-2 z-50 animate-fadeIn">
                <!-- Import from Gallery option -->
                <button onclick="triggerFileSelect()" class="w-full text-left flex items-center space-x-2 px-4 py-3 text-sm font-semibold text-slate-700 rounded-xl hover:bg-purple-50 hover:text-purple-950 transition-colors">
                    <span class="text-lg"></span>
                    <div>
                        <div class="font-bold">Import from Gallery</div>
                        <div class="text-[10px] text-slate-400 font-medium">Upload completed photo</div>
                    </div>
                </button>
                
                <!-- Canva Custom template option -->
                <a href="{{ route('workspace', ['action' => 'custom']) }}" class="w-full text-left flex items-center space-x-2 px-4 py-3 text-sm font-semibold text-pink-600 rounded-xl hover:bg-pink-50 transition-colors mt-1">
                    <span class="text-lg"></span>
                    <div>
                        <div class="font-black">Create Custom</div>
                        <div class="text-[10px] text-pink-400 font-bold">Design in Studio Sandbox</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Gallery Import -->
    <form id="galleryImportForm" action="{{ route('studio.custom.upload') }}" method="POST" enctype="multipart/form-data" class="hidden">
        @csrf
        <input type="file" id="imageFileInput" name="image_file" accept="image/*" onchange="submitGalleryImport()">
    </form>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Left: Draft Templates -->
        <div class="space-y-4">
            <h2 class="text-lg font-black font-outfit text-purple-950 flex items-center space-x-2">
                <span>Draft Templates</span>
                <span class="px-2.5 py-0.5 rounded-md bg-purple-100 text-purple-700 text-[10px] font-bold uppercase tracking-wider">{{ $drafts->count() }} Drafts</span>
            </h2>
            
            @if($drafts->isEmpty())
                <div class="glass-panel rounded-3xl p-10 text-center text-slate-400 flex flex-col items-center justify-center space-y-3 bg-white/70">
                    <span class="text-4xl"></span>
                    <p class="text-sm font-bold text-slate-500">No draft templates created yet.</p>
                    <a href="{{ route('workspace', ['action' => 'custom']) }}" class="px-4 py-2 bg-purple-50 text-purple-700 text-xs font-bold rounded-xl hover:bg-purple-100 transition-colors">Start Canvas Builder</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($drafts as $draft)
                        <div class="glass-panel rounded-2xl p-4 flex flex-col justify-between space-y-4 hover:shadow-md transition-all bg-white/70">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-0.5 rounded-full bg-pink-100 border border-pink-200 text-pink-700 text-[9px] font-black uppercase tracking-wider">{{ $draft->layout_type }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold">{{ $draft->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="text-sm font-black text-purple-950 truncate" title="{{ $draft->name }}">{{ $draft->name }}</h3>
                                <div class="flex items-center space-x-2">
                                    <span class="w-3.5 h-3.5 rounded border border-slate-200 block shrink-0" style="background-color: {{ $draft->bg_color }}"></span>
                                    <span class="text-[10px] font-mono text-slate-400 uppercase">{{ $draft->bg_color }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 pt-2 border-t border-purple-50/50">
                                <a href="{{ route('workspace', ['frame_id' => $draft->id]) }}" class="flex-1 text-center py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-xs font-bold rounded-xl transition-colors">
                                    Open Studio
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Completed Templates (Template Jadi) -->
        <div class="space-y-4">
            <h2 class="text-lg font-black font-outfit text-purple-950 flex items-center space-x-2">
                <span>Completed Templates</span>
                <span class="px-2.5 py-0.5 rounded-md bg-pink-100 text-pink-700 text-[10px] font-bold uppercase tracking-wider">{{ $completed->count() }} Templates</span>
            </h2>

            @if($completed->isEmpty())
                <div class="glass-panel rounded-3xl p-10 text-center text-slate-400 flex flex-col items-center justify-center space-y-3 bg-white/70">
                    <span class="text-4xl"></span>
                    <p class="text-sm font-bold text-slate-500">No completed templates available.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($completed as $tpl)
                        <div class="glass-panel rounded-2xl p-4 flex flex-col justify-between space-y-4 hover:shadow-md transition-all bg-white/70">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-0.5 rounded-full bg-purple-100 border border-purple-200 text-purple-700 text-[9px] font-black uppercase tracking-wider">{{ $tpl->layout_type }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold">Active Design</span>
                                </div>
                                <h3 class="text-sm font-black text-purple-950 truncate" title="{{ $tpl->name }}">{{ $tpl->name }}</h3>
                                <div class="flex items-center space-x-2">
                                    <span class="w-3.5 h-3.5 rounded border border-slate-200 block shrink-0" style="background-color: {{ $tpl->bg_color }}"></span>
                                    <span class="text-[10px] font-mono text-slate-400 uppercase">{{ $tpl->bg_color }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 pt-2 border-t border-purple-50/50">
                                <a href="{{ route('workspace', ['frame_id' => $tpl->id]) }}" class="flex-1 text-center py-2 bg-pink-50 hover:bg-pink-100 text-pink-700 text-xs font-bold rounded-xl transition-colors">
                                    Use Template
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>

<!-- Dropdown Scripts -->
<script>
    function toggleAddDropdown() {
        const menu = document.getElementById('addDropdownMenu');
        menu.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('addTemplateDropdown');
        const menu = document.getElementById('addDropdownMenu');
        if (dropdown && !dropdown.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });

    function triggerFileSelect() {
        document.getElementById('imageFileInput').click();
    }

    function submitGalleryImport() {
        const input = document.getElementById('imageFileInput');
        if (input.files && input.files.length > 0) {
            document.getElementById('galleryImportForm').submit();
        }
    }
</script>
@endsection
