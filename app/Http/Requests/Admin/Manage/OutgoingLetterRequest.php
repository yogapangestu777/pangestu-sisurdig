<?php

namespace App\Http\Requests\Admin\Manage;

use App\Traits\NotifyTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OutgoingLetterRequest extends FormRequest
{
    use NotifyTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function prepareForValidation(): void
    {
        if (! is_null($this->outgoing_letter)) {
            $this->merge([
                'outgoing_letter' => decryptId($this->outgoing_letter),
            ]);
        }

        if ($this->filled('category')) {
            $this->merge([
                'category' => decryptId($this->category),
            ]);
        }

        if ($this->filled('party')) {
            $this->merge([
                'party' => decryptId($this->party),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'reference_number' => [
                'required',
                'string',
                'max:150',
                Rule::unique('outgoing_letters', 'reference_number')->ignore($this->outgoing_letter),
            ],
            'subject' => [
                'required',
                'string',
                'max:200',
            ],
            'content' => [
                'required',
                'string',
            ],
            'category' => [
                'required',
                Rule::exists('categories', 'id'),
            ],
            'party' => [
                'required',
                Rule::exists('parties', 'id'),
            ],
            'file' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'reference_number.required' => 'Nomor referensi wajib diisi',
            'reference_number.string' => 'Nomor referensi harus berupa string',
            'reference_number.unique' => 'Nomor referensi sudah ada',
            'reference_number.max' => 'Nomor referensi harus kurang dari :max karakter',

            'subject.required' => 'Subjek wajib diisi',
            'subject.string' => 'Subjek harus berupa string',
            'subject.max' => 'Subjek harus kurang dari :max karakter',

            'content.required' => 'Konten wajib diisi',
            'content.string' => 'Konten harus berupa string',

            'category.required' => 'Kategori wajib diisi',
            'category.exists' => 'Kategori tidak valid',

            'party.required' => 'Perusahaan wajib diisi',
            'party.exists' => 'Perusahaan tidak valid',

            'file.required' => 'File wajib diisi',
            'file.string' => 'File harus berupa string',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $this->handleValidationFailure($validator);
    }
}
