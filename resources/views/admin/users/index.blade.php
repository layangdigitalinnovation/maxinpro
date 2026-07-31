@extends('backend.layout')
@section('title', 'Data Pengguna — MaxinPro')

@section('content')
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Data Pengguna</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form method="GET" class="relative w-full sm:w-64">
            <!-- Preserve existing filters -->
            @foreach(request()->except(['q', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        <div class="flex gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.users.create') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
                + Tambah Pengguna
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 text-sm font-bold">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 text-sm font-bold">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px] text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-brand-line">
                    <th class="p-4 font-bold text-sm text-brand-navy">Nama Lengkap</th>
                    <th class="p-4 font-bold text-sm text-brand-navy">Email</th>
                    <th class="p-4 font-bold text-sm text-brand-navy">Peran</th>
                    <th class="p-4 font-bold text-sm text-brand-navy">Status Verifikasi</th>
                    <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-line">
                @forelse($users as $u)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm font-bold text-brand-navy">{{ $u->name }}</td>
                        <td class="p-4 text-sm text-gray-700">{{ $u->email }}</td>
                        <td class="p-4 text-sm">
                            @php $roleName = $u->roles->first()?->name ?? 'Belum ada peran'; @endphp
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $roleName === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ strtoupper($roleName) }}
                            </span>
                        </td>
                        <td class="p-4 text-sm">
                            @if($u->email_verified_at)
                                <span class="text-green-600 font-bold">Terverifikasi</span>
                            @else
                                <span class="text-gray-500 font-bold">Belum</span>
                            @endif
                        </td>
                        <td class="p-4 text-sm flex gap-3">
                            <a href="{{ route('admin.users.edit', $u) }}" class="text-blue-600 hover:underline font-bold">Edit</a>
                            @if($u->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@if(method_exists($users, 'links'))
<div class="mt-6">{{ $users->links() }}</div>
@endif
@endsection
