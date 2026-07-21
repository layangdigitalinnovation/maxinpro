<?php

namespace App\Http\Controllers;

use App\Models\PartnerBank;

class KprController extends Controller
{
    public function index()
    {
        $banks = PartnerBank::orderBy('sort_order')->pluck('name');

        $personalDocs = [
            'KTP pemohon dan pasangan (jika menikah)',
            'Kartu Keluarga',
            'NPWP',
            'Buku nikah / surat cerai (jika berlaku)',
        ];

        $incomeDocs = [
            'Slip gaji 3 bulan terakhir',
            'Rekening koran / tabungan 3 bulan terakhir',
            'Surat keterangan kerja',
            'SIUP & NPWP usaha (untuk wiraswasta)',
        ];

        return view('kpr.index', compact('banks', 'personalDocs', 'incomeDocs'));
    }
}
