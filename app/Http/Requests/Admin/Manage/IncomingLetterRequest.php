<?php

namespace App\Http\Requests\Admin\Manage;

use App\Traits\NotifyTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IncomingLetterRequest extends FormRequest
{
    use NotifyTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function prepareForValidation(): void
    {
        if (! is_null($this->incoming_letter)) {
            $this->merge([
                'incoming_letter' => decryptId($this->incoming_letter),
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
                Rule::unique('incoming_letters', 'reference_number')->ignore($this->incoming_letter),
            ],
            'subject' => [
                'required',
                'string',
                'max:200',
            ],
            'description' => [
                'nullable',
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

            'description.string' => 'Deskripsi harus berupa string',

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
