<?php

namespace Modules\Cliente\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Cliente\Models\Cliente;

class ClienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->word(),
            'email' => fake()->safeEmail(),
            'telefone' => fake()->word(),
            'data_nascimento' => fake()->date(),
            'endereco' => fake()->word(),
            'complemento' => fake()->word(),
            'bairro' => fake()->word(),
            'cep' => fake()->word(),
            'data_cadastro' => fake()->dateTime(),
            'data_atualizacao' => fake()->dateTime(),
        ];
    }
}
