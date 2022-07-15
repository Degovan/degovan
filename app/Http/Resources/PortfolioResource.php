<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $show = $request->routeIs('portfolios.show');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'images' => array_map(fn ($img) => Storage::disk('cdn')->url($img), $this->images),
            'date' => $this->when($show, $this->date),
            'description' => $this->when($show, $this->description),
        ];
    }
}
