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
            'id' => (int) $this->id,
            'status' => (string) $this->status,
            'address' => (string) $this->address,
            'name' => (string) $this->name,
            'phone' => (string) $this->phone,
            'sub_total' => (double) $this->sub_total,
            'shipping' => (double) $this->shipping,
            'discount' => (double) $this->discount,
            'total' => (double) $this->total,
            'order_datails' =>OrderDetailsResource::collection($this->OrderDetails)


        ];
    }
}
