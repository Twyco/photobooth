<?php

namespace App\Http\Resources;

use App\Models\AlbumAccessCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property AlbumAccessCode $resource
 */
class AlbumAccessCodeResource extends JsonResource
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
            'albumId' => $this->album_id,
            'accessCode' => implode('-', str_split($this->access_code, 5)),
            'usages' => $this->usages,
            'saves' => $this->saves,
        ];
    }
}
