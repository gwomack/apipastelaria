<?php

declare(strict_types = 1);

namespace Modules\Product\Tests\Feature\Http\Controllers\Api;

use Modules\Product\Models\Customer;
use Modules\Product\Models\Order;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductCategory;

use function Pest\Faker\fake;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index behaves as expected', function (): void {
    $products = Product::factory()->count(3)->create();

    $response = get(route('products.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});

test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \Modules\Product\Http\Controllers\Api\ProductController::class,
        'store',
        \Modules\Product\Http\Requests\Api\ProductStoreRequest::class
    );

test('store saves', function (): void {
    $nome             = fake()->word();
    $preco            = fake()->numberBetween(-10000, 10000);
    $foto             = fake()->word();
    $customer         = Customer::factory()->create();
    $order            = Order::factory()->create();
    $product_category = ProductCategory::factory()->create();

    $response = post(route('products.store'), [
        'nome'                => $nome,
        'preco'               => $preco,
        'foto'                => $foto,
        'customer_id'         => $customer->id,
        'order_id'            => $order->id,
        'product_category_id' => $product_category->id,
    ]);

    $products = Product::query()
        ->where('nome', $nome)
        ->where('preco', $preco)
        ->where('foto', $foto)
        ->where('customer_id', $customer->id)
        ->where('order_id', $order->id)
        ->where('product_category_id', $product_category->id)
        ->get();
    expect($products)->toHaveCount(1);
    $product = $products->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});

test('show behaves as expected', function (): void {
    $product = Product::factory()->create();

    $response = get(route('products.show', $product));

    $response->assertOk();
    $response->assertJsonStructure([]);
});

test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \Modules\Product\Http\Controllers\Api\ProductController::class,
        'update',
        \Modules\Product\Http\Requests\Api\ProductUpdateRequest::class
    );

test('update behaves as expected', function (): void {
    $product          = Product::factory()->create();
    $nome             = fake()->word();
    $preco            = fake()->numberBetween(-10000, 10000);
    $foto             = fake()->word();
    $customer         = Customer::factory()->create();
    $order            = Order::factory()->create();
    $product_category = ProductCategory::factory()->create();

    $response = put(route('products.update', $product), [
        'nome'                => $nome,
        'preco'               => $preco,
        'foto'                => $foto,
        'customer_id'         => $customer->id,
        'order_id'            => $order->id,
        'product_category_id' => $product_category->id,
    ]);

    $product->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($nome)->toEqual($product->nome);
    expect($preco)->toEqual($product->preco);
    expect($foto)->toEqual($product->foto);
    expect($customer->id)->toEqual($product->customer_id);
    expect($order->id)->toEqual($product->order_id);
    expect($product_category->id)->toEqual($product->product_category_id);
});

test('destroy deletes and responds with', function (): void {
    $product = Product::factory()->create();

    $response = delete(route('products.destroy', $product));

    $response->assertNoContent();

    assertSoftDeleted($product);
});
