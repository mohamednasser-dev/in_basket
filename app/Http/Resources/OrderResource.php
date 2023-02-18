<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'address' => $this->address,
            'name' => $this->name,
            'phone' => $this->phone,
            'sub_total' => $this->sub_total,
            'shipping' => $this->shipping,
            'discount' => $this->discount,
            'total' => $this->total,
            'order_datails' =>OrderDetailsResource::collection($this->OrderDetails)


        ];
    }
}
