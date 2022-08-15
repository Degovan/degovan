<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Models\About;
use App\Traits\ApiResponser;

class AboutController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return $this->withPagination(
            About::query()->paginate(),
            AboutResource::class,
            'abouts'
        );
    }
}
