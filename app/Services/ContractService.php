<?php

namespace App\Services;

use App\Enums\ContractStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Contract;
use App\Queries\ContractQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ContractService
{
    private ContractQuery $contractQuery;

    /**
     * @param ContractQuery $contractQuery
     */
    public function __construct(ContractQuery $contractQuery)
    {
        $this->contractQuery = $contractQuery;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->contractQuery->getAll();
    }

    /**
     * @param int $id
     * @return Contract
     */
    public function getById(int $id): Contract
    {
        $userId = Auth::id();

        return $this->contractQuery->getByIdAndUserId(id: $id, userId: $userId);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        return $this->contractQuery->destroy($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        $data['status'] = ContractStatusEnum::Sent;
        return $this->contractQuery->create(data: $data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Contract|null
     * @throws NotFoundException
     */
    public function update(int $id, array $data): ?Contract
    {
        $userId = Auth::id();
        $contract = $this->contractQuery->getByIdAndUserId(id: $id, userId: $userId);
        if (empty($contract)) {
            throw new NotFoundException();
        }
        return $contract->fresh();
    }
}
