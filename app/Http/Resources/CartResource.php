<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'qty' =>(int)  $this->qty,
            'product' => new ProductResource($this->product),
            'unit_selected' => new ProductUnitsResource($this->unit),

        ];
    }
}
