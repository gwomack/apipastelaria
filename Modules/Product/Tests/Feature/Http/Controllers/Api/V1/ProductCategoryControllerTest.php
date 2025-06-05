<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use function Pest\Faker\fake;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;
use Modules\Product\Models\ProductCategory;
use function Pest\Laravel\assertSoftDeleted;
use Modules\Product\Http\Requests\Api\V1\ProductCategoryStoreRequest;
use Modules\Product\Http\Controllers\Api\V1\ProductCategoryController;
use Modules\Product\Http\Requests\Api\V1\ProductCategoryUpdateRequest;

uses()->group('product');

it('index behaves as expected', function (): void {
    $productCategories = ProductCategory::factory()->count(3)->create();

    $response = login()->get(route('api.product-categories.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


it('store uses form request validation')
    ->assertActionUsesFormRequest(
ProductCategoryController::class,
        'store',
ProductCategoryStoreRequest::class
    );

it('store saves', function (): void {
    $nome = fake()->word();
    $descricao = fake()->word();

    $response = login()->post(route('api.product-categories.store'), [
        'nome' => $nome,
        'descricao' => $descricao,
    ]);

    $productCategories = ProductCategory::query()
        ->where('nome', $nome)
        ->where('descricao', $descricao)
        ->get();
    expect($productCategories)->toHaveCount(1);
    $productCategory = $productCategories->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});


it('show behaves as expected', function (): void {
    $productCategory = ProductCategory::factory()->create();

    $response = login()->get(route('api.product-categories.show', $productCategory));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


it('update uses form request validation')
    ->assertActionUsesFormRequest(
ProductCategoryController::class,
        'update',
ProductCategoryUpdateRequest::class
    );

it('update behaves as expected', function (): void {
    $productCategory = ProductCategory::factory()->create();
    $nome = fake()->word();
    $descricao = fake()->word();

    $response = login()->put(route('api.product-categories.update', $productCategory), [
        'nome' => $nome,
        'descricao' => $descricao,
    ]);

    $productCategory->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($nome)->toEqual($productCategory->nome);
    expect($descricao)->toEqual($productCategory->descricao);
});


it('destroy deletes and responds with', function (): void {
    $productCategory = ProductCategory::factory()->create();

    $response = login()->delete(route('api.product-categories.destroy', $productCategory));

    $response->assertNoContent();

    assertSoftDeleted($productCategory);
});
