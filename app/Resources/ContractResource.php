<?php

namespace App\Resources;

use App\Enums\ContractStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'conditions' => $this->conditions,
            'amount' => $this->amount,
            'status' => ContractStatusEnum::from($this->status)->name,
            'product' => [
                'id' => $this->product->id,
                'title' => $this->product->title,
                'images' => $this->product->all_media,
                'user' => [
                    'id' => $this->product->user->id,
                    'name' => $this->product->user->name,
                ]
            ],
            'buyer' => [
                'id' => $this->buyer->id,
                'name' => $this->buyer->name
            ],
        ];
    }
}
