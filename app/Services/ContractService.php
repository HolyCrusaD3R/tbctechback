<?php

namespace App\Services;

use App\Enums\ContractStatusEnum;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Models\Contract;
use App\Queries\ContractQuery;
use App\Queries\ProductQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ContractService
{
    private ContractQuery $contractQuery;
    private ProductQuery $productQuery;

    /**
     * @param ProductQuery $productQuery
     * @param ContractQuery $contractQuery
     */
    public function __construct(ProductQuery $productQuery, ContractQuery $contractQuery)
    {
        $this->productQuery = $productQuery;
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
     * @throws ValidationException
     */
    public function create(array $data): mixed
    {
        $product = $this->productQuery->getById($data['product_id']);
        $data['buyer_id'] = Auth::id();
        if ($product['user_id'] === Auth::id()) {
            throw new ValidationException('You Cannot Form A Contract On Yourself');
        }
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
