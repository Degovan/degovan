<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TechStackResource;
use App\Models\TechStack;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class TechStackController extends Controller
{

    use ApiResponser;

    public function index()
    {
        return $this->withPagination(
            TechStack::query()->paginate(),
            TechStackResource::class,
            'stacks'
        );
    }
}
