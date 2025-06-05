<?php

namespace Modules\Product\Http\Requests\Api\V1;

use Modules\Product\Http\Requests\Api\V1\UploadFileRequest;

class ProductUpdateRequest extends UploadFileRequest
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
        $this->prepareForValidation($fieldName = 'foto');

        return [
            'nome' => ['nullable', 'string'],
            'preco' => ['nullable', 'numeric'],
            'foto' => ['nullable', 'image', 'mimes:png,jpg,webp', 'max:2048'],
            'product_category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
        ];
    }
}
