<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::query()
            ->with('user')
            ->when($request->filled('type'), fn ($q) => $q->where('auditable_type', 'App\\Models\\' . $request->string('type')))
            ->when($request->filled('q'), fn ($q) => $q->where('auditable_label', 'like', '%' . $request->string('q') . '%'))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.audit-logs.index', compact('logs'));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');

        // All other log entries for the same object, so an admin can see the
        // full history (not just this one change) without leaving the page.
        $history = AuditLog::query()
            ->with('user')
            ->where('auditable_type', $auditLog->auditable_type)
            ->where('auditable_id', $auditLog->auditable_id)
            ->latest()
            ->get();

        return view('admin.audit-logs.show', compact('auditLog', 'history'));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = AuditLog::with('user')
            ->when($request->filled('type'), fn ($q) => $q->where('auditable_type', 'App\\Models\\' . $request->string('type')))
            ->when($request->filled('q'), fn ($q) => $q->where('auditable_label', 'like', '%' . $request->string('q') . '%'))
            ->latest();

        $filename = 'audit-log-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Waktu', 'Pengguna', 'Aksi', 'Tipe Objek', 'Objek', 'Perubahan', 'IP Address']);

            $query->chunk(200, function ($logs) use ($handle) {
                foreach ($logs as $log) {
                    $changesText = $log->changes
                        ? collect($log->changes)->map(fn ($diff, $field) => AuditLog::fieldLabel($field) . ': '
                            . AuditLog::formatValue($field, $diff['old'] ?? null) . ' -> '
                            . AuditLog::formatValue($field, $diff['new'] ?? null))->implode('; ')
                        : '';

                    fputcsv($handle, [
                        $log->created_at->format('Y-m-d H:i:s'),
                        $log->user?->name ?? 'Sistem',
                        match ($log->action) { 'created' => 'Dibuat', 'deleted' => 'Dihapus', default => 'Diubah' },
                        $log->shortType(),
                        $log->auditable_label,
                        $changesText,
                        $log->ip_address,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
