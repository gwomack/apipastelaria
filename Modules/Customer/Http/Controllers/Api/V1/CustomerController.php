<?php

namespace Modules\Customer\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Http\Requests\Api\V1\CustomerStoreRequest;
use Modules\Customer\Http\Requests\Api\V1\CustomerUpdateRequest;
use Modules\Customer\Http\Resources\Api\V1\CustomerCollection;
use Modules\Customer\Http\Resources\Api\V1\CustomerResource;
use Modules\Customer\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request): CustomerCollection
    {
        $customers = Customer::all();

        return new CustomerCollection($customers);
    }

    public function store(CustomerStoreRequest $request): CustomerResource
    {
        $customer = Customer::create($request->validated());

        return new CustomerResource($customer);
    }

    public function show(Request $request, Customer $customer): CustomerResource
    {
        return new CustomerResource($customer);
    }

    public function update(CustomerUpdateRequest $request, Customer $customer): CustomerResource
    {
        $customer->update($request->validated());

        return new CustomerResource($customer);
    }

    public function destroy(Request $request, Customer $customer): Response
    {
        $customer->delete();

        return response()->noContent();
    }
}
