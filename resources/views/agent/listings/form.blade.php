@extends('backend.layout')
@section('title', ($listing->exists ? 'Edit' : 'Tambah') . ' Listing — Agen MaxinPro')

@section('content')
<h1 class="text-brand-navy text-[20px] font-black mb-6">{{ $listing->exists ? 'Edit Listing' : 'Tambah Listing' }}</h1>

<form action="{{ $listing->exists ? route('agent.listings.update', $listing) : route('agent.listings.store') }}"
      method="POST" enctype="multipart/form-data" class="bg-white border border-brand-line rounded-2xl p-6 max-w-3xl">
    @csrf
    @if ($listing->exists) @method('PUT') @endif

    <div class="grid gap-4">
        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Judul *</label>
            <input type="text" name="title" value="{{ old('title', $listing->title) }}" required class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            @error('title') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border border-brand-line rounded-lg px-3.5 py-2.5 text-[13.5px]">{{ old('description', $listing->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Tipe Properti *</label>
                <select name="property_type_id" required class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px] bg-white">
                    <option value="">Pilih</option>
                    @foreach ($propertyTypes as $t)
                        <option value="{{ $t->id }}" @selected(old('property_type_id', $listing->property_type_id) == $t->id)>{{ $t->name }}</option>
                    @endforeach
                </select>
                @error('property_type_id') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Area *</label>
                <select name="area_id" required class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px] bg-white">
                    <option value="">Pilih</option>
                    @foreach ($areas as $a)
                        <option value="{{ $a->id }}" @selected(old('area_id', $listing->area_id) == $a->id)>{{ $a->name }}, {{ $a->city }}</option>
                    @endforeach
                </select>
                @error('area_id') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Alamat</label>
            <input type="text" name="address" value="{{ old('address', $listing->address) }}" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Harga (Rp) *</label>
                <input type="number" name="price" value="{{ old('price', $listing->price) }}" required min="0" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
                @error('price') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Luas Tanah (m²)</label>
                <input type="number" name="land_area" value="{{ old('land_area', $listing->land_area) }}" min="0" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            </div>
            <div>
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Luas Bangunan (m²)</label>
                <input type="number" name="building_area" value="{{ old('building_area', $listing->building_area) }}" min="0" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kamar Tidur *</label>
                <input type="number" name="bedrooms" value="{{ old('bedrooms', $listing->bedrooms ?? 0) }}" required min="0" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            </div>
            <div>
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kamar Mandi *</label>
                <input type="number" name="bathrooms" value="{{ old('bathrooms', $listing->bathrooms ?? 0) }}" required min="0" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            </div>
            <div>
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Carport *</label>
                <input type="number" name="car_ports" value="{{ old('car_ports', $listing->car_ports ?? 0) }}" required min="0" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            </div>
        </div>

        @if ($listing->exists)
            @if ($listing->status === 'hidden')
                <div class="rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-[12.5px] font-bold px-4 py-3">
                    Listing ini disembunyikan oleh admin dan tidak tampil ke publik. Hubungi admin bila ini tidak sesuai.
                </div>
            @else
                <div>
                    <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Status</label>
                    <select name="status" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px] bg-white">
                        <option value="active" @selected($listing->status === 'active')>Aktif</option>
                        <option value="sold" @selected($listing->status === 'sold')>Terjual</option>
                    </select>
                    <p class="text-[11px] text-brand-muted mt-1">Untuk menyembunyikan listing dari publik, hubungi admin.</p>
                </div>
            @endif
        @endif

        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Foto Cover</label>
            @if ($listing->cover_image)
                <img src="{{ asset('storage/' . $listing->cover_image) }}" alt="Pratinjau foto cover listing saat ini" class="w-40 h-24 object-cover rounded-lg mb-2">
            @endif
            <input type="file" name="cover_image" accept="image/*" class="text-[13px]">
            @error('cover_image') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white font-extrabold text-[13.5px]">Simpan</button>
        <a href="{{ route('agent.listings.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg border border-brand-line text-brand-navy font-extrabold text-[13.5px]">Batal</a>
    </div>
</form>
@endsection
