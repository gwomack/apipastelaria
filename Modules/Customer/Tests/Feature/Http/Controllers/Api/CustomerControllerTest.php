<?php

declare(strict_types = 1);

namespace Tests\Feature\Http\Controllers\Api;

use function Pest\Faker\fake;
use function Pest\Laravel\get;

use function Pest\Laravel\put;
use Illuminate\Support\Carbon;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;
use Modules\Customer\Models\Customer;
use Illuminate\Foundation\Testing\WithFaker;
use function Pest\Laravel\assertModelMissing;

uses(WithFaker::class);

it('index behaves as expected', function (): void {
    $customers = Customer::factory()->count(3)->create();

    $response = get(route('customers.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});

it('store uses form request validation')
    ->assertActionUsesFormRequest(
        \Modules\Customer\Http\Controllers\Api\V1\CustomerController::class,
        'store',
        \Modules\Customer\Http\Requests\Api\V1\CustomerStoreRequest::class
    );

it('store saves', function (): void {
    $customer = Customer::factory()->make();

    $response = login()->post(route('customers.store'), [
        'nome'             => $customer->nome,
        'email'            => $customer->email,
        'telefone'         => $customer->telefone,
        'data_nascimento'  => $customer->data_nascimento,
        'endereco'         => $customer->endereco,
        'complemento'      => $customer->complemento,
        'bairro'           => $customer->bairro,
        'cep'              => $customer->cep,
        'data_cadastro'    => $customer->data_cadastro,
    ]);

    // $response->dump();

    $customers = Customer::query()
        ->where('nome', $customer->nome)
        ->where('email', $customer->email)
        ->where('telefone', $customer->telefone)
        ->where('data_nascimento', $customer->data_nascimento->format('Y-m-d'))
        ->where('endereco', $customer->endereco)
        ->where('complemento', $customer->complemento)
        ->where('bairro', $customer->bairro)
        ->where('cep', $customer->cep)
        ->where('data_cadastro', $customer->data_cadastro->format('Y-m-d H:i:s'))
        ->get();

    expect($customers)->toHaveCount(1);

    $response->assertCreated();
    $response->assertJsonStructure([]);
});

it('show behaves as expected', function (): void {
    $customer = Customer::factory()->create();

    $response = get(route('customers.show', $customer));

    $response->assertOk();
    $response->assertJsonStructure([]);
});

it('update uses form request validation')
    ->assertActionUsesFormRequest(
        \Modules\Customer\Http\Controllers\Api\V1\CustomerController::class,
        'update',
        \Modules\Customer\Http\Requests\Api\V1\CustomerUpdateRequest::class
    );

it('update behaves as expected', function (): void {
    $customer          = Customer::factory()->create();
    $nome             = fake()->firstName;
    $email            = fake()->safeEmail;
    $telefone         = fake()->e164PhoneNumber;
    $data_nascimento  = Carbon::parse(fake()->date);
    $endereco         = fake()->word;
    $complemento      = fake()->word;
    $bairro           = fake()->word;
    $cep              = fake()->word;
    $data_cadastro    = Carbon::parse(fake()->dateTime);

    $response = login()->put(route('customers.update', $customer), [
        'nome'             => $nome,
        'email'            => $email,
        'telefone'         => $telefone,
        'data_nascimento'  => $data_nascimento->toDateString(),
        'endereco'         => $endereco,
        'complemento'      => $complemento,
        'bairro'           => $bairro,
        'cep'              => $cep,
        'data_cadastro'    => $data_cadastro->toDateTimeString(),
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
    expect($data_cadastro->toDateTimeString())->toEqual($customer->data_cadastro);
});

it('destroy deletes and responds with', function (): void {
    $customer = Customer::factory()->create();

    $response = login()->delete(route('customers.destroy', $customer));

    $response->assertNoContent();

    assertModelMissing($customer);
});
