<?php

namespace App\Repositories\Contracts;

use App\Models\OutgoingLetter;
use Illuminate\Database\Eloquent\Builder;

interface OutgoingLetterRepositoryInterface
{
    public function outgoingLettersQuery(): Builder;

    public function findById(string $id): ?OutgoingLetter;

    public function create(array $data): OutgoingLetter;

    public function update(OutgoingLetter $outgoingLetter, array $data): void;

    public function delete(OutgoingLetter $outgoingLetter): void;
}
