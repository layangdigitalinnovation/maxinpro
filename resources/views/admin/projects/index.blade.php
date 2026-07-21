@extends('backend.layout')
@section('title', 'Kelola Project — MaxinPro')

@section('content')
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    
    <h1 class="text-brand-navy text-[22px] font-black">Kelola Project</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form method="GET" class="relative w-full sm:w-64">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        <div class="flex gap-3 w-full sm:w-auto">
            
        <a href="{{ route('admin.projects.order') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-indigo-100 text-indigo-700 text-[13px] font-extrabold hover:bg-indigo-200">
            Atur Urutan
        </a>
        <a href="{{ route('admin.projects.trashed') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
            Sampah
        </a>
        <a href="{{ route('admin.projects.create') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            + Tambah Project
        </a>
    
        </div>
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
                <th class="p-4 font-bold text-sm text-brand-navy">Project</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Developer & Area</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Harga Mulai</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Status</th>
                <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            @forelse($projects as $project)
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-bold text-sm text-brand-navy">{{ $project->name }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $project->is_featured ? '⭐ Featured' : '' }}
                        </div>
                    </td>
                    <td class="p-4 text-sm text-brand-navy">
                        <span class="font-bold">{{ $project->developer->name ?? '-' }}</span><br>
                        <span class="text-xs text-gray-500">{{ $project->area->name ?? '-' }}</span>
                    </td>
                    <td class="p-4 font-bold text-sm text-brand-navy">
                        Rp {{ number_format($project->price_from, 0, ',', '.') }}
                    </td>
                    <td class="p-4 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-700">
                            {{ $project->status }}
                        </span>
                    </td>
                    <td class="p-4 text-sm flex gap-3">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-blue-600 hover:underline font-bold">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Pindahkan project ini ke sampah?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada project yang ditambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    {{ $projects->links() }}
</div>
@endsection
