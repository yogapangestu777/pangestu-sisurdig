<?php

namespace App\Repositories;

use App\Models\OutgoingLetter;
use App\Repositories\Contracts\OutgoingLetterRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function count(): int
    {
        return $this->outgoingLetterModel->count();
    }

    public function getMostFrequentLetterParty(int $limit, ?array $dateRange = null): Collection
    {
        return $this->outgoingLetterModel
            ->select('party_id', DB::raw('count(*) as amount'))
            ->with('party')
            ->when($dateRange, function ($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            })
            ->groupBy('party_id')
            ->orderBy('amount', 'desc')
            ->limit($limit)
            ->get();
    }
}
