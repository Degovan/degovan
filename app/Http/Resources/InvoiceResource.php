<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $show = $request->routeIs('invoices.show');

        return [
            'code' => $this->code,
            'project' => $this->project,
            'status' => $this->status,
            'amount' => $this->when($show, $this->amount),
            'description' => $this->when($show, $this->description),
        ];
    }
}
