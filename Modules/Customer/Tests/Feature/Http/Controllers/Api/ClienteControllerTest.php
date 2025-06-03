<?php

declare(strict_types = 1);

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Support\Carbon;
use Modules\Cliente\Models\Cliente;

use function Pest\Faker\fake;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index behaves as expected', function (): void {
    $clientes = Cliente::factory()->count(3)->create();

    $response = get(route('clientes.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});

test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \Modules\Cliente\Http\Controllers\Api\V1\ClienteController::class,
        'store',
        \Modules\Cliente\Http\Requests\Api\V1\ClienteStoreRequest::class
    );

test('store saves', function (): void {
    $soft_delete      = fake()->word();
    $nome             = fake()->word();
    $email            = fake()->safeEmail();
    $telefone         = fake()->word();
    $data_nascimento  = Carbon::parse(fake()->date());
    $endereco         = fake()->word();
    $complemento      = fake()->word();
    $bairro           = fake()->word();
    $cep              = fake()->word();
    $data_cadastro    = Carbon::parse(fake()->dateTime());
    $data_atualizacao = Carbon::parse(fake()->dateTime());

    $response = post(route('clientes.store'), [
        'soft_delete'      => $soft_delete,
        'nome'             => $nome,
        'email'            => $email,
        'telefone'         => $telefone,
        'data_nascimento'  => $data_nascimento->toDateString(),
        'endereco'         => $endereco,
        'complemento'      => $complemento,
        'bairro'           => $bairro,
        'cep'              => $cep,
        'data_cadastro'    => $data_cadastro->toDateTimeString(),
        'data_atualizacao' => $data_atualizacao->toDateTimeString(),
    ]);

    $clientes = Cliente::query()
        ->where('soft_delete', $soft_delete)
        ->where('nome', $nome)
        ->where('email', $email)
        ->where('telefone', $telefone)
        ->where('data_nascimento', $data_nascimento)
        ->where('endereco', $endereco)
        ->where('complemento', $complemento)
        ->where('bairro', $bairro)
        ->where('cep', $cep)
        ->where('data_cadastro', $data_cadastro)
        ->where('data_atualizacao', $data_atualizacao)
        ->get();
    expect($clientes)->toHaveCount(1);
    $cliente = $clientes->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});

test('show behaves as expected', function (): void {
    $cliente = Cliente::factory()->create();

    $response = get(route('clientes.show', $cliente));

    $response->assertOk();
    $response->assertJsonStructure([]);
});

test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \Modules\Cliente\Http\Controllers\Api\V1\ClienteController::class,
        'update',
        \Modules\Cliente\Http\Requests\Api\V1\ClienteUpdateRequest::class
    );

test('update behaves as expected', function (): void {
    $cliente          = Cliente::factory()->create();
    $soft_delete      = fake()->word();
    $nome             = fake()->word();
    $email            = fake()->safeEmail();
    $telefone         = fake()->word();
    $data_nascimento  = Carbon::parse(fake()->date());
    $endereco         = fake()->word();
    $complemento      = fake()->word();
    $bairro           = fake()->word();
    $cep              = fake()->word();
    $data_cadastro    = Carbon::parse(fake()->dateTime());
    $data_atualizacao = Carbon::parse(fake()->dateTime());

    $response = put(route('clientes.update', $cliente), [
        'soft_delete'      => $soft_delete,
        'nome'             => $nome,
        'email'            => $email,
        'telefone'         => $telefone,
        'data_nascimento'  => $data_nascimento->toDateString(),
        'endereco'         => $endereco,
        'complemento'      => $complemento,
        'bairro'           => $bairro,
        'cep'              => $cep,
        'data_cadastro'    => $data_cadastro->toDateTimeString(),
        'data_atualizacao' => $data_atualizacao->toDateTimeString(),
    ]);

    $cliente->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($soft_delete)->toEqual($cliente->soft_delete);
    expect($nome)->toEqual($cliente->nome);
    expect($email)->toEqual($cliente->email);
    expect($telefone)->toEqual($cliente->telefone);
    expect($data_nascimento)->toEqual($cliente->data_nascimento);
    expect($endereco)->toEqual($cliente->endereco);
    expect($complemento)->toEqual($cliente->complemento);
    expect($bairro)->toEqual($cliente->bairro);
    expect($cep)->toEqual($cliente->cep);
    expect($data_cadastro->timestamp)->toEqual($cliente->data_cadastro);
    expect($data_atualizacao->timestamp)->toEqual($cliente->data_atualizacao);
});

test('destroy deletes and responds with', function (): void {
    $cliente = Cliente::factory()->create();

    $response = delete(route('clientes.destroy', $cliente));

    $response->assertNoContent();

    assertModelMissing($cliente);
});
