<?php

declare(strict_types = 1);

namespace Modules\Product\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nome'                => ['required', 'string'],
            'preco'               => ['required', 'integer'],
            'foto'                => ['required', 'string'],
            'customer_id'         => ['required', 'integer', 'exists:customers,id'],
            'order_id'            => ['required', 'integer', 'exists:orders,id'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
        ];
    }
}
