<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

trait NotifyTrait
{
    public function handleValidationFailure(Validator $validator): void
    {
        notify()->warning('Silakan periksa data yang Anda masukkan', 'Peringatan');
        $response = redirect()
            ->back()
            ->withInput()
            ->withErrors($validator);

        throw new ValidationException($validator, $response);
    }
}
