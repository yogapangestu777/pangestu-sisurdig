<?php

namespace App\Repositories;

use App\Models\OutgoingLetter;
use App\Repositories\Contracts\OutgoingLetterRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class OutgoingLetterRepository implements OutgoingLetterRepositoryInterface
{
    public function __construct(
        protected OutgoingLetter $outgoingLetterModel
    ) {}

    public function outgoingLettersQuery(): Builder
    {
        return $this->outgoingLetterModel->with(['user', 'user.biography', 'category', 'party'])->select('outgoing_letters.*');
    }

    public function findById(string $id): ?OutgoingLetter
    {
        return $this->outgoingLetterModel->find($id);
    }

    public function create(array $data): OutgoingLetter
    {
        return $this->outgoingLetterModel->create($data);
    }

    public function update(OutgoingLetter $outgoingLetter, array $data): void
    {
        $outgoingLetter->update($data);
    }

    public function delete(OutgoingLetter $outgoingLetter): void
    {
        $outgoingLetter->delete();
    }
}
