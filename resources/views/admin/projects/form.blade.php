@extends('backend.layout')
@section('title', ($project->exists ? 'Edit' : 'Tambah') . ' Project — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $project->exists ? 'Edit Project' : 'Tambah Project Baru' }}</h1>
    <a href="{{ route('admin.projects.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($project->exists)
        @method('PUT')
    @endif

    <div class="bg-white border border-brand-line rounded-2xl p-6 grid grid-cols-2 gap-6">
        <h2 class="col-span-2 text-brand-navy font-black text-[18px]">Informasi Umum</h2>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Nama Project</label>
            <input type="text" name="name" value="{{ old('name', $project->name) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Developer</label>
            <select name="developer_id" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
                <option value="">-- Pilih Developer --</option>
                @foreach($developers as $dev)
                    <option value="{{ $dev->id }}" {{ old('developer_id', $project->developer_id) == $dev->id ? 'selected' : '' }}>{{ $dev->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Area</label>
            <select name="area_id" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
                <option value="">-- Pilih Area --</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id', $project->area_id) == $area->id ? 'selected' : '' }}>{{ $area->name }} ({{ $area->city }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Tipe Properti</label>
            <select name="property_type_id" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
                <option value="">-- Boleh Dikosongkan --</option>
                @foreach($propertyTypes as $pt)
                    <option value="{{ $pt->id }}" {{ old('property_type_id', $project->property_type_id) == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Status Penjualan</label>
            <select name="status" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
                @foreach(['Launching', 'Premium', 'New Cluster', 'Sold Out'] as $status)
                    <option value="{{ $status }}" {{ old('status', $project->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Harga Mulai (Rp)</label>
            <input type="number" name="price_from" value="{{ old('price_from', $project->price_from) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="0">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Unit Tersedia</label>
            <input type="text" name="units_available" value="{{ old('units_available', $project->units_available) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" placeholder="Contoh: 15 Unit, Sisa 2, dll">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Tampilkan di Website</label>
            <label class="custom-toggle mt-2">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $project->is_published ?? true) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <span class="ml-3 text-sm font-bold text-gray-700 align-top leading-6">Publish</span>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Urutan Tampil (Sort Order)</label>
            <div class="flex items-center gap-2">
                <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-10 h-10 flex items-center justify-center border border-brand-line rounded-lg bg-gray-50 hover:bg-gray-100 font-bold text-gray-600 focus:outline-none transition-colors">-</button>
                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" class="w-20 text-center border border-brand-line rounded-lg h-10 focus:ring-brand-blue hide-arrows" required>
                <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-10 h-10 flex items-center justify-center border border-brand-line rounded-lg bg-gray-50 hover:bg-gray-100 font-bold text-gray-600 focus:outline-none transition-colors">+</button>
            </div>
            <div class="text-[11px] text-[#7a8399] mt-1">Angka lebih kecil tampil lebih dulu.</div>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Deskripsi Lengkap</label>
            <textarea id="editor-description" name="description" rows="5" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="col-span-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
                <span class="text-sm font-bold text-brand-navy">Tampilkan sebagai Project Unggulan (Featured)</span>
            </label>
        </div>
    </div>

    <div class="bg-white border border-brand-line rounded-2xl p-6 grid grid-cols-1 gap-6">
        <h2 class="text-brand-navy font-black text-[18px]">Media & Gambar</h2>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Cover Image (Gambar Utama)</label>
            <div id="dropzone-cover" class="relative w-full border-2 border-dashed border-brand-line rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer hover:border-brand-blue hover:bg-blue-50/50 transition-all bg-gray-50 overflow-hidden group">
                <input type="file" id="cover_image_input" name="cover_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                
                <div id="cover-placeholder" class="flex flex-col items-center {{ $project->exists && $project->cover_image ? 'hidden' : '' }}">
                    <div class="text-brand-blue mb-3 bg-white p-3 rounded-full shadow-sm border border-brand-line">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-[13px] font-bold text-brand-navy mb-1"><span class="text-brand-blue underline">Pilih file</span> atau tarik dan lepas di sini</p>
                    <p class="text-[11px] text-[#7a8399]">PNG, JPG, JPEG (Maks. 2MB)</p>
                </div>
                
                <div id="cover-preview-container" class="w-full relative aspect-[2/1] rounded-lg overflow-hidden border border-brand-line {{ $project->exists && $project->cover_image ? '' : 'hidden' }}">
                    <img id="cover-preview-img" src="{{ $project->exists && $project->cover_image ? asset('storage/'.$project->cover_image) : '' }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <span class="text-white text-xs font-bold bg-black/60 px-3 py-1.5 rounded-md flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Ganti Gambar
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-xs text-gray-500 mt-2">Maksimal 2MB. Kosongkan jika tidak ingin mengubah (saat edit).</div>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Upload Gallery Images Baru (Bisa pilih lebih dari satu)</label>
            <div id="dropzone-gallery" class="relative w-full border-2 border-dashed border-brand-line rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer hover:border-brand-blue hover:bg-blue-50/50 transition-all bg-gray-50 min-h-[160px]">
                <input type="file" id="gallery_images_input" name="images[]" accept="image/*" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                
                <div id="gallery-placeholder" class="flex flex-col items-center pointer-events-none">
                    <div class="text-brand-blue mb-3 bg-white p-3 rounded-full shadow-sm border border-brand-line">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <p class="text-[13px] font-bold text-brand-navy mb-1"><span class="text-brand-blue underline">Pilih beberapa file</span> atau tarik dan lepas di sini</p>
                    <p class="text-[11px] text-[#7a8399]">PNG, JPG, JPEG (Maks. 2MB per gambar)</p>
                </div>
                
                <div id="gallery-preview-container" class="w-full hidden grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3 mt-4 relative z-10 pointer-events-none">
                    <!-- Previews injected via JS -->
                </div>
            </div>
            <div class="text-xs text-gray-500 mt-2">Maksimal 2MB per gambar. Memilih file baru akan menggantikan pilihan file sebelumnya di input ini.</div>
        </div>

        <div class="col-span-1">
            <label class="block text-sm font-bold text-brand-navy mb-2">URL Video YouTube (Opsional)</label>
            <input type="url" name="youtube_url" value="{{ old('youtube_url', $project->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
            <div class="text-xs text-gray-500 mt-1">Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ</div>
        </div>

        @if($project->exists && $project->images->count())
            <div class="mt-4">
                <p class="text-sm font-bold text-brand-navy mb-2">Hapus Gambar Gallery (Centang untuk menghapus)</p>
                <div class="grid grid-cols-4 gap-4">
                    @foreach($project->images as $img)
                        <label class="border rounded p-2 flex flex-col items-center cursor-pointer">
                            <img src="{{ Storage::url($img->path) }}" alt="gallery" class="h-20 object-cover mb-2 rounded">
                            <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="rounded border-red-300 text-red-600 focus:ring-red-500">
                        </label>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="flex justify-end pt-4">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Data Project
        </button>
    </div>
</form>
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<style>
    .hide-arrows::-webkit-outer-spin-button, 
    .hide-arrows::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .hide-arrows {
        -moz-appearance: textfield;
    }
    .ck-editor__editable_inline {
        min-height: 250px;
        padding: 1rem 1.5rem;
    }
    .ck-editor__editable ul {
        list-style-type: disc !important;
        margin-left: 1.5rem !important;
    }
    .ck-editor__editable ol {
        list-style-type: decimal !important;
        margin-left: 1.5rem !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('#editor-description')) {
            ClassicEditor
                .create(document.querySelector('#editor-description'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
                })
                .catch(error => {
                    console.error(error);
                });
        }

        // Cover Image Preview
        const coverInput = document.getElementById('cover_image_input');
        const coverPlaceholder = document.getElementById('cover-placeholder');
        const coverPreviewContainer = document.getElementById('cover-preview-container');
        const coverPreviewImg = document.getElementById('cover-preview-img');
        const dropzoneCover = document.getElementById('dropzone-cover');

        if(coverInput) {
            coverInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        coverPreviewImg.src = e.target.result;
                        coverPlaceholder.classList.add('hidden');
                        coverPreviewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Gallery Images Preview
        const galleryInput = document.getElementById('gallery_images_input');
        const galleryPlaceholder = document.getElementById('gallery-placeholder');
        const galleryPreviewContainer = document.getElementById('gallery-preview-container');
        const dropzoneGallery = document.getElementById('dropzone-gallery');

        if(galleryInput) {
            galleryInput.addEventListener('change', function(e) {
                galleryPreviewContainer.innerHTML = ''; // Clear existing previews
                
                if (this.files.length > 0) {
                    galleryPlaceholder.classList.add('hidden');
                    galleryPreviewContainer.classList.remove('hidden');
                    galleryPreviewContainer.classList.add('grid');
                    
                    Array.from(this.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'aspect-square rounded-lg overflow-hidden border border-gray-200 shadow-sm relative bg-white';
                            div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                            galleryPreviewContainer.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    });
                } else {
                    galleryPlaceholder.classList.remove('hidden');
                    galleryPreviewContainer.classList.add('hidden');
                    galleryPreviewContainer.classList.remove('grid');
                }
            });
        }
        
        // Drag and drop visual cues
        [dropzoneCover, dropzoneGallery].forEach(dropzone => {
            if(!dropzone) return;
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => {
                    dropzone.classList.add('border-brand-blue', 'bg-blue-50/50');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => {
                    dropzone.classList.remove('border-brand-blue', 'bg-blue-50/50');
                }, false);
            });
        });
    });
</script>
@endpush
@endsection
