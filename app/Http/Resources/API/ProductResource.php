<?php

namespace App\Http\Resources\API;

use App\Models\User;
use App\Http\Resources\API\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'Product-name'=>$this->p_name,
            'Product-description'=>$this->p_description,
            'user'=>new UserResource($this->users)
        ];
    }
}
