<?php

namespace App\Http\Controllers;

use App\Requests\CreateContractRequest;
use App\Resources\ContractResource;
use App\Services\ContractService;
use Exception;
use Illuminate\Http\JsonResponse;

class ContractController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/contracts/{id}",
     *  tags={"Contracts"},
     *  summary="Get Contracts List",
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
     * Get Product List
     *
     * @param int $id
     * @param ContractService $contractService
     * @return ContractResource|JsonResponse
     */
    public function show(int $id, ContractService $contractService): JsonResponse|ContractResource
    {
        try {
            $contract = $contractService->getById($id);
            return ContractResource::make($contract);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/contracts/create",
     *  tags={"Contracts"},
     *  summary="Create a new product",
     *  security={{ "apiAuth": {} }},
     *  @OA\RequestBody(
     *      description="Create Product object",
     *      required=true,
     *      @OA\JsonContent(
     *      @OA\Property(property="conditions", type="string", format="text", example="Conditions"),
     *      @OA\Property(property="amount", type="integer", example=5000),
     *      @OA\Property(property="product_id", type="integer", example=1),
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
     * @param CreateContractRequest $request
     * @param ContractService $contractService
     * @return ContractResource|JsonResponse
     */
    public function create(CreateContractRequest $request, ContractService $contractService): ContractResource|JsonResponse
    {
        try {
            $contract = $contractService->create($request->validated());
            return ContractResource::make($contract);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/contracts/accept/{id}",
     *  tags={"Contracts"},
     *  summary="Accept Contract",
     *  security={{ "apiAuth": {} }},
     *  @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="id",
     *        example="",
     *        required=true,
     *    ),
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
     * Accept Contract
     *
     * @param int $id
     * @param ContractService $contractService
     * @return ContractResource|JsonResponse
     */
    public function accept(int $id, ContractService $contractService): ContractResource|JsonResponse
    {
        try {
            $contractService->accept($id);
            return $this->success('Contract Was Accepted');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/contracts/reject/{id}",
     *  tags={"Contracts"},
     *  summary="Reject Contract",
     *  security={{ "apiAuth": {} }},
     *  @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="id",
     *        example="",
     *        required=true,
     *    ),
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
     * Reject Contract
     *
     * @param int $id
     * @param ContractService $contractService
     * @return ContractResource|JsonResponse
     */
    public function reject(int $id, ContractService $contractService): ContractResource|JsonResponse
    {
        try {
            $contractService->reject($id);
            return $this->success('Contract Was Rejected');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/contracts/complete/{id}",
     *  tags={"Contracts"},
     *  summary="Complete Contract",
     *  security={{ "apiAuth": {} }},
     *  @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="id",
     *        example="",
     *        required=true,
     *    ),
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
     * Complete Contract
     *
     * @param int $id
     * @param ContractService $contractService
     * @return ContractResource|JsonResponse
     */
    public function complete(int $id, ContractService $contractService): ContractResource|JsonResponse
    {
        try {
            $contractService->complete($id);
            return $this->success('Contract Was Completed');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/contracts/dispute/{id}",
     *  tags={"Contracts"},
     *  summary="Dispute Contract",
     *  security={{ "apiAuth": {} }},
     *  @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="id",
     *        example="",
     *        required=true,
     *    ),
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
     * Dispute Contract
     *
     * @param int $id
     * @param ContractService $contractService
     * @return ContractResource|JsonResponse
     */
    public function dispute(int $id, ContractService $contractService): ContractResource|JsonResponse
    {
        try {
            $contractService->dispute($id);
            return $this->success('Contract Was Disputed');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Delete(
     *  path="/api/contracts/delete/{id}",
     *  tags={"Contracts"},
     *  summary="Complete Contract",
     *  security={{ "apiAuth": {} }},
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         example="",
     *         required=true,
     *     ),
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
     * Delete Contract
     *
     * @param int $id
     * @param ContractService $contractService
     * @return ContractResource|JsonResponse
     */
    public function destroy(int $id, ContractService $contractService): ContractResource|JsonResponse
    {
        try {
            $contractService->destroy($id);
            return $this->success('Contract Was Deleted');
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }
}
