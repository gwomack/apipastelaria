<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use function Pest\Faker\fake;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;
use Modules\Product\Models\Product;
use Modules\Customer\Models\Customer;
use Modules\Product\Models\ProductCategory;
use function Pest\Laravel\assertSoftDeleted;
use Modules\Product\Http\Requests\Api\V1\ProductStoreRequest;
use Modules\Product\Http\Controllers\Api\V1\ProductController;
use Modules\Product\Http\Requests\Api\V1\ProductUpdateRequest;

uses()->group('product');

it('index behaves as expected', function (): void {
    $products = Product::factory()->count(3)->create();

    $response = login()->get(route('api.products.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


it('store uses form request validation')
    ->assertActionUsesFormRequest(
        ProductController::class,
        'store',
        ProductStoreRequest::class
    );

it('store saves', function (): void {
    $nome = fake()->word();
    $preco = fake()->numberBetween(-10000, 10000);
    $foto = fake()->word();
    $customer = Customer::factory()->create();
    $product_category = ProductCategory::factory()->create();

    $response = login()->post(route('api.products.store'), [
        'nome' => $nome,
        'preco' => $preco,
        'foto' => $foto,
        'customer_id' => $customer->id,
        'product_category_id' => $product_category->id,
    ]);

    $products = Product::query()
        ->where('nome', $nome)
        ->where('preco', $preco)
        ->where('foto', $foto)
        ->where('customer_id', $customer->id)
        ->where('product_category_id', $product_category->id)
        ->get();
    expect($products)->toHaveCount(1);
    $product = $products->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});


it('show behaves as expected', function (): void {
    $product = Product::factory()->create();

    $response = login()->get(route('api.products.show', $product));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


it('update uses form request validation')
    ->assertActionUsesFormRequest(
    ProductController::class,
        'update',
        ProductUpdateRequest::class
    );

it('update behaves as expected', function (): void {
    $product = Product::factory()->create();
    $nome = fake()->word();
    $preco = fake()->numberBetween(-10000, 10000);
    $foto = fake()->word();
    $customer = Customer::factory()->create();
    $product_category = ProductCategory::factory()->create();

    $response = login()->put(route('api.products.update', $product), [
        'nome' => $nome,
        'preco' => $preco,
        'foto' => $foto,
        'customer_id' => $customer->id,
        'product_category_id' => $product_category->id,
    ]);

    $product->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($nome)->toEqual($product->nome);
    expect($preco)->toEqual($product->preco);
    expect($foto)->toEqual($product->foto);
    expect($customer->id)->toEqual($product->customer_id);
    expect($product_category->id)->toEqual($product->product_category_id);
});


it('destroy deletes and responds with', function (): void {
    $product = Product::factory()->create();

    $response = login()->delete(route('api.products.destroy', $product));

    $response->assertNoContent();

    assertSoftDeleted($product);
});
