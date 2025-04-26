<?php

namespace App\Http\Resources;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Twyco\ImageSystem\Http\Resources\ImageResource;

/**
 * @mixin Album
 */
class UserAlbumIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'eventDate' => $this->event_date,
            'uuid' => $this->uuid,
            'cover' => $this->cover ? ImageResource::make($this->cover)->toArray($request) : null,
        ];
    }
}
