<?php

namespace Modules\Product\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Http\Requests\Api\V1\UploadFileRequest;

class ProductStoreRequest extends UploadFileRequest
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
            'nome' => ['required', 'string'],
            'preco' => ['required', 'numeric'],
            'foto' => ['required', 'image', 'mimes:png,jpg,webp', 'max:2048'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
        ];
    }
}
