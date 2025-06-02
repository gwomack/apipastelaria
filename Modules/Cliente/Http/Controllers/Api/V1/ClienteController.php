<?php

namespace Modules\Cliente\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cliente\Http\Requests\Api\V1\ClienteStoreRequest;
use Modules\Cliente\Http\Requests\Api\V1\ClienteUpdateRequest;
use Modules\Cliente\Http\Resources\Api\V1\ClienteCollection;
use Modules\Cliente\Http\Resources\Api\V1\ClienteResource;
use Modules\Cliente\Models\Cliente;

class ClienteController extends Controller
{
    public function index(Request $request): ClienteCollection
    {
        $clientes = Cliente::all();

        return new ClienteCollection($clientes);
    }

    public function store(ClienteStoreRequest $request): ClienteResource
    {
        $cliente = Cliente::create($request->validated());

        return new ClienteResource($cliente);
    }

    public function show(Request $request, Cliente $cliente): ClienteResource
    {
        return new ClienteResource($cliente);
    }

    public function update(ClienteUpdateRequest $request, Cliente $cliente): ClienteResource
    {
        $cliente->update($request->validated());

        return new ClienteResource($cliente);
    }

    public function destroy(Request $request, Cliente $cliente): Response
    {
        $cliente->delete();

        return response()->noContent();
    }
}
