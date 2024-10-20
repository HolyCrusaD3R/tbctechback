<?php

namespace App\Queries;


use App\Models\Contract;
use Illuminate\Database\Eloquent\Collection;

class ContractQuery
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return Contract::query()->create($data);
    }

    /**
     * @param int $id
     * @return Contract|null
     */
    public function getById(int $id): ?Contract
    {
        return Contract::query()
            ->where('id', $id)
            ->first();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        return Contract::query()
            ->where('id', $id)
            ->delete();
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Contract::query()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param int $id
     * @param array $data
     * @return int
     */
    public function update(int $id, array $data): int
    {
        return Contract::query()
            ->where('id', $id)
            ->update($data);
    }

}
