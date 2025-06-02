<?php

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
            'nome' => ['required', 'string'],
            'email' => ['required', 'email'],
            'telefone' => ['required', 'string'],
            'data_nascimento' => ['required', 'date'],
            'endereco' => ['required', 'string'],
            'complemento' => ['required', 'string'],
            'bairro' => ['required', 'string'],
            'cep' => ['required', 'string'],
            'data_cadastro' => ['required'],
            'data_atualizacao' => ['required'],
        ];
    }
}
