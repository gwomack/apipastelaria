<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Customer\Models\Customer;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductCategory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->word(),
            'preco' => fake()->numberBetween(-10000, 10000),
            'foto' => fake()->word(),
            'customer_id' => Customer::factory(),
            'product_category_id' => ProductCategory::factory(),
        ];
    }
}
