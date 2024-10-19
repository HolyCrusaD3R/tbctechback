<?php

namespace App\Services;

use App\Exceptions\ValidationException;

class LoginService
{
    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws ValidationException
     */
    public function handle(string $email, string $password): array
    {
        return $this->login(email: $email, password: $password);
    }

    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws ValidationException
     */
    public function login(string $email, string $password): array
    {
        $token = auth()->attempt([
            'email' => $email,
            'password' => $password,
        ]);
        if (!$token) {
            throw new ValidationException('Wrong User Or Password');
        }

        return self::respondWithToken($token);
    }

    /**
     *
     * Get the token array structure.
     *
     * @param $token
     * @return array
     */
    public static function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }

    /**
     * Refresh and Get new access token
     *
     * @return array
     */
    public function refreshToken(): array
    {
        $token = auth()->refresh();
        return $this->respondWithToken($token);
    }
}
