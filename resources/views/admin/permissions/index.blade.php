@extends('backend.layout')
@section('title', 'Data Permission — MaxinPro')

@section('content')
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Data Permission</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <a href="{{ route('admin.permissions.create') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            + Tambah Permission
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 text-sm font-bold">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[600px] text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-brand-line">
                    <th class="p-4 font-bold text-sm text-brand-navy">Nama Permission</th>
                    <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-line">
                @forelse($permissions as $permission)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm font-bold text-gray-700">{{ $permission->name }}</td>
                        <td class="p-4 text-sm flex gap-3">
                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="text-blue-600 hover:underline font-bold">Edit</a>
                            <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Hapus permission ini?');" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="p-6 text-center text-gray-500 text-sm">Belum ada permission.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@if(method_exists($permissions, 'links'))
<div class="mt-6">{{ $permissions->links() }}</div>
@endif
@endsection
