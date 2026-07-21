<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $leads = Lead::with('propertyType')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest()
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))
            ->paginate(20)
            ->withQueryString();

        return view('admin.leads.index', compact('leads'));
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,contacted,closed'],
        ]);

        $lead->update($data);

        return redirect()->route('admin.leads.index')->with('success', 'Status lead berhasil diperbarui.');
    }

    /**
     * Stream leads as CSV rather than building the whole file in memory —
     * safe even if the leads table grows to hundreds of thousands of rows.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = Lead::with('propertyType')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest();

        $filename = 'leads-titip-properti-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM so the CSV opens correctly (accented/Indonesian text) in Excel.
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Nama', 'WhatsApp', 'Kota', 'Alamat', 'Tipe Properti', 'Harga Diharapkan', 'Spesifikasi', 'Status', 'Tanggal Masuk']);

            $query->chunk(200, function ($leads) use ($handle) {
                foreach ($leads as $lead) {
                    fputcsv($handle, [
                        $lead->name,
                        $lead->phone,
                        $lead->city,
                        $lead->address,
                        $lead->propertyType?->name,
                        $lead->expected_price,
                        $lead->specification,
                        $lead->status,
                        $lead->created_at->format('Y-m-d H:i'),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
