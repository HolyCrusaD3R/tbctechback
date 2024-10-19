<?php

namespace App\Queries;


use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductQuery
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return Product::query()->create($data);
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function getById(int $id): ?Product
    {
        return Product::query()
            ->where('id', $id)
            ->first();
    }

    /**
     * @param int $id
     * @param array $data
     * @return int
     */
    public function update(int $id, array $data): int
    {
        return Product::query()
            ->where('id', $id)
            ->update($data);
    }

}
