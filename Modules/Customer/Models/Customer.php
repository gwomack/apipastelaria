<?php

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'soft_delete',
        'nome',
        'email',
        'telefone',
        'data_nascimento',
        'endereco',
        'complemento',
        'bairro',
        'cep',
        'data_cadastro',
        'data_atualizacao',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'data_nascimento' => 'date',
            'data_cadastro' => 'timestamp',
            'data_atualizacao' => 'timestamp',
        ];
    }

    // public function pedidos(): HasMany
    // {
    //     return $this->hasMany(Pedido::class);
    // }

    // public function produtos(): HasMany
    // {
    //     return $this->hasMany(Produto::class);
    // }
}
