<?php

namespace App\Http\Requests;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare inputs for validation (normalize email).
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower(trim($this->input('email'))),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $event = Event::current();

        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('registrations', 'email')
                    ->where(fn ($query) => $query->where('event_id', $event->id)),
            ],
            'phone_number' => ['required', 'string', 'max:30'],
            'position' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'organization_type' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:150'],
            'participation_category' => ['nullable', 'string', 'in:investor,speaker,vvip,media,peserta'],
            'sectors' => ['nullable', 'array'],
            'sectors.*' => ['string', 'max:50'],
            'sessions' => ['nullable', 'array'],
            'sessions.*' => ['string', 'max:50'],
            'privacy_agreed' => ['accepted'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap dan gelar wajib diisi.',
            'email.required' => 'Alamat email resmi / korporat wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar sebagai delegasi resmi pada acara ini.',
            'phone_number.required' => 'Nomor telepon / WhatsApp aktif wajib diisi.',
            'position.required' => 'Jabatan atau posisi dalam instansi wajib diisi.',
            'company_name.required' => 'Nama perusahaan / instansi / kedutaan wajib diisi.',
            'organization_type.required' => 'Klasifikasi jenis organisasi wajib dipilih.',
            'country.required' => 'Negara domisili lembaga wajib dipilih.',
            'city.required' => 'Kota kantor pusat / domisili wajib diisi.',
            'privacy_agreed.accepted' => 'Anda wajib menyetujui ketentuan pemrosesan data pribadi (UU PDP No. 27/2022) untuk melanjutkan akreditasi.',
        ];
    }
}
