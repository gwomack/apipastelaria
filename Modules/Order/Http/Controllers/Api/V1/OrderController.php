<?php

namespace Modules\Order\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Order\Http\Requests\Api\V1\OrderStoreRequest;
use Modules\Order\Http\Requests\Api\V1\OrderUpdateRequest;
use Modules\Order\Http\Resources\Api\V1\OrderCollection;
use Modules\Order\Http\Resources\Api\V1\OrderResource;
use Modules\Order\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request): OrderCollection
    {
        $orders = Order::paginate(config('order.per_page'));

        return new OrderCollection($orders);
    }

    public function store(OrderStoreRequest $request): OrderResource
    {
        $data = $request->safe()->except('products');

        $data['products'] = collect($request->input('products'))->mapWithKeys(function ($item) {
            return [$item['id'] => ['quantity' => $item['quantity']]];
        })->toArray();

        $order = Order::create($data);

        $order->products()->attach($data['products']);

        $order->load('products');

        return new OrderResource($order);
    }

    public function show(Request $request, Order $order): OrderResource
    {
        return new OrderResource($order);
    }

    public function update(OrderUpdateRequest $request, Order $order): OrderResource
    {
        $data = $request->safe()->except('products');

        $data['products'] = collect($request->input('products'))->mapWithKeys(function ($item) {
            return [$item['id'] => ['quantity' => $item['quantity']]];
        })->toArray();

        $order->products()->sync($data['products']);

        $order->load('products');

        return new OrderResource($order);
    }

    public function destroy(Request $request, Order $order): Response
    {
        $order->delete();

        return response()->noContent();
    }
}
