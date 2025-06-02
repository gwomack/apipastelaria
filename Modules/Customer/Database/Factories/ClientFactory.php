<?php

namespace Modules\Client\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Client\Models\Client;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

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
