<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use App\Traits\ApiResponser;

class FaqController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return $this->withPagination(
            Faq::query()->paginate(),
            FaqResource::class,
            'faqs'
        );
    }
}
