@extends('layouts.dashboard')

@section('content')
<div class="space-y-8 animate-fadeIn">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="space-y-1">
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline">← Back to Dashboard</a>
            <h1 class="text-3xl font-black font-outfit text-purple-950 mt-2">Template Designs</h1>
            <p class="text-sm text-purple-500 font-medium">
                Manage overlay borders and custom stickers designs displayed on the right sidebar of the capture studio.
            </p>
        </div>
        
        <!-- Add Template Button -->
        <button onclick="openAddTemplateModal()" class="px-5 py-3 bg-gradient-to-tr from-pink-400 to-purple-400 hover:from-pink-500 hover:to-purple-500 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Add New Template</span>
        </button>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2 shadow-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1 shadow-sm">
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Templates Table Panel -->
    <div class="glass-panel rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-purple-100 bg-purple-50/30 text-xs font-bold uppercase tracking-wider text-purple-900/70">
                        <th class="p-4 pl-6 w-16">ID</th>
                        <th class="p-4 w-32">Preview</th>
                        <th class="p-4">Template Name</th>
                        <th class="p-4">Layout Category</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Created Date</th>
                        <th class="p-4 pr-6 text-right w-36">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-50/50 text-sm font-semibold text-slate-700">
                    @forelse($templates as $tpl)
                        <tr class="hover:bg-purple-50/20 transition-colors">
                            <td class="p-4 pl-6 font-bold text-purple-400">#{{ $tpl->id }}</td>
                            <td class="p-4">
                                <div class="w-16 h-20 bg-purple-950/5 border border-purple-100 rounded-xl overflow-hidden flex items-center justify-center p-1.5 backdrop-blur-sm">
                                    <img src="{{ asset($tpl->image_path) }}" class="max-w-full max-h-full object-contain drop-shadow">
                                </div>
                            </td>
                            <td class="p-4 font-bold text-purple-950 text-sm">
                                {{ $tpl->name }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] uppercase font-bold tracking-wider bg-pink-100 text-pink-700">
                                    {{ $tpl->category ? $tpl->category->name : 'Unassigned' }}
                                </span>
                            </td>
                            <td class="p-4 text-xs font-medium text-slate-400 max-w-xs truncate" title="{{ $tpl->description }}">
                                {{ $tpl->description ?? '-' }}
                            </td>
                            <td class="p-4 text-slate-400 font-medium">{{ $tpl->created_at->format('M d, Y H:i') }}</td>
                            <td class="p-4 pr-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Edit Button -->
                                    <button onclick="openEditTemplateModal({{ $tpl->id }}, '{{ addslashes($tpl->name) }}', {{ $tpl->category_id ?? 'null' }}, '{{ addslashes($tpl->description ?? '') }}', '{{ $tpl->image_path }}')" class="px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-700 font-bold text-xs rounded-lg transition-colors">
                                        Edit
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('dashboard.templates.delete', $tpl->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete overlay template {{ $tpl->name }}? This will move it to the trash bin.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-lg transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 font-semibold">
                                No overlay design templates found. Click "Add New Template" to upload one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($templates->hasPages())
            <div class="p-4 border-t border-purple-50 bg-white/30">
                {{ $templates->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal: Add Template -->
<div id="addTemplateModal" class="fixed inset-0 bg-purple-950/40 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="glass-panel w-full max-w-md p-6 md:p-8 rounded-3xl space-y-6 shadow-2xl relative m-4 transform scale-95 transition-transform duration-300">
        <!-- Close Button -->
        <button onclick="closeModal('addTemplateModal')" class="absolute top-4 right-4 text-purple-400 hover:text-purple-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="space-y-1">
            <h3 class="text-xl font-black font-outfit text-purple-950">Add Overlay Template</h3>
            <p class="text-xs text-purple-500 font-semibold">Upload a custom frame design overlay to apply on completed capture strips.</p>
        </div>

        <form action="{{ route('dashboard.templates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Template Name</label>
                <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold" placeholder="e.g. Vintage Heart Border">
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Layout Category</label>
                <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold bg-white">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Description (Optional)</label>
                <textarea name="description" rows="2" class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold" placeholder="Brief details about the template theme..."></textarea>
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Transparent PNG / SVG Overlay File</label>
                <input type="file" name="image_file" required accept="image/png,image/svg+xml" class="w-full text-xs text-purple-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer">
                <span class="text-[9px] text-purple-500/80 block mt-1 leading-relaxed">
                    Note: File must be transparent in center slot regions. Recommended sizes: 1000x1200 (for grid) or 400x1200 (for strip).
                </span>
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-tr from-pink-400 to-purple-400 text-white font-black text-xs rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all mt-2">
                Upload Frame Template
            </button>
        </form>
    </div>
</div>

<!-- Modal: Edit Template -->
<div id="editTemplateModal" class="fixed inset-0 bg-purple-950/40 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="glass-panel w-full max-w-md p-6 md:p-8 rounded-3xl space-y-6 shadow-2xl relative m-4 transform scale-95 transition-transform duration-300">
        <!-- Close Button -->
        <button onclick="closeModal('editTemplateModal')" class="absolute top-4 right-4 text-purple-400 hover:text-purple-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="space-y-1">
            <h3 class="text-xl font-black font-outfit text-purple-950">Edit Overlay Template</h3>
            <p class="text-xs text-purple-500 font-semibold">Modify configuration details or replace the design file of this template.</p>
        </div>

        <form id="editTemplateForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Template Name</label>
                <input type="text" name="name" id="edit_name" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold">
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Layout Category</label>
                <select name="category_id" id="edit_category_id" required class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold bg-white">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Description (Optional)</label>
                <textarea name="description" id="edit_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border-2 border-purple-100 focus:outline-none focus:border-pink-300 text-sm font-semibold"></textarea>
            </div>

            <div class="space-y-3">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Current Design Preview</label>
                <div class="w-20 h-28 bg-purple-950/5 border border-purple-100 rounded-xl overflow-hidden flex items-center justify-center p-2">
                    <img id="edit_preview" src="" class="max-w-full max-h-full object-contain drop-shadow">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Replace PNG / SVG File (Optional)</label>
                <input type="file" name="image_file" accept="image/png,image/svg+xml" class="w-full text-xs text-purple-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer">
                <span class="text-[9px] text-purple-500/80 block mt-1 leading-relaxed">
                    Leave blank to keep the current transparent file design.
                </span>
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-tr from-pink-400 to-purple-400 text-white font-black text-xs rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all mt-2">
                Save Changes
            </button>
        </form>
    </div>
</div>

<script>
    function openAddTemplateModal() {
        const modal = document.getElementById('addTemplateModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    }

    function openEditTemplateModal(id, name, categoryId, description, imagePath) {
        // Populate inputs
        document.getElementById('editTemplateForm').action = `/dashboard/templates/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_category_id').value = categoryId;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_preview').src = `/${imagePath}`;

        const modal = document.getElementById('editTemplateModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('opacity-0');
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
