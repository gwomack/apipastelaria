<?php

declare(strict_types = 1);

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\ProductCategory;

class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nome'      => fake()->word(),
            'descricao' => fake()->word(),
        ];
    }
}
