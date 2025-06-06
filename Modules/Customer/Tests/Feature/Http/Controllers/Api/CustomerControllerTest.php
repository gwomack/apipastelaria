<?php

declare(strict_types = 1);

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Support\Carbon;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;
use Modules\Customer\Models\Customer;
use Illuminate\Support\Facades\Exceptions;
use Modules\Customer\Http\Requests\Api\V1\CustomerStoreRequest;
use Modules\Customer\Http\Controllers\Api\V1\CustomerController;
use Modules\Customer\Http\Requests\Api\V1\CustomerStoreRequest;
use Modules\Customer\Http\Requests\Api\V1\CustomerUpdateRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

it('index behaves as expected', function (): void {
    Customer::factory()->count(10)->create();

    $response = login()->get(route('api.customers.index'));

    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'nome',
                'email',
                'telefone',
                'data_nascimento',
                'endereco',
                'complemento',
            ],
        ],
    ]);
});

it('store uses form request validation')
    ->assertActionUsesFormRequest(
        CustomerController::class,
        'store',
        CustomerStoreRequest::class
    );

it('validates store appropriately', function (): void {
    //
    // checks for required fields
    //

    $response = login()->postJson(route('api.customers.store'), [
        'telefone'         => fake()->e164PhoneNumber,
        'data_nascimento'  => fake()->date,
        'endereco'         => fake()->address,
        'complemento'      => fake()->secondaryAddress,
        'bairro'           => fake()->word,
        'cep'              => fake()->postcode,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'nome',
        'email',
    ]);

    //
    // checks for unique fields
    //

    $email = fake()->safeEmail;

    $customer = Customer::factory()->create([
        'email' => $email,
    ]);

    $response = login()->postJson(route('api.customers.store'), [
        'nome'             => fake()->firstName,
        'email'            => $email,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'email',
    ]);

    //
    // checks for max length
    //

    $response = login()->postJson(route('api.customers.store'), [
        'nome'             => fake()->firstName . str_repeat('a', 256),
        'email'            => fake()->safeEmail . str_repeat('a', 256),
        'telefone'         => fake()->e164PhoneNumber . str_repeat('a', 256),
        'endereco'         => fake()->address . str_repeat('a', 256),
        'complemento'      => fake()->secondaryAddress . str_repeat('a', 256),
        'bairro'           => fake()->word . str_repeat('a', 256),
        'cep'              => fake()->postcode . str_repeat('a', 256),
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'nome',
        'email',
        'telefone',
        'endereco',
        'complemento',
        'bairro',
        'cep',
    ]);
});

it('stores a customer', function (): void {
    $email = fake()->safeEmail;

    // check if the customer already exists
    $customer = Customer::where('email', $email)->get();
    expect($customer)->toHaveCount(0);

    // create a customer
    $response = login()->postJson(route('api.customers.store'), [
        'nome'             => fake()->firstName,
        'email'            => $email,
        'telefone'         => fake()->e164PhoneNumber,
        'data_nascimento'  => fake()->date,
        'endereco'         => fake()->address,
        'complemento'      => fake()->secondaryAddress,
        'bairro'           => fake()->word,
        'cep'              => fake()->postcode,
    ]);

    $customer = Customer::where('email', $email)->get();
    expect($customer)->toHaveCount(1);
    expect($customer->first()->data_cadastro)->toBeInstanceOf(Carbon::class);

    $response->assertCreated();
    $response->assertJsonStructure([]);
});

it('show behaves as expected', function (): void {
    $customer = Customer::factory()->create();

    $response = login()->getJson(route('api.customers.show', $customer));

    $response->assertOk();
    $response->assertJsonStructure([]);
});

it('update uses form request validation')
    ->assertActionUsesFormRequest(
        CustomerController::class,
        'update',
        CustomerUpdateRequest::class
    );

it('update behaves as expected', function (): void {
    $customer        = Customer::factory()->create();
    $nome            = fake()->firstName;
    $email           = fake()->safeEmail;
    $telefone        = fake()->e164PhoneNumber;
    $data_nascimento = Carbon::parse(fake()->date);
    $endereco        = fake()->address;
    $complemento     = fake()->secondaryAddress;
    $bairro          = fake()->word;
    $cep             = fake()->postcode;

    $response = login()->putJson(route('api.customers.update', $customer), [
        'nome'             => $nome,
        'email'            => $email,
        'telefone'         => $telefone,
        'data_nascimento'  => $data_nascimento->toDateString(),
        'endereco'         => $endereco,
        'complemento'      => $complemento,
        'bairro'           => $bairro,
        'cep'              => $cep,
    ]);

    $customer->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($nome)->toEqual($customer->nome);
    expect($email)->toEqual($customer->email);
    expect($telefone)->toEqual($customer->telefone);
    expect($data_nascimento)->toEqual($customer->data_nascimento);
    expect($endereco)->toEqual($customer->endereco);
    expect($complemento)->toEqual($customer->complemento);
    expect($bairro)->toEqual($customer->bairro);
    expect($cep)->toEqual($customer->cep);
});

it('destroy deletes and responds with no content', function (): void {
    $customer = Customer::factory()->create();

    $response = login()->deleteJson(route('api.customers.destroy', $customer));

    $response->assertNoContent();

    expect($customer->refresh())->toBeSoftDeleted();
});

it('throws exception when customer not found', function () {
    Exceptions::fake();
    $notFoundId = 1000;

    $response = login()->getJson(route('api.customers.show', $notFoundId));

    $response->assertStatus(404);
    Exceptions::assertNotReported(NotFoundHttpException::class);

    $response = login()->putJson(route('api.customers.update', $notFoundId));

    $response->assertStatus(404);
    Exceptions::assertNotReported(NotFoundHttpException::class);
});
