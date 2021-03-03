<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        $image = Storage::disk('public')->url($this->image);
        //  return parent::toArray($request);
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'price'       => $this->price,
            'description' => $this->description,
            'image'       => $image,
            'status'      => $this->status,
        ];
    }
}
