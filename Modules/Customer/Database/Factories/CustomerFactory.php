<?php

declare(strict_types = 1);

namespace Modules\Customer\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Customer\Models\Customer;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nome'             => fake()->name(),
            'email'            => fake()->safeEmail(),
            'telefone'         => fake()->phoneNumber(),
            'data_nascimento'  => fake()->date(),
            'endereco'         => fake()->address(),
            'complemento'      => fake()->secondaryAddress(),
            'bairro'           => fake()->word(),
            'cep'              => fake()->postcode(),
            'data_cadastro'    => fake()->dateTime(),
        ];
    }
}
