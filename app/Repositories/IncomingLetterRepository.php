<?php

namespace App\Repositories;

use App\Models\IncomingLetter;
use App\Repositories\Contracts\IncomingLetterRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class IncomingLetterRepository implements IncomingLetterRepositoryInterface
{
    public function __construct(
        protected IncomingLetter $incomingLetterModel
    ) {}

    public function incomingLettersQuery(): Builder
    {
        return $this->incomingLetterModel->with(['user', 'user.biography', 'category', 'party'])->select('incoming_letters.*');
    }

    public function findById(string $id): ?IncomingLetter
    {
        return $this->incomingLetterModel->find($id);
    }

    public function create(array $data): IncomingLetter
    {
        return $this->incomingLetterModel->create($data);
    }

    public function update(IncomingLetter $incomingLetter, array $data): void
    {
        $incomingLetter->update($data);
    }

    public function delete(IncomingLetter $incomingLetter): void
    {
        $incomingLetter->delete();
    }

    public function count(?array $dateRange = null): int
    {
        return $this->incomingLetterModel
            ->when($dateRange, function ($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            })->count();
    }
}
