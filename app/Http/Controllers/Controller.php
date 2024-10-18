<?php

namespace App\Http\Controllers;


use App\Supports\ResponseSupport;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Playground API",
 *     description="Playground API Description"
 * )
 *
 * @OAS\SecurityScheme(
 *   securityScheme="bearer_token",
 *   type="http",
 *   scheme="bearer"
 *
 * @OA\SecurityScheme(
 *      type="http",
 *      description="Login with email and password to get the authentication token",
 *      name="Token based Based",
 *      in="header",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      securityScheme="apiAuth",
 *  )
 */
abstract class Controller
{
    use ResponseSupport;
}
