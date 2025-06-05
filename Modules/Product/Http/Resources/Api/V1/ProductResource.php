<?php

namespace Modules\Product\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\Http\Resources\Api\V1\OrderCollection;
use Modules\Product\Http\Resources\Api\V1\ProductCategoryResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'preco' => $this->preco,
            'foto' => $this->foto,
            // 'customer_id' => $this->customer_id,
            // 'product_category_id' => $this->product_category_id,
            'productCategory' => ProductCategoryResource::make($this->whenLoaded('productCategory')),
            'orders' => OrderCollection::make($this->whenLoaded('orders')),
        ];
    }
}
