<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'balance' => $this->balance,
            'products' => !empty($this->products) ? ProductOptionsCollection::collection($this->products) : null,
        ];
    }
}
