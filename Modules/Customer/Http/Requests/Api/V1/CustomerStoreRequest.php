<?php

declare(strict_types = 1);

namespace Modules\Customer\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            'nome'             => ['required', 'string'],
            'email'            => ['required', 'email'],
            'telefone'         => ['string'],
            'data_nascimento'  => ['date'],
            'endereco'         => ['string'],
            'complemento'      => ['string'],
            'bairro'           => ['string'],
            'cep'              => ['string'],
            'data_cadastro'    => [],
        ];
    }
}
