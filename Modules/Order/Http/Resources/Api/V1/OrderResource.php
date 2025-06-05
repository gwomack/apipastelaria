<?php

namespace Modules\Order\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Http\Resources\Api\V1\ProductCollection;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'products' => ProductCollection::make($this->whenLoaded('products')),
        ];
    }
}
