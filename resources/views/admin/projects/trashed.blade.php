@extends('backend.layout')
@section('title', 'Project Terhapus — Admin MaxinPro')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Project Terhapus</h1>
    <a href="{{ route('admin.projects.index') }}" class="text-[12.5px] font-extrabold">← Kembali ke Project Aktif</a>
</div>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <table class="w-full text-[13px]">
        <thead class="bg-brand-soft text-brand-navy text-[11.5px] font-black uppercase">
            <tr>
                <th class="text-left px-4 py-3">Nama</th>
                <th class="text-left px-4 py-3">Developer</th>
                <th class="text-left px-4 py-3">Dihapus Pada</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr class="border-t border-brand-line">
                    <td class="px-4 py-3 font-bold text-brand-navy">{{ $project->name }}</td>
                    <td class="px-4 py-3">{{ $project->developer->name }}</td>
                    <td class="px-4 py-3">{{ $project->deleted_at->translatedFormat('d M Y H:i') }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <form action="{{ route('admin.projects.restore', $project->id) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-[12px] font-extrabold text-green-700 mr-3">Pulihkan</button>
                        </form>
                        <form action="{{ route('admin.projects.force-delete', $project->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus PERMANEN? Data dan foto tidak bisa dikembalikan.');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-[12px] font-extrabold text-red-600">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-brand-muted">Tidak ada project yang dihapus.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $projects->links() }}</div>
@endsection
