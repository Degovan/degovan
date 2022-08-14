<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Traits\ApiResponser;

class ClientController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return $this->withPagination(
            Client::query()->paginate(),
            ClientResource::class,
            'clients'
        );
    }

    public function show(Client $client)
    {
        return $this->success(
            ClientResource::make($client),
            'Success get client data'
        );
    }
}
