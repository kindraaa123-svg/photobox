@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fadeIn">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-purple-100/60 pb-6">
        <div class="space-y-1">
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline">← Back to Dashboard</a>
            <h1 class="text-3xl font-black font-outfit text-purple-950 mt-2">{{ $category->name }} Templates</h1>
            <p class="text-sm text-purple-500 font-medium">
                Choose a custom frame design overlay below to start your photo booth capture session.
            </p>
        </div>

        <!-- Take Photo Without Overlay Button -->
        <button onclick="openActionModal('Plain {{ addslashes($category->name) }}', '{{ $category->slug }}', null)" class="px-5 py-3 bg-gradient-to-tr from-pink-400 to-purple-400 hover:from-pink-500 hover:to-purple-500 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
            </svg>
            <span>Use Plain Layout</span>
        </button>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($overlays as $overlay)
            <div class="glass-panel p-5 rounded-3xl text-center space-y-4 hover:border-pink-300 hover:shadow-md transition-all flex flex-col justify-between bg-white/70">
                <div class="space-y-3">
                    <!-- Overlay Preview Display -->
                    <div class="mx-auto bg-purple-950/5 border border-purple-100 rounded-2xl flex items-center justify-center p-3 relative overflow-hidden backdrop-blur-sm {{
                        $category->slug === 'strip' || $category->slug === 'strip_3' ? 'w-28 h-56' : 'w-44 h-44'
                    }}">
                        <!-- Simulated Pastel Background behind transparent slots -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-pink-50 to-purple-50 z-0"></div>
                        <img src="{{ asset($overlay->image_path) }}" class="max-w-full max-h-full object-contain drop-shadow-md z-10 relative">
                    </div>

                    <h4 class="text-md font-extrabold text-purple-950 mt-4">{{ $overlay->name }}</h4>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">
                        {{ $overlay->description ?? 'Beautiful overlay border design.' }}
                    </p>
                </div>
                
                <!-- Action Button -->
                <button onclick="openActionModal('{{ addslashes($overlay->name) }}', '{{ $category->slug }}', {{ $overlay->id }})" class="mt-4 w-full px-4 py-3 bg-pink-400 hover:bg-pink-500 text-white font-black text-xs rounded-xl shadow-md transition-all">
                    Take Photo
                </button>
            </div>
        @empty
            <div class="col-span-full py-16 text-center space-y-4">
                <div class="inline-flex w-16 h-16 rounded-full bg-purple-50 items-center justify-center text-purple-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-purple-950">No custom overlays yet</h3>
                <p class="text-xs text-purple-500 max-w-sm mx-auto font-medium leading-relaxed">
                    There are no custom template overlay borders uploaded for this category yet. You can still use the plain layout to take photos.
                </p>
                <div class="pt-2">
                    <button onclick="openActionModal('Plain {{ addslashes($category->name) }}', '{{ $category->slug }}', null)" class="inline-flex items-center space-x-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                        <span>Use Plain Layout</span>
                    </button>
                </div>
            </div>
        @endforelse
    </div>

</div>

<!-- Modal: Choose Action -->
<div id="chooseActionModal" class="fixed inset-0 bg-purple-950/40 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="glass-panel w-full max-w-md p-8 rounded-[2.5rem] space-y-6 shadow-2xl relative m-4 transform scale-95 transition-transform duration-300 text-center bg-white/95">
        <!-- Close Button -->
        <button onclick="closeActionModal()" class="absolute top-5 right-5 text-purple-400 hover:text-purple-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="space-y-2">
            <h3 class="text-2xl font-black font-outfit text-purple-950" id="modalTemplateName">Start Photo Session</h3>
            <p class="text-xs text-purple-500 font-semibold">Choose how you want to add photos to this frame template.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 pt-2">
            <!-- Capture Live Webcam -->
            <a id="captureLink" href="#" class="flex flex-col items-center justify-center p-6 bg-gradient-to-tr from-pink-50 to-pink-100 hover:from-pink-100/80 hover:to-pink-200/80 border-2 border-pink-200/50 rounded-3xl transition-all shadow-sm hover:shadow group text-slate-700">
                <div class="w-12 h-12 rounded-full bg-pink-500 text-white flex items-center justify-center mb-3 shadow-md group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </div>
                <span class="text-sm font-black text-pink-700">Take Photo Now</span>
                <span class="text-[10px] text-pink-500 font-semibold mt-1">Capture live poses with your device camera</span>
            </a>

            <!-- Upload File -->
            <a id="uploadLink" href="#" class="flex flex-col items-center justify-center p-6 bg-gradient-to-tr from-purple-50 to-purple-100 hover:from-purple-100/80 hover:to-purple-200/80 border-2 border-purple-200/50 rounded-3xl transition-all shadow-sm hover:shadow group text-slate-700">
                <div class="w-12 h-12 rounded-full bg-purple-600 text-white flex items-center justify-center mb-3 shadow-md group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h10a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                    </svg>
                </div>
                <span class="text-sm font-black text-purple-700">Import from Gallery / Files</span>
                <span class="text-[10px] text-purple-500 font-semibold mt-1">Upload existing PNG or JPG images from your files</span>
            </a>
        </div>
    </div>
</div>

<script>
    function openActionModal(templateName, categorySlug, overlayId) {
        document.getElementById('modalTemplateName').innerText = templateName;
        
        let captureUrl = `/studio?layout=${categorySlug}&action=capture`;
        let uploadUrl = `/studio?layout=${categorySlug}&action=upload`;
        if (overlayId) {
            captureUrl += `&overlay_id=${overlayId}`;
            uploadUrl += `&overlay_id=${overlayId}`;
        }
        
        document.getElementById('captureLink').href = captureUrl;
        document.getElementById('uploadLink').href = uploadUrl;

        const modal = document.getElementById('chooseActionModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    }

    function closeActionModal() {
        const modal = document.getElementById('chooseActionModal');
        modal.classList.add('opacity-0');
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
