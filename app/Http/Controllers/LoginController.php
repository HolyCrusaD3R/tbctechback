<?php

namespace App\Http\Controllers;


use App\Requests\LoginRequest;
use App\Resources\LoginResource;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Services\LoginService;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    /**
     * @OA\Post(
     *  path="/api/auth/login",
     *  tags={"Authentification"},
     *  summary="Get a JWT access token via given credentials.",
     *  @OA\RequestBody(
     *      description="Create user object",
     *      required=true,
     *      @OA\JsonContent(
     *      @OA\Property(property="email", type="string", format="text", example="dato@gmail.com"),
     *      @OA\Property(property="password", type="string", format="text", example="123456"),
     *  ),
     *  ),
     *  @OA\Response(
     *      response="200",
     *      description="success",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(
     *      response="400",
     *      description="bad request",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(
     *      response="422",
     *      description="validation",
     *      @OA\JsonContent()
     *  ),
     * )
     *
     * Get a JWT access token via given credentials.
     *
     * @param LoginRequest $request
     * @param LoginService $loginService
     * @return LoginResource|JsonResponse
     */
    public function login(LoginRequest $request, LoginService $loginService): LoginResource|JsonResponse
    {
        try {
            $data = $loginService->handle(
                email: $request->get('email'),
                password: $request->get('password')
            );
            return new LoginResource($data);
        } catch (ValidationException $exception) {
            return $this->validation($exception);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/auth/refresh-token",
     *  tags={"Authentification"},
     *  summary="Get new JWT access token",
     *  security={{ "apiAuth": {} }},
     *  @OA\Response(
     *      response="200",
     *      description="success",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(
     *      response="400",
     *      description="bad request",
     *      @OA\JsonContent()
     *  ),
     * )
     *
     * Get new JWT access token
     *
     * @param LoginService $loginService
     * @return LoginResource|JsonResponse
     */
    public function refreshToken(LoginService $loginService): LoginResource|JsonResponse
    {
        try {
            $token = $loginService->refreshToken();
            return new LoginResource($token);
        } catch (Exception $exception) {
            return $this->error($exception);
        }
    }
}
