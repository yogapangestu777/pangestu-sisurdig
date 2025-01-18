<?php

namespace App\Http\Requests\Admin\Profile;

use App\Traits\NotifyTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordRequest extends FormRequest
{
    use NotifyTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (! Hash::check($value, auth()->user()->password)) {
                        $fail('Kata sandi saat ini tidak cocok.');
                    }
                },
            ],
            'new_password' => [
                'required',
                'different:current_password',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'confirm_new_password' => [
                'required',
                'same:new_password',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.required' => 'Kata sandi baru harus diisi.',
            'new_password.different' => 'Kata sandi baru tidak boleh sama dengan kata sandi saat ini.',
            'new_password.min' => 'Kata sandi baru harus terdiri dari minimal 8 karakter.',
            'new_password.letters' => 'Kata sandi baru harus mengandung setidaknya satu huruf.',
            'new_password.mixed_case' => 'Kata sandi baru harus mengandung huruf besar dan kecil.',
            'new_password.numbers' => 'Kata sandi baru harus mengandung setidaknya satu angka.',
            'new_password.symbols' => 'Kata sandi baru harus mengandung setidaknya satu simbol.',
            'new_password.uncompromised' => 'Kata sandi baru telah ditemukan dalam kebocoran data, silakan pilih kata sandi yang berbeda. The given new password has appeared in a data leak. Please choose a different new password.',

            'confirm_new_password.required' => 'Konfirmasi kata sandi baru harus diisi.',
            'confirm_new_password.same' => 'Konfirmasi kata sandi baru tidak cocok dengan kata sandi baru.',

            'current_password.required' => 'Kata sandi saat ini harus diisi.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $this->handleValidationFailure($validator);
    }
}
