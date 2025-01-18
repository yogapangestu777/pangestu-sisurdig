<?php

namespace App\Http\Requests\Admin\Profile;

use App\Traits\NotifyTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BiographyRequest extends FormRequest
{
    use NotifyTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'full_name' => [
                'required',
                'string',
                'max:100',
            ],
            'phone_number' => [
                'required',
                'string',
                'regex:/^\+?[0-9]{10,15}$/',
            ],
            'pob' => [
                'required',
                'string',
                'max:30',
            ],
            'dob' => [
                'required',
                'date',
                'before:today',
            ],
            'gender' => [
                'required',
                Rule::in(['1', '2']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap harus diisi.',
            'full_name.string' => 'Nama lengkap harus berupa string.',
            'full_name.max' => 'Nama lengkap tidak boleh lebih dari 100 karakter.',

            'phone_number.required' => 'Nomor telepon harus diisi.',
            'phone_number.string' => 'Nomor telepon harus berupa string.',
            'phone_number.regex' => 'Nomor telepon tidak valid.',

            'pob.required' => 'Tempat lahir harus diisi.',
            'pob.string' => 'Tempat lahir harus berupa string.',
            'pob.max' => 'Tempat lahir tidak boleh lebih dari 30 karakter.',

            'dob.required' => 'Tanggal lahir harus diisi.',
            'dob.date' => 'Tanggal lahir harus berupa tanggal.',
            'dob.before' => 'Tanggal lahir harus sebelum hari ini.',

            'gender.required' => 'Jenis kelamin harus diisi.',
            'gender.in' => 'Jenis kelamin tidak valid.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $this->handleValidationFailure($validator);
    }
}
