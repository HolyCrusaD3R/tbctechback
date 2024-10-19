<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Product;
use App\Queries\ProductQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProductService
{
    private ProductQuery $productQuery;

    /**
     * @param ProductQuery $productQuery
     */
    public function __construct(ProductQuery $productQuery)
    {
        $this->productQuery = $productQuery;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->productQuery->getAll();
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getById(int $id): Product
    {
        return $this->productQuery->getById($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        return $this->productQuery->destroy($id);
    }

    /**
     * @param array $data
     * @return mixed
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function create(array $data): mixed
    {
        $product = DB::transaction(function () use ($data) {
            $data['user_id'] = Auth::id();
            $product = $this->productQuery->create(data: $data);
            $this->removeOldImages(product: $product);
            $this->addImages(product: $product, images: $data['images'] ?? []);
            return $product;
        });
        return $product->fresh();
    }

    /**
     * @param int $id
     * @param array $data
     * @return Product|null
     * @throws NotFoundException
     */
    public function update(int $id, array $data): ?Product
    {
        $product = $this->productQuery->getById(id: $id);
        if (empty($product)) {
            throw new NotFoundException();
        }
        DB::transaction(function () use ($id, $product, $data) {
            if (!empty($data['images'])) {
                $this->removeOldImages(product: $product);
                $this->addImages(product: $product, images: $data['images']);
            }
            unset($data['images']);
            $this->productQuery->update(id: $id, data: $data);
        });
        return $product->fresh();
    }

    /**
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    private function addImages(Product $product, array $images): void
    {
        foreach($images as $image) {
            $product->addMediaFromUrl($image)->toMediaCollection('images');
        }
    }

    /**
     * @param Product $product
     * @return void
     */
    private function removeOldImages(Product $product): void
    {
        $product->clearMediaCollection('images');
    }
}
