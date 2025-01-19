<?php

namespace App\Http\Requests\Admin\Manage;

use App\Traits\NotifyTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    use NotifyTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function prepareForValidation(): void
    {
        if ($this->filled('role')) {
            $this->merge([
                'role' => decryptId($this->role),
            ]);
        }
        if (! is_null($this->user)) {
            $this->merge([
                'user' => decryptId($this->user),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user),
                'max:50',
            ],
            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username')->ignore($this->user),
                'min:5',
                'max:20',
            ],
            'role' => [
                'required',
                Rule::exists('roles', 'id'),
            ],
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
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus berupa alamat email yang valid',
            'email.unique' => 'Email sudah ada',
            'email.max' => 'Email harus kurang dari 50 karakter',

            'username.required' => 'Nama pengguna wajib diisi',
            'username.string' => 'Nama pengguna harus berupa string',
            'username.unique' => 'Nama pengguna sudah ada',
            'username.min' => 'Nama pengguna harus setidaknya 5 karakter',
            'username.max' => 'Nama pengguna harus kurang dari 20 karakter',

            'role.required' => 'Role wajib diisi',
            'role.exists' => 'Role tidak valid',

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
