<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Http\Resources\Api\V1\ProductResource;
use Modules\Product\Http\Resources\Api\V1\ProductCollection;
use Modules\Product\Http\Requests\Api\V1\ProductStoreRequest;
use Modules\Product\Http\Requests\Api\V1\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index(Request $request): ProductCollection
    {
        $products = Product::all();

        return new ProductCollection($products);
    }

    public function store(ProductStoreRequest $request): ProductResource
    {
        $data = $request->safe()->except(['foto']);

        $foto = $request->file('foto');
        $data['foto'] = $foto->store('products', 'public');

        $product = Product::create($data);

        return new ProductResource($product);
    }

    public function show(Request $request, Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function update(ProductUpdateRequest $request, Product $product): ProductResource
    {
        $data = $request->safe()->except(['foto']);

        if ($request->hasFile('foto')) {
            // Delete the old photo if it exists
            if ($product->foto && Storage::disk('public')->exists($product->foto)) {
                Storage::disk('public')->delete($product->foto);
            }

            $foto = $request->file('foto');
            $data['foto'] = $foto->store('products', 'public');
        }

        $product->update($data);

        $product->refresh()->load('productCategory');

        return new ProductResource($product);
    }

    public function destroy(Request $request, Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
