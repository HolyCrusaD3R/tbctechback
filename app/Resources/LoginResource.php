<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'access_token' => $this['access_token'],
            'token_type' => $this['token_type'],
            'expires_in' => $this['expires_in'],
        ];
    }
}
