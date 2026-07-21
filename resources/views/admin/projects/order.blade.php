@extends('backend.layout')
@section('title', 'Atur Urutan Proyek Baru — Admin MaxinPro')

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
@endpush

@section('content')
<div class="flex items-center justify-between mb-2">
    <h1 class="text-brand-navy text-[22px] font-black">Atur Urutan Proyek Baru</h1>
    <a href="{{ route('admin.projects.index') }}" class="text-[12.5px] font-extrabold">← Kembali</a>
</div>
<p class="text-brand-muted text-[12.5px] font-semibold mb-6 max-w-xl">
    Seret (drag) kartu untuk mengatur urutan tampil di beranda dan halaman Proyek Baru.
    Proyek paling atas akan muncul paling kiri/pertama. Perubahan tersimpan otomatis setiap kali urutan diubah.
</p>

<div id="save-indicator" class="hidden mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-[12.5px] font-bold px-4 py-3">
    Urutan berhasil disimpan.
</div>
<div id="save-error" class="hidden mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-[12.5px] font-bold px-4 py-3">
    Gagal menyimpan urutan. Muat ulang halaman dan coba lagi.
</div>

<ul id="project-order-list" class="bg-white border border-brand-line rounded-2xl divide-y divide-brand-line max-w-2xl">
    @forelse ($projects as $project)
        <li data-id="{{ $project->id }}" class="flex items-center gap-4 p-4 cursor-grab active:cursor-grabbing bg-white">
            <span class="text-brand-muted text-lg select-none">⠿</span>
            <img src="{{ $project->cover_image ? asset('storage/' . $project->cover_image) : asset('images/placeholder-property.jpg') }}"
                 alt="Cover {{ $project->name }}" class="w-14 h-14 rounded-lg object-cover shrink-0">
            <div class="min-w-0 flex-1">
                <strong class="block text-brand-navy text-[13.5px] font-extrabold truncate">{{ $project->name }}</strong>
                <span class="text-[11.5px] font-semibold text-brand-muted">{{ $project->developer->name }} · {{ $project->status }}</span>
            </div>
            <span class="order-number text-brand-navy text-[13px] font-black w-7 text-center shrink-0">{{ $loop->iteration }}</span>
        </li>
    @empty
        <li class="p-6 text-center text-brand-muted text-[13px]">Belum ada project untuk diatur urutannya.</li>
    @endforelse
</ul>

@if ($projects->isNotEmpty())
<script>
document.addEventListener('DOMContentLoaded', () => {
    const list = document.getElementById('project-order-list');
    const okBox = document.getElementById('save-indicator');
    const errBox = document.getElementById('save-error');

    function renumber() {
        list.querySelectorAll('li[data-id]').forEach((li, i) => {
            const numEl = li.querySelector('.order-number');
            if (numEl) numEl.textContent = i + 1;
        });
    }

    Sortable.create(list, {
        animation: 150,
        handle: undefined, // whole row is draggable
        onEnd: async () => {
            renumber();
            okBox.classList.add('hidden');
            errBox.classList.add('hidden');

            const order = Array.from(list.querySelectorAll('li[data-id]')).map(li => li.dataset.id);

            try {
                const response = await fetch('{{ route('admin.projects.update-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ order }),
                });
                if (!response.ok) throw new Error('save failed');
                okBox.classList.remove('hidden');
            } catch (e) {
                errBox.classList.remove('hidden');
            }
        },
    });
});
</script>
@endif
@endsection
