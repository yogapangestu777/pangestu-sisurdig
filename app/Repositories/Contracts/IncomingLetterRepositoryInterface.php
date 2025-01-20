<?php

namespace App\Repositories\Contracts;

use App\Models\IncomingLetter;
use Illuminate\Database\Eloquent\Builder;

interface IncomingLetterRepositoryInterface
{
    public function incomingLettersQuery(): Builder;

    public function findById(string $id): ?IncomingLetter;

    public function create(array $data): IncomingLetter;

    public function update(IncomingLetter $incomingLetter, array $data): void;

    public function delete(IncomingLetter $incomingLetter): void;
}
