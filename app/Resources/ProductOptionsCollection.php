<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionsCollection extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'images' => $this->all_media
        ];
    }
}
