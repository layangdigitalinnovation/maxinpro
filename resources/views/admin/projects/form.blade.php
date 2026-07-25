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
            <input type="file" name="cover_image" accept="image/*" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
            <div class="text-xs text-gray-500 mt-1">Maksimal 2MB. Kosongkan jika tidak ingin mengubah (saat edit).</div>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Gallery Images (Bisa pilih lebih dari satu)</label>
            <input type="file" name="images[]" accept="image/*" multiple class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
            <div class="text-xs text-gray-500 mt-1">Maksimal 2MB per gambar.</div>
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
    });
</script>
@endpush
@endsection
