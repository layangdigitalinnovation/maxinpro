@extends('backend.layout')
@section('title', ($listing->exists ? 'Edit' : 'Tambah') . ' Listing — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $listing->exists ? 'Edit Listing' : 'Tambah Listing Baru' }}</h1>
    <a href="{{ route('admin.listings.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="{{ $listing->exists ? route('admin.listings.update', $listing) : route('admin.listings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($listing->exists)
        @method('PUT')
    @endif

    <div class="bg-white border border-brand-line rounded-2xl p-6 grid grid-cols-2 gap-6">
        <h2 class="col-span-2 text-brand-navy font-black text-[18px]">Informasi Umum</h2>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Judul Listing</label>
            <input type="text" name="title" value="{{ old('title', $listing->title) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Tipe Properti</label>
            <select name="property_type_id" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
                <option value="">-- Pilih Tipe --</option>
                @foreach($propertyTypes as $pt)
                    <option value="{{ $pt->id }}" {{ old('property_type_id', $listing->property_type_id) == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Area</label>
            <select name="area_id" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
                <option value="">-- Pilih Area --</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id', $listing->area_id) == $area->id ? 'selected' : '' }}>{{ $area->name }} ({{ $area->city }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Agen (Opsional)</label>
            <select name="agent_id" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
                <option value="">-- Dikelola Admin --</option>
                @foreach($agents as $ag)
                    <option value="{{ $ag->id }}" {{ old('agent_id', $listing->agent_id) == $ag->id ? 'selected' : '' }}>{{ $ag->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Status Penjualan</label>
            <select name="status" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
                @foreach(['active' => 'Aktif (Ditampilkan)', 'sold' => 'Terjual', 'hidden' => 'Sembunyikan'] as $val => $label)
                    <option value="{{ $val }}" {{ old('status', $listing->status ?? 'active') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Harga (Rp)</label>
            <input type="number" name="price" value="{{ old('price', $listing->price) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="0">
        </div>
        
        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Badge Khusus (Opsional)</label>
            <select name="badge" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
                <option value="">-- Tanpa Badge --</option>
                @foreach(['Terpopuler', 'Baru', 'Premium'] as $badge)
                    <option value="{{ $badge }}" {{ old('badge', $listing->badge) == $badge ? 'selected' : '' }}>{{ $badge }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Alamat Lengkap</label>
            <input type="text" name="address" value="{{ old('address', $listing->address) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Deskripsi Lengkap</label>
            <textarea name="description" rows="5" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">{{ old('description', $listing->description) }}</textarea>
        </div>
    </div>

    <div class="bg-white border border-brand-line rounded-2xl p-6 grid grid-cols-5 gap-6">
        <h2 class="col-span-5 text-brand-navy font-black text-[18px]">Spesifikasi</h2>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">L. Tanah (m²)</label>
            <input type="number" name="land_area" value="{{ old('land_area', $listing->land_area) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" min="0">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">L. Bangunan (m²)</label>
            <input type="number" name="building_area" value="{{ old('building_area', $listing->building_area) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" min="0">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">K. Tidur</label>
            <input type="number" name="bedrooms" value="{{ old('bedrooms', $listing->bedrooms ?? 0) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="0">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">K. Mandi</label>
            <input type="number" name="bathrooms" value="{{ old('bathrooms', $listing->bathrooms ?? 0) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="0">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Carport/Garasi</label>
            <input type="number" name="car_ports" value="{{ old('car_ports', $listing->car_ports ?? 0) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="0">
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

        @if($listing->exists && $listing->images->count())
            <div class="mt-4">
                <p class="text-sm font-bold text-brand-navy mb-2">Hapus Gambar Gallery (Centang untuk menghapus)</p>
                <div class="grid grid-cols-4 gap-4">
                    @foreach($listing->images as $img)
                        <label class="border rounded p-2 flex flex-col items-center cursor-pointer">
                            <img src="{{ Storage::url($img->path) }}" alt="gallery" class="h-20 object-cover mb-2 rounded">
                            <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="rounded border-red-300 text-red-600 focus:ring-red-500">
                        </label>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="col-span-2">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $listing->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
            <span class="text-sm font-bold text-brand-navy">Tampilkan sebagai Listing Unggulan (Featured)</span>
        </label>
    </div>

    <div class="flex justify-end pt-4 border-t border-brand-line">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Data Listing
        </button>
    </div>
</form>
@endsection
