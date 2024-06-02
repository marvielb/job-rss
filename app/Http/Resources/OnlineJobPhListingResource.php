<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OnlineJobPhListingResource extends JsonResource
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
            'title' => $this->title,
            'posting_date' => $this->posting_date,
            'employer' => $this->employer,
            'salary' => $this->salary,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'posting_link' => $this->posting_link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'rating' => $this->rating,
            'rated_at' => $this->rated_at,
        ];
    }
}
