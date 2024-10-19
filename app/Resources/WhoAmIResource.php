<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WhoAmIResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'balance' => $this->balance,
        ];
    }
}
