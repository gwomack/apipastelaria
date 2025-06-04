<?php

declare(strict_types = 1);

namespace Modules\Product\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Http\Requests\Api\ProductStoreRequest;
use Modules\Product\Http\Requests\Api\ProductUpdateRequest;
use Modules\Product\Http\Resources\Api\ProductCollection;
use Modules\Product\Http\Resources\Api\ProductResource;
use Modules\Product\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request): ProductCollection
    {
        $products = Product::all();

        return new ProductCollection($products);
    }

    public function store(ProductStoreRequest $request): ProductResource
    {
        $product = Product::create($request->validated());

        return new ProductResource($product);
    }

    public function show(Request $request, Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function update(ProductUpdateRequest $request, Product $product): ProductResource
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    public function destroy(Request $request, Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
