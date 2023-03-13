<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'rate' => (int)$this->rate,
            'comment' => (string)$this->comment,
            'user_name' => $this->user->name,

            'created_at' => Carbon::parse($this->created_at)->translatedFormat('M d ,Y'),
        ];
    }
}
