<?php

declare(strict_types = 1);

namespace Modules\Customer\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'nome'             => ['required', 'max:255'],
            'email'            => ['required', 'email', 'unique:customers,email', 'max:255'],
            'telefone'         => ['max:255', 'nullable'],
            'data_nascimento'  => ['date', 'date_format:Y-m-d', 'nullable'],
            'endereco'         => ['max:255', 'nullable'],
            'complemento'      => ['max:255', 'nullable'],
            'bairro'           => ['max:255', 'nullable'],
            'cep'              => ['max:255', 'nullable'],
            'data_cadastro'    => ['date', 'date_format:Y-m-d H:i:s', 'nullable'],
        ];
    }
}
