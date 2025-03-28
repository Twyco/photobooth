<?php

namespace App\Http\Resources;

use App\Helpers\NavMenuItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin NavMenuItem
 */
class NavMenuItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'route' => $this->route,
            'label' => $this->label,
            'active' => $this->isActive,
        ];
    }
}
