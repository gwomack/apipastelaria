<?php

declare(strict_types = 1);

namespace Modules\Customer\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'nome'             => $this->nome,
            'email'            => $this->email,
            'telefone'         => $this->telefone,
            'data_nascimento'  => $this->data_nascimento,
            'endereco'         => $this->endereco,
            'complemento'      => $this->complemento,
            'bairro'           => $this->bairro,
            'cep'              => $this->cep,
            'data_cadastro'    => $this->data_cadastro,
            'data_atualizacao' => $this->data_atualizacao,
        ];
    }
}
