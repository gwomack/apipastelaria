<?php

declare(strict_types = 1);

namespace Modules\Product\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'nome'                => $this->nome,
            'preco'               => $this->preco,
            'foto'                => $this->foto,
            'customer_id'         => $this->customer_id,
            'order_id'            => $this->order_id,
            'product_category_id' => $this->product_category_id,
            'productCategory'     => ProductCategoryResource::make($this->whenLoaded('productCategory')),
        ];
    }
}
