<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'id' => (int)$this->id,
            'image' => (string)$this->image,
            'product' => [
                'id' => $this->product ? $this->product->id : null,
                'name' => (string)$this->product ? $this->product->title : "--"
            ]

        ];
    }
}
