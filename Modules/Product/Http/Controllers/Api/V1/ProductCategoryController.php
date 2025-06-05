<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Http\Requests\Api\V1\ProductCategoryStoreRequest;
use Modules\Product\Http\Requests\Api\V1\ProductCategoryUpdateRequest;
use Modules\Product\Http\Resources\Api\V1\ProductCategoryCollection;
use Modules\Product\Http\Resources\Api\V1\ProductCategoryResource;
use Modules\Product\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function index(Request $request): ProductCategoryCollection
    {
        $productCategories = ProductCategory::all();

        return new ProductCategoryCollection($productCategories);
    }

    public function store(ProductCategoryStoreRequest $request): ProductCategoryResource
    {
        $productCategory = ProductCategory::create($request->validated());

        return new ProductCategoryResource($productCategory);
    }

    public function show(Request $request, ProductCategory $productCategory): ProductCategoryResource
    {
        return new ProductCategoryResource($productCategory);
    }

    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory): ProductCategoryResource
    {
        $productCategory->update($request->validated());

        return new ProductCategoryResource($productCategory);
    }

    public function destroy(Request $request, ProductCategory $productCategory): Response
    {
        $productCategory->delete();

        return response()->noContent();
    }
}
