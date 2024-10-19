<?php

namespace App\Services;

use App\Enums\ContractStatusEnum;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnAuthorizedException;
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
     * @throws UnAuthorizedException
     */
    public function getById(int $id): Contract
    {
        $userId = Auth::id();
        $contract = $this->contractQuery->getById(id: $id);
        if ($contract->product->user_id != $userId && $contract->buyer->id != $userId) {
            throw new UnAuthorizedException();
        }
        return $this->contractQuery->getById(id: $id);
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
            throw new ValidationException('You Cannot Form A Contract With Yourself');
        }
        $data['status'] = ContractStatusEnum::Sent;
        return $this->contractQuery->create(data: $data);
    }

    /**
     * @param int $id
     * @return int
     * @throws NotFoundException
     * @throws UnAuthorizedException
     */
    public function complete(int $id): int
    {
        $userId = Auth::id();
        $contract = $this->contractQuery->getById($id);
        if (empty($contract)) {
            throw new NotFoundException('Contract Was Not Found');
        }
        if ($contract->buyer->id != $userId) {
            throw new UnAuthorizedException('Not Allowed');
        }
        $data = [
            'status' => ContractStatusEnum::Successful
        ];
        return $this->contractQuery->update(id: $id, data: $data);
    }

    /**
     * @param int $id
     * @return int
     * @throws NotFoundException
     * @throws UnAuthorizedException
     */
    public function dispute(int $id): int
    {
        $userId = Auth::id();
        $contract = $this->contractQuery->getById($id);
        if (empty($contract)) {
            throw new NotFoundException('Contract Was Not Found');
        }
        if ($contract->buyer->id != $userId) {
            throw new UnAuthorizedException('Not Allowed');
        }
        $data = [
            'status' => ContractStatusEnum::Disputed
        ];
        return $this->contractQuery->update(id: $id, data: $data);
    }

    /**
     * @param int $id
     * @return int
     * @throws NotFoundException
     * @throws UnAuthorizedException
     */
    public function delete(int $id): int
    {
        $userId = Auth::id();
        $contract = $this->contractQuery->getById($id);
        if (empty($contract)) {
            throw new NotFoundException('Contract Was Not Found');
        }
        if ($contract->buyer->id != $userId) {
            throw new UnAuthorizedException('Not Allowed');
        }
        $data = [
            'status' => ContractStatusEnum::Deleted
        ];
        return $this->contractQuery->update(id: $id, data: $data);
    }
}
