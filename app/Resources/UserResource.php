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
            'received_contracts' => !empty($this->received_contracts) ? ContractCollection::collection($this->received_contracts) : null,
            'issued_contracts' => !empty($this->issued_contracts) ? ContractCollection::collection($this->issued_contracts) : null,
        ];
    }
}
