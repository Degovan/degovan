<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Traits\ApiResponser;

class InvoiceController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return $this->withPagination(
            Invoice::query()->paginate(),
            InvoiceResource::class,
            'invoices'
        );
    }

    public function show(Invoice $invoice)
    {
        return $this->success(
            InvoiceResource::make($invoice),
            'Success get invoice data'
        );
    }
}
