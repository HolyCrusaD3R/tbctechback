<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Requests\CreateProductRequest;
use App\Requests\UpdateProductRequest;
use App\Resources\ProductCollection;
use App\Resources\ProductResource;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{

    /**
     * @OA\Get(
     *  path="/api/products",
     *  tags={"Products"},
     *  summary="Get Products List",
     *  @OA\Response(
     *       response="200",
     *       description="success",
     *       @OA\JsonContent()
     *   ),
     *   @OA\Response(
     *       response="400",
     *       description="bad request",
     *       @OA\JsonContent()
     *   ),
     * )
     *
     * Get Product List
     *
     * @param ProductService $productService
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(ProductService $productService): JsonResponse|AnonymousResourceCollection
    {
        try {
            $productList = $productService->getAll();
            return ProductCollection::collection($productList);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Get(
     *  path="/api/products/{id}",
     *  tags={"Products"},
     *  summary="Get Products List",
     *  @OA\Parameter(
     *       name="id",
     *       in="path",
     *       description="id",
     *       example="",
     *       required=true,
     *   ),
     *  @OA\Response(
     *       response="200",
     *       description="success",
     *       @OA\JsonContent()
     *   ),
     *   @OA\Response(
     *       response="400",
     *       description="bad request",
     *       @OA\JsonContent()
     *   ),
     * )
     *
     * Get Product List
     *
     * @param int $id
     * @param ProductService $productService
     * @return JsonResponse|ProductResource
     */
    public function show(int $id, ProductService $productService): ProductResource|JsonResponse
    {
        try {
            $product = $productService->getById($id);
            return ProductResource::make($product);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/products/create",
     *  tags={"Products"},
     *  summary="Create a new product",
     *  security={{ "apiAuth": {} }},
     *  @OA\RequestBody(
     *      description="Create Product object",
     *      required=true,
     *      @OA\JsonContent(
     *      @OA\Property(property="title", type="string", format="text", example="Product"),
     *      @OA\Property(property="description", type="string", format="text", example="Description"),
     *      @OA\Property(property="price", type="integer", example=5000),
     *      @OA\Property(property="user_id", type="integer", example=1),
     *      @OA\Property(
     *          property="images",
     *          type="array",
     *          @OA\Items(type="string"),
     *          example={"https://i.imgur.com/onqNaQp.jpeg", "https://i.imgur.com/9Y66oxi.jpeg"}
     *      ),
     *   ),
     *  ),
     *  @OA\Response(
     *       response="200",
     *       description="success",
     *       @OA\JsonContent()
     *   ),
     *   @OA\Response(
     *       response="400",
     *       description="bad request",
     *       @OA\JsonContent()
     *   ),
     * )
     *
     * Create New Product
     *
     * @param CreateProductRequest $request
     * @param ProductService $productService
     * @return ProductResource|JsonResponse
     */
    public function create(CreateProductRequest $request, ProductService $productService): ProductResource|JsonResponse
    {
        try {
            $product = $productService->create($request->validated());
            return new ProductResource($product);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Patch(
     *  path="/api/products/update/{id}",
     *  tags={"Products"},
     *  summary="Create a new product",
     *  security={{ "apiAuth": {} }},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="id",
     *      example="",
     *      required=true,
     *  ),
     *  @OA\RequestBody(
     *      description="Create Product object",
     *      required=true,
     *      @OA\JsonContent(
     *      @OA\Property(property="title", type="string", format="text", example="Product"),
     *      @OA\Property(property="description", type="string", format="text", example="Description"),
     *      @OA\Property(property="price", type="integer", example=5000),
     *      @OA\Property(
     *          property="images",
     *          type="array",
     *          @OA\Items(type="string"),
     *          example={"https://i.imgur.com/onqNaQp.jpeg", "https://i.imgur.com/9Y66oxi.jpeg"}
     *      ),
     *   ),
     *  ),
     *  @OA\Response(
     *       response="200",
     *       description="success",
     *       @OA\JsonContent()
     *   ),
     *   @OA\Response(
     *       response="400",
     *       description="bad request",
     *       @OA\JsonContent()
     *   ),
     * )
     *
     * Create New Product
     *
     * @param int $id
     * @param UpdateProductRequest $request
     * @param ProductService $productService
     * @return ProductResource|JsonResponse
     */
    public function update(int $id, UpdateProductRequest $request, ProductService $productService): ProductResource|JsonResponse
    {
        try {
            $product = $productService->update($id, $request->validated());
            return new ProductResource($product);
        }catch (NotFoundException $exception) {
            return $this->notFound(exception: $exception);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Delete(
     *  path="/api/products/delete/{id}",
     *  tags={"Products"},
     *  summary="Delete Product",
     *  security={{ "apiAuth": {} }},
     *  @OA\Parameter(
     *       name="id",
     *       in="path",
     *       description="id",
     *       example="",
     *       required=true,
     *   ),
     *  @OA\Response(
     *       response="200",
     *       description="success",
     *       @OA\JsonContent()
     *   ),
     *   @OA\Response(
     *       response="400",
     *       description="bad request",
     *       @OA\JsonContent()
     *   ),
     * )
     *
     * Delete Product
     *
     * @param int $id
     * @param ProductService $productService
     * @return JsonResponse|ProductResource
     */
    public function destroy(int $id, ProductService $productService): ProductResource|JsonResponse
    {
        try {
            $productService->destroy($id);
            return $this->success('Product successfully deleted');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }
}
