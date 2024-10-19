<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Requests\CreateProductRequest;
use App\Requests\UpdateProductRequest;
use App\Resources\ProductCollection;
use App\Resources\ProductResource;
use App\Resources\UserResource;
use App\Resources\WhoAmIResource;
use App\Services\ProductService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/users/whoami",
     *     tags={"User"},
     *     summary="Get user info",
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation",
     *         @OA\JsonContent()
     *     ),
     * )
     * Get user info
     *
     * @param UserService $userService
     * @return JsonResponse|WhoAmIResource
     */
    public function whoami(UserService $userService): JsonResponse|WhoAmIResource
    {
        try {
            $user = $userService->getUserInfo();
            return WhoAmIResource::make($user);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/dashboard",
     *     tags={"User"},
     *     summary="Get user info",
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation",
     *         @OA\JsonContent()
     *     ),
     * )
     * Get user info
     *
     * @param UserService $userService
     * @return JsonResponse|UserResource
     */
    public function dashboard(UserService $userService): JsonResponse|UserResource
    {
        try {
            $user = $userService->getUserInfo();
            return UserResource::make($user);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }
}
