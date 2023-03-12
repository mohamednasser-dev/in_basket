<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => (string)$this->name,
            'phone' =>(string) $this->phone,
            'email' =>(string) $this->email,
            'verified' => (int)$this->verified,
            'active' => (int)$this->active,
            'jwt' =>(string) $this->jwt,

        ];
    }
}
