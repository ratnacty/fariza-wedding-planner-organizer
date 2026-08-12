<?php

namespace App\Http\Requests;

use App\Support\BookingCalendar;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BookingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'whatsapp' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'wedding_date' => ['required', 'date', 'after_or_equal:today'],
            'event_location' => ['nullable', 'string', 'max:255'],
            'service_id' => ['nullable', 'exists:services,id'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex' => 'Format nomor WhatsApp tidak valid.',
            'wedding_date.required' => 'Tanggal pernikahan wajib diisi.',
            'wedding_date.after_or_equal' => 'Tanggal pernikahan tidak boleh sebelum hari ini.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $date = $this->input('wedding_date');

            if ($date && ! BookingCalendar::isBookable($date)) {
                $validator->errors()->add('wedding_date', 'Maaf, tanggal tersebut sudah penuh. Silakan pilih tanggal lain.');
            }
        });
    }
}
