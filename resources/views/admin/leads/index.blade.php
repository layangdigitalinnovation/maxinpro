@extends('backend.layout')
@section('title', 'Data Leads (Titip Properti) — MaxinPro')

@section('content')
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Data Leads</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form method="GET" class="relative w-full sm:w-64">
            <!-- Preserve existing filters -->
            @foreach(request()->except(['q', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        <div class="flex gap-3 w-full sm:w-auto"><a href="{{ route('admin.leads.export', request()->query()) }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-green-600 text-white text-[13px] font-extrabold hover:bg-green-700">
        ↓ Export CSV
    </a></div>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 font-bold">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full min-w-[800px] text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-brand-line">
                <th class="p-4 font-bold text-sm text-brand-navy">Nama & Kontak</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Detail Properti</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Harga Diharapkan</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Status</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Tanggal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            @forelse($leads as $lead)
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-bold text-sm text-brand-navy">{{ $lead->name }}</div>
                        <div class="text-xs text-gray-500 mt-1">WA: {{ $lead->phone }}</div>
                        <div class="text-xs text-gray-500">{{ $lead->city }}</div>
                    </td>
                    <td class="p-4 text-sm text-brand-navy max-w-xs">
                        <span class="font-bold">{{ $lead->propertyType->name ?? 'Properti' }}</span><br>
                        <span class="text-xs text-gray-500 line-clamp-2" title="{{ $lead->address }}">{{ $lead->address }}</span>
                        @if($lead->specification)
                            <div class="text-xs text-gray-400 mt-1 line-clamp-1" title="{{ $lead->specification }}">{{ Str::limit($lead->specification, 50) }}</div>
                        @endif
                    </td>
                    <td class="p-4 font-bold text-sm text-brand-navy">
                        {{ $lead->expected_price ? 'Rp ' . number_format($lead->expected_price, 0, ',', '.') : '-' }}
                    </td>
                    <td class="p-4 text-sm">
                        <form action="{{ route('admin.leads.update', $lead) }}" method="POST" class="flex items-center gap-2">
                            @csrf @method('PUT')
                            <select name="status" class="border border-gray-300 rounded text-sm bg-gray-50 py-1.5 px-2 focus:ring-brand-blue" onchange="this.form.submit()">
                                <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>Baru</option>
                                <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>Dihubungi</option>
                                <option value="closed" {{ $lead->status === 'closed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td class="p-4 text-sm text-gray-500">
                        {{ $lead->created_at->format('d M Y, H:i') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada data leads.</td>
                </tr>
            @endforelse
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    {{ $leads->links() }}
</div>
@endsection
