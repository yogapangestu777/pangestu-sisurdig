<?php

namespace App\Http\Requests\Admin\Setting;

use App\Traits\NotifyTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RolePermissionRequest extends FormRequest
{
    use NotifyTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $rolePermissionId = $this->route('role_permission');
        $decryptedId = $rolePermissionId ? decryptId($this->role_permission) : null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($decryptedId),
            ],
            'permissions' => [
                'required',
                'array',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'name.unique' => 'Nama sudah digunakan.',

            'permissions.required' => 'Hak akses wajib dipilih.',
            'permissions.array' => 'Hak akses harus berupa array.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $this->handleValidationFailure($validator);
    }
}
