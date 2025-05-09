<?php

namespace App\Helpers;

/**
 * @property string $route
 * @property string $label
 * @property bool $isActive
 */
final readonly class NavMenuItem
{
    public function __construct(public string $route, public string $label, public bool $isActive = false) {}
}
