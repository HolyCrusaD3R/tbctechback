<?php

namespace App\Services;

use App\Enums\ContractStatusEnum;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnAuthorizedException;
use App\Exceptions\ValidationException;
use App\Models\Contract;
use App\Queries\ContractQuery;
use App\Queries\ProductQuery;
use App\Queries\UserQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractService
{
    private ContractQuery $contractQuery;
    private ProductQuery $productQuery;
    private UserQuery $userQuery;

    /**
     * @param ProductQuery $productQuery
     * @param ContractQuery $contractQuery
     * @param UserQuery $userQuery
     */
    public function __construct(ProductQuery $productQuery, ContractQuery $contractQuery, UserQuery $userQuery)
    {
        $this->productQuery = $productQuery;
        $this->contractQuery = $contractQuery;
        $this->userQuery = $userQuery;
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
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function create(array $data): mixed
    {
        $product = $this->productQuery->getById($data['product_id']);
        $data['buyer_id'] = Auth::id();
        $data['amount'] = $product->price;
        $user = $this->userQuery->getUserById(id: $data['buyer_id']);
        if ($product['user_id'] === Auth::id()) {
            throw new ValidationException('You Cannot Form A Contract With Yourself');
        }
        if ($user->balance < $product['price']) {
            throw new ValidationException('Insufficient Balance');
        }
        return DB::transaction(function () use ($product, $data, $user) {
            $data['status'] = ContractStatusEnum::Sent;
            $this->userQuery->updateBalanceById(id: $user->id, balance: $user->balance - $product->price);
            return $this->contractQuery->create(data: $data);
        });
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

        $seller = $this->userQuery->getUserById($contract->product->user_id);
        return DB::transaction(function () use ($id, $userId, $contract, $seller) {
            $data = [
                'status' => ContractStatusEnum::Successful
            ];
            if ($contract->status != ContractStatusEnum::Successful->value){
                $this->userQuery->updateBalanceById(id: $seller->id, balance: $seller->balance + $contract->product->price);
            }
            return $this->contractQuery->update(id: $id, data: $data);
        });
    }

    /**
     * @param int $id
     * @return int
     * @throws NotFoundException
     * @throws UnAuthorizedException
     */
    public function accept(int $id): int
    {
        $userId = Auth::id();
        $contract = $this->contractQuery->getById($id);
        if (empty($contract)) {
            throw new NotFoundException('Contract Was Not Found');
        }
        if ($contract->product->user_id != $userId) {
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
    public function reject(int $id): int
    {
        $userId = Auth::id();
        $contract = $this->contractQuery->getById($id);
        if (empty($contract)) {
            throw new NotFoundException('Contract Was Not Found');
        }
        if ($contract->product->user_id != $userId) {
            throw new UnAuthorizedException('Not Allowed');
        }
        $buyer = $this->userQuery->getUserById($contract->buyer_id);
        return DB::transaction(function () use ($id, $userId, $contract, $buyer) {
            $this->userQuery->updateBalanceById(id: $buyer->id, balance: $buyer->balance + $contract->product->price);
            return $this->contractQuery->destroy(id: $id);
        });
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
        if ($contract->buyer_id != $userId) {
            throw new UnAuthorizedException('Not Allowed');
        }
        $buyer = $this->userQuery->getUserById($contract->buyer_id);
        return DB::transaction(function () use ($id, $userId, $contract, $buyer) {
            $this->userQuery->updateBalanceById(id: $buyer->id, balance: $buyer->balance + $contract->product->price);
            return $this->contractQuery->destroy(id: $id);
        });
    }
}
