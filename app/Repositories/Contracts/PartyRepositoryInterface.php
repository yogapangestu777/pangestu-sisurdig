<?php

namespace App\Repositories\Contracts;

use App\Models\Party;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface PartyRepositoryInterface
{
    public function partiesQuery(): Builder;

    public function all(): Collection;

    public function findById(string $id): ?Party;

    public function create(array $data): void;

    public function update(Party $party, array $data): void;

    public function delete(Party $party): void;

    public function count(?array $dateRange = null): int;
}
