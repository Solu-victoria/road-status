<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'state' => $this->state,
            'address' => $this->address,
            'road_rating' => $this->road_rating,
            'description' => $this->description,
            'image' => $this->image,
            'user' => new UserResource($this->user)
        ];
    }
}
