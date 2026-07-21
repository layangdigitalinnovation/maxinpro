<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTitipPropertiRequest;
use App\Models\Lead;
use App\Models\PropertyType;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Support\Facades\Notification;

class TitipPropertiController extends Controller
{
    public function create()
    {
        $propertyTypes = PropertyType::all();

        return view('titip-properti.create', compact('propertyTypes'));
    }

    public function store(StoreTitipPropertiRequest $request)
    {
        $data = $request->validated();

        // Sanitize the free-text rupiah amount ("2.500.000.000" or "2,5 miliar")
        // into a plain integer for storage; falls back to 0 if unparsable.
        $expectedPrice = (int) preg_replace('/[^0-9]/', '', $data['expected_price']);

        $lead = Lead::create([
            'type' => 'titip_properti',
            'name' => $data['name'],
            'phone' => $data['phone'],
            'city' => $data['city'],
            'address' => $data['address'],
            'property_type_id' => $data['property_type_id'],
            'expected_price' => $expectedPrice ?: null,
            'specification' => $data['specification'] ?? null,
            'status' => 'new',
            'source_ip' => $request->ip(),
        ]);

        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewLeadNotification($lead));
        }

        return redirect()
            ->route('titip-properti.create')
            ->with('success', 'Terima kasih! Tim kami akan segera menghubungi Anda dalam 1x24 jam.');
    }
}
