<?php

namespace App\Supports;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseSupport
{
    /**
     * @param Exception $exception
     * @param $code
     * @return JsonResponse
     */
    protected function unauthorized(Exception $exception, $code = null): JsonResponse
    {
        return response()->json(['message' => $exception->getMessage()], $code ?? Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Exception $exception
     * @param $code
     * @return JsonResponse
     */
    protected function forbidden(Exception $exception, $code = null): JsonResponse
    {
        return response()->json(['message' => $exception->getMessage()], $code ?? Response::HTTP_FORBIDDEN);
    }

    /**
     * @param Exception $exception
     * @param $code
     * @return JsonResponse
     */
    protected function error(Exception $exception, $code = null): JsonResponse
    {
        return response()->json(['message' => $exception->getMessage()], $code ?? Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param Exception $exception
     * @param $code
     * @return JsonResponse
     */
    protected function notFound(Exception $exception, $code = null): JsonResponse
    {
        $message = !empty($exception->getMessage()) ? $exception->getMessage() : 'Not Found';
        return response()->json(['message' => $message], $code ?? Response::HTTP_NOT_FOUND);
    }

    /**
     * @param Exception $exception
     * @param $code
     * @return JsonResponse
     */
    protected function methodNotAllowed(Exception $exception, $code = null): JsonResponse
    {
        $message = !empty($exception->getMessage()) ? $exception->getMessage() : 'Method Not Allowed';
        return response()->json(['message' => $message], $code ?? Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * @param Exception $exception
     * @param null $code
     * @return JsonResponse
     */
    protected function validation(Exception $exception, $code = null): JsonResponse
    {
        return response()->json(['message' => $exception->getMessage()], $code ?? Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function success(string $message = 'success'): JsonResponse
    {
        return response()->json(['message' => $message], Response::HTTP_OK);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    protected function created(?array $data): JsonResponse
    {
        $message = !empty($data) ? $data : 'success';
        return response()->json($message, Response::HTTP_CREATED);
    }
}
