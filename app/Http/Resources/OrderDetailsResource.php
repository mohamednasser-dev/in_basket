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
            'id' =>   (int) $this->id,
            'product' => new ProductResource($this->Product),
            'quantity' => (int)  $this->quantity,
            'price' => (double) $this->price,
            'total' => (double) $this->total,
            'unit_selected' => new ProductUnitsResource($this->Unit),


        ];
    }
}
