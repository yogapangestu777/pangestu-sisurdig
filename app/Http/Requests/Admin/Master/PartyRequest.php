<?php

namespace App\Http\Requests\Admin\Master;

use App\Traits\NotifyTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartyRequest extends FormRequest
{
    use NotifyTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'type' => [
                'required',
                Rule::in(['1', '2']),
            ],
            'email' => [
                'nullable',
                'email',
                'max:50',
            ],
            'phone_number' => [
                'nullable',
                'string',
                'regex:/^\+?[0-9]{10,15}$/',
            ],
            'address' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',

            'type.required' => 'Tipe wajib diisi.',
            'type.in' => 'Tipe tidak valid.',

            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',

            'phone_number.regex' => 'Nomor telepon tidak valid.',
            'phone_number.max' => 'Nomor telepon tidak boleh lebih dari :max karakter.',

            'address.max' => 'Alamat tidak boleh lebih dari :max karakter.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $this->handleValidationFailure($validator);
    }
}
