<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'discount' => $this->offer,
            'total_price' => $this->price - $this->price * ($this->offer/100),
            'main_image' => $this->image,
            'images' => $this->whenLoaded('images', function () {
                return $this->images;
            })


        ];
    }
}
