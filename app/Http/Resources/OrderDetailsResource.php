<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
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
            'id' => $this->id,
            'product' => new ProductResource($this->Product),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->total,
            'unit_selected' => $this->unit,


        ];
    }
}
