<?php

namespace App\Repositories\Contracts;

use App\Models\OutgoingLetter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface OutgoingLetterRepositoryInterface
{
    public function outgoingLettersQuery(): Builder;

    public function findById(string $id): ?OutgoingLetter;

    public function create(array $data): OutgoingLetter;

    public function update(OutgoingLetter $outgoingLetter, array $data): void;

    public function delete(OutgoingLetter $outgoingLetter): void;

    public function count(): int;

    public function getMostFrequentLetterParty(int $limit, ?array $dateRange = null): Collection;
}
