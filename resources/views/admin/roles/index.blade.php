@extends('backend.layout')
@section('title', 'Data Peran (Role) — MaxinPro')

@section('content')
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Data Peran (Role)</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <a href="{{ route('admin.roles.create') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            + Tambah Peran
        </a>
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
        <table class="w-full min-w-[600px] text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-brand-line">
                    <th class="p-4 font-bold text-sm text-brand-navy w-48">Nama Peran</th>
                    <th class="p-4 font-bold text-sm text-brand-navy">Permissions</th>
                    <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-line">
                @forelse($roles as $role)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm font-bold text-brand-navy">{{ $role->name }}</td>
                        <td class="p-4 text-sm text-gray-700">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($role->permissions as $permission)
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 italic">Belum ada permission</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="p-4 text-sm flex gap-3">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600 hover:underline font-bold">Edit</a>
                            @if($role->name !== 'admin')
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Hapus peran ini?');" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-gray-500 text-sm">Belum ada peran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@if(method_exists($roles, 'links'))
<div class="mt-6">{{ $roles->links() }}</div>
@endif
@endsection
