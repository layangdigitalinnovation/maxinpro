<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerBank;
use Illuminate\Http\Request;

class PartnerBankController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $partnerBanks = PartnerBank::orderBy('sort_order')->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))
            ->paginate(20)->withQueryString();

        return view('admin.partner-banks.index', compact('partnerBanks'));
    }

    public function create()
    {
        return view('admin.partner-banks.form', ['partnerBank' => new PartnerBank()]);
    }

    public function store(Request $request)
    {
        PartnerBank::create($this->validated($request));

        return redirect()->route('admin.partner-banks.index')->with('success', 'Bank rekanan berhasil ditambahkan.');
    }

    public function edit(PartnerBank $partnerBank)
    {
        return view('admin.partner-banks.form', compact('partnerBank'));
    }

    public function update(Request $request, PartnerBank $partnerBank)
    {
        $partnerBank->update($this->validated($request));

        return redirect()->route('admin.partner-banks.index')->with('success', 'Bank rekanan berhasil diperbarui.');
    }

    public function destroy(PartnerBank $partnerBank)
    {
        $partnerBank->delete();

        return redirect()->route('admin.partner-banks.index')->with('success', 'Bank rekanan berhasil dihapus.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
