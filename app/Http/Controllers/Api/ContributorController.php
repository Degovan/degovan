<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContributorResource;
use App\Models\Contributor;
use App\Traits\ApiResponser;

class ContributorController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return $this->withPagination(
            Contributor::query()->paginate(),
            ContributorResource::class,
            'contributors'
        );
    }
}
