@extends('backend.layout')
@section('title', 'Audit Logs — MaxinPro')

@section('content')
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Audit Logs</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form method="GET" class="relative w-full sm:w-64">
            <!-- Preserve existing filters -->
            @foreach(request()->except(['q', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        <div class="flex gap-3 w-full sm:w-auto"></div>
    </div>
</div>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full min-w-[800px] text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-brand-line">
                <th class="p-4 font-bold text-sm text-brand-navy">Waktu</th>
                <th class="p-4 font-bold text-sm text-brand-navy">User</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Aksi</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Modul/Data</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Detail</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 text-xs text-gray-500">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td class="p-4 text-sm font-bold text-brand-navy">{{ $log->user->name ?? 'System' }}</td>
                    <td class="p-4 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-700">
                            {{ strtoupper($log->action) }}
                        </span>
                    </td>
                    <td class="p-4 text-sm">{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
                    <td class="p-4 text-xs text-gray-500 max-w-xs truncate" title="{{ json_encode($log->payload) }}">
                        {{ json_encode($log->payload) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada log aktivitas.</td>
                </tr>
            @endforelse
        </tbody>
    </table></div>
</div>
@if(method_exists($logs, 'links'))
<div class="mt-6">{{ $logs->links() }}</div>
@endif
@endsection
