<?php

namespace App\Repositories;

use App\Models\Party;
use App\Repositories\Contracts\PartyRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PartyRepository implements PartyRepositoryInterface
{
    public function __construct(
        protected Party $partyModel,
    ) {}

    public function partiesQuery(): Builder
    {
        return $this->partyModel->with(['user', 'user.biography'])->select('parties.*');
    }

    public function all(): Collection
    {
        return $this->partyModel->latest()->get();
    }

    public function findById(string $id): ?Party
    {
        return $this->partyModel->find($id);
    }

    public function create(array $data): void
    {
        $this->partyModel->create($data);
    }

    public function update(Party $party, array $data): void
    {
        $party->update($data);
    }

    public function delete(Party $party): void
    {
        $party->delete();
    }

    public function count(?array $dateRange = null): int
    {
        return $this->partyModel
            ->when($dateRange, function ($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            })->count();
    }
}
