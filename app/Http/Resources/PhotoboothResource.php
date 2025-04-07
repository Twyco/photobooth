<?php

namespace App\Http\Resources;

use App\Models\Photobooth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Photobooth
 */
class PhotoboothResource extends JsonResource
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
          'name' => $this->name,
          'active_album' => $this->album ? AdminAlbumResource::make($this->album)->toArray($request) : null,
        ];
    }
}
