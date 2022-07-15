<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use App\Traits\ApiResponser;

class PortfolioController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return $this->withPagination(
            Portfolio::query()->paginate(),
            PortfolioResource::class,
            'portfolios'
        );
    }

    public function show(Portfolio $portfolio)
    {
        return $this->success(
            PortfolioResource::make($portfolio),
            'Success get portfolio data',
        );
    }
}
