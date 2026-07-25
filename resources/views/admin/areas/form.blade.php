@extends('backend.layout')
@section('title', ($area->exists ? 'Edit' : 'Tambah') . ' Area — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $area->exists ? 'Edit Area' : 'Tambah Area Baru' }}</h1>
    <a href="{{ route('admin.areas.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
        Kembali
    </a>
</div>

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 text-sm font-bold">
        Terdapat beberapa kesalahan:
        <ul class="list-disc pl-5 mt-2 font-normal">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $area->exists ? route('admin.areas.update', $area) : route('admin.areas.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6 max-w-2xl">
    @csrf
    @if($area->exists)
        @method('PUT')
    @endif

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Foto Area / Banner</label>
        <style>
            .area-dropzone { height: 12rem; border: 2px dashed #d1d5db; border-radius: 0.75rem; transition: all 0.3s; }
            .area-dropzone:hover, .area-dropzone.is-active { border-color: #0057ff; background-color: #eff6ff; }
        </style>
        <div class="relative w-full overflow-hidden group cursor-pointer area-dropzone" id="dropzone">
            <!-- Upload Input (Hidden) -->
            <input type="file" name="image_path" id="file-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
            
            <!-- Default Placeholder -->
            <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center pointer-events-none transition-opacity duration-300" id="upload-placeholder" style="{{ $area->image_path ? 'opacity: 0;' : 'opacity: 1;' }}">
                <svg class="w-10 h-10 text-gray-400 mb-3 group-hover:text-brand-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <p class="text-[13px] font-bold text-gray-600">Drag and drop gambar ke sini, atau <span class="text-brand-blue">Pilih File</span></p>
                <p class="text-[11px] font-semibold text-gray-400 mt-1">Mendukung: JPG, PNG, WEBP (Maks: 2MB)</p>
            </div>

            <!-- Preview Image -->
            <div class="absolute inset-0 pointer-events-none transition-opacity duration-300 bg-black/5" id="image-preview-container" style="{{ $area->image_path ? 'opacity: 1;' : 'opacity: 0;' }}">
                <img src="{{ $area->image_path ? asset('storage/' . $area->image_path) : '' }}" id="image-preview" class="w-full h-full object-cover" alt="Preview">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                    <span class="text-white text-sm font-bold bg-black/50 px-4 py-2 rounded-lg">Klik untuk mengubah gambar</span>
                </div>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Nama Area</label>
        <input type="text" name="name" value="{{ old('name', $area->name) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Kota</label>
        <input type="text" name="city" value="{{ old('city', $area->city) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Jumlah Properti (Opsional)</label>
        <input type="number" name="property_count" value="{{ old('property_count', $area->property_count) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" min="0">
    </div>

    <div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $area->is_popular) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
            <span class="text-sm font-bold text-brand-navy">Tandai sebagai Area Populer</span>
        </label>
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Area
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-input');
        const dropzone = document.getElementById('dropzone');
        const placeholder = document.getElementById('upload-placeholder');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');

        // Drag and drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.add('is-active');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.remove('is-active');
            }, false);
        });

        dropzone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            let dt = e.dataTransfer;
            let files = dt.files;
            
            if (files.length > 0) {
                fileInput.files = files; // Assign files to input
                handleFiles(files);
            }
        }

        // Click event handled by native file input
        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                handleFiles(this.files);
            }
        });

        function handleFiles(files) {
            const file = files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    placeholder.style.opacity = '0';
                    previewContainer.style.opacity = '1';
                }
                reader.readAsDataURL(file);
            }
        }
    });
</script>
@endpush
@endsection
