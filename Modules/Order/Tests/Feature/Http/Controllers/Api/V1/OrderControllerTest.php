<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\post;
use Modules\Order\Models\Order;
use function Pest\Laravel\delete;
use Modules\Customer\Models\Customer;
use function Pest\Laravel\assertSoftDeleted;
use Modules\Order\Http\Requests\Api\V1\OrderUpdateRequest;
use Modules\Order\Http\Requests\Api\V1\OrderStoreRequest;
use Modules\Order\Http\Controllers\Api\V1\OrderController;

uses()->group('order');

it('index behaves as expected', function (): void {
    Order::factory(3)->create();

    $response = login()->get(route('api.orders.index'));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


it('store uses form request validation')
    ->assertActionUsesFormRequest(
        OrderController::class,
        'store',
        OrderStoreRequest::class
    );

it('saves when store is called', function (): void {
    $customer = Customer::factory()->create();

    $response = login()->post(route('api.orders.store'), [
        'customer_id' => $customer->id,
    ]);

    $orders = Order::query()
        ->where('customer_id', $customer->id)
        ->get();
    expect($orders)->toHaveCount(1);
    $order = $orders->first();

    $response->assertCreated();
    $response->assertJsonStructure([]);
});


it('show behaves as expected', function (): void {
    $order = Order::factory()->create();

    $response = login()->get(route('api.orders.show', $order));

    $response->assertOk();
    $response->assertJsonStructure([]);
});


it('update uses form request validation')
    ->assertActionUsesFormRequest(
        OrderController::class,
        'update',
        OrderUpdateRequest::class
    );

it('update behaves as expected', function (): void {
    $order = Order::factory()->create();
    $customer = Customer::factory()->create();

    $response = login()->put(route('api.orders.update', $order), [
        'customer_id' => $customer->id,
    ]);

    $order->refresh();

    $response->assertOk();
    $response->assertJsonStructure([]);

    expect($customer->id)->toEqual($order->customer_id);
});


it('destroy deletes and responds with', function (): void {
    $order = Order::factory()->create();

    $response = login()->delete(route('api.orders.destroy', $order));

    $response->assertNoContent();

    assertSoftDeleted($order);
});
