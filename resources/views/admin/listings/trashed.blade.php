@extends('backend.layout')
@section('title', 'Sampah Listing — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Sampah Listing</h1>
    <a href="{{ route('admin.listings.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
        Kembali
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 font-bold">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-brand-line">
                <th class="p-4 font-bold text-sm text-brand-navy">Listing</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Tipe & Area</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Harga</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Dihapus Pada</th>
                <th class="p-4 font-bold text-sm text-brand-navy w-48">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            @forelse($listings as $listing)
                <tr class="hover:bg-gray-50 opacity-75">
                    <td class="p-4">
                        <div class="font-bold text-sm text-brand-navy line-through">{{ $listing->title }}</div>
                    </td>
                    <td class="p-4 text-sm text-brand-navy">
                        {{ $listing->propertyType->name ?? '-' }}<br>
                        <span class="text-xs text-gray-500">{{ $listing->area->name ?? '-' }}</span>
                    </td>
                    <td class="p-4 font-bold text-sm text-brand-navy">
                        Rp {{ number_format($listing->price, 0, ',', '.') }}
                    </td>
                    <td class="p-4 text-sm text-gray-500">
                        {{ $listing->deleted_at->format('d M Y') }}
                    </td>
                    <td class="p-4 text-sm flex gap-3">
                        <form action="{{ route('admin.listings.restore', $listing->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-green-600 hover:underline font-bold">Pulihkan</button>
                        </form>
                        <form action="{{ route('admin.listings.force-delete', $listing->id) }}" method="POST" onsubmit="return confirm('Hapus PERMANEN listing ini? Data tidak bisa dikembalikan!');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-bold">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Tidak ada listing di tempat sampah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if(method_exists($listings, 'links'))
<div class="mt-6">{{ $listings->links() }}</div>
@endif
@endsection
