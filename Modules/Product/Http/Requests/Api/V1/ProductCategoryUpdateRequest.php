<?php

namespace Modules\Product\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryUpdateRequest extends FormRequest
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
            'nome' => ['nullable', 'string'],
            'descricao' => ['nullable', 'string'],
        ];
    }
}
