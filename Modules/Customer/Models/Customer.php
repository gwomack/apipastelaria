<?php

declare(strict_types = 1);

namespace Modules\Customer\Models;

use Artisan;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\Database\Factories\CustomerFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Customer extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, SoftDeletes, HasApiTokens, Notifiable;

    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'data_nascimento',
        'endereco',
        'complemento',
        'bairro',
        'cep',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id'               => 'integer',
            'data_nascimento'  => 'date',
            'data_cadastro'    => 'datetime',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // create token when customer is created
        static::created(function ($model) {
            $model->token = $model->createToken(config('customer.token_name'))->plainTextToken;
        });
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CustomerFactory::new();
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
