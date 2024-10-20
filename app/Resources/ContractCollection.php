<?php

namespace App\Resources;

use App\Enums\ContractStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractCollection extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
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
                'price' => $this->product->price,
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
            'created_at' => $this->created_at
        ];
    }
}
