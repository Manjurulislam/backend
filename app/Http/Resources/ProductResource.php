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
        //  return parent::toArray($request);
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'price'       => $this->price,
            'description' => $this->description,
            'image'       => url($this->image),
            'status'      => $this->status,
        ];
    }
}