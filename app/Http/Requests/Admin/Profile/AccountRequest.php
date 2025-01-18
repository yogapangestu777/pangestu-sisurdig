<?php

namespace App\Http\Requests\Admin\Profile;

use App\Traits\NotifyTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
{
    use NotifyTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $userId = decryptId($this->route('account'));

        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
                'max:50',
            ],
            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username')->ignore($userId),
                'min:5',
                'max:20',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus berupa alamat email yang valid',
            'email.unique' => 'Email sudah ada',
            'email.max' => 'Email harus kurang dari 50 karakter',

            'username.required' => 'Nama pengguna wajib diisi',
            'username.string' => 'Nama pengguna harus berupa string',
            'username.unique' => 'Nama pengguna sudah ada',
            'username.min' => 'Nama pengguna harus setidaknya 5 karakter',
            'username.max' => 'Nama pengguna harus kurang dari 20 karakter',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $this->handleValidationFailure($validator);
    }
}
