<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use App\Traits\ApiResponser;

class TestimonialController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return $this->withPagination(
            Testimonial::query()->paginate(),
            TestimonialResource::class,
            'testimonials'
        );
    }

    public function show(Testimonial $testimonial)
    {
        return $this->success(
            TestimonialResource::make($testimonial),
            'Success get testimonial data',
        );
    }
}
