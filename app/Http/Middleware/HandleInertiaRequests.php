<?php

namespace App\Http\Middleware;

use App\Helpers\NavMenuItem;
use App\Http\Resources\NavMenuItemResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $navMenuItems = [];

        $navMenuItems[] = new NavMenuItem(
            route('home'),
            'Home',
            $request->routeIs('home')
        );

        $navMenuItems[] = new NavMenuItem(
            route('album.index'),
            'Meine Fotoalben',
            $request->routeIs('album.index')
        );

        if (Auth::check() && Auth::user()->is_admin) {
            if ($request->routeIs('admin.*')) {
                $navMenuItems[] = new NavMenuItem(
                    route('home'),
                    'User',
                    isButton: true
                );
            } else {
                $navMenuItems[] = new NavMenuItem(
                    route('admin.dashboard'),
                    'Admin',
                    isButton: true
                );
            }
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? UserResource::make($request->user())->toArray($request) : null,
            ],
            'menu' => [
                'items' => NavMenuItemResource::collection($navMenuItems)->toArray($request),
            ]
        ];
    }
}
