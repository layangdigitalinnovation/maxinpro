<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class StoreTitipPropertiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     * NOTE: every field is validated server-side even though the frontend
     * also marks required fields — never trust client-side validation alone.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'property_type_id' => ['required', 'exists:property_types,id'],
            'expected_price' => ['required', 'string', 'max:30'],
            'specification' => ['nullable', 'string', 'max:2000'],
            'g-recaptcha-response' => [new Recaptcha()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Format nomor WhatsApp tidak valid.',
            'city.required' => 'Kota properti wajib dipilih.',
            'address.required' => 'Alamat lengkap properti wajib diisi.',
            'property_type_id.required' => 'Tipe properti wajib dipilih.',
            'expected_price.required' => 'Harga yang diharapkan wajib diisi.',
        ];
    }
}
