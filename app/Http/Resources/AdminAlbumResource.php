<?php

namespace App\Http\Resources;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Album $resource
 */
class AdminAlbumResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'eventDate' => $this->event_date,
            'uuid' => $this->uuid,
            'accessCodes' => AlbumAccessCodeResource::collection($this->albumAccessCodes)->toArray($request)
        ];
    }
}
