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
        $menu = [];
        $navMenuItems = [];

        if(Auth::check() && Auth::user()->is_admin && $request->routeIs('admin.*')) {
            $navMenuItems[] = new NavMenuItem(
                route('admin.dashboard'),
                'Dashboard',
                $request->routeIs('admin.dashboard')
            );

            $navMenuItems[] = new NavMenuItem(
                route('admin.album.index'),
                'Fotoalben',
                $request->routeIs('admin.album.*')
            );

            $menu['isAdminPage'] = true;
        }else {
            $navMenuItems[] = new NavMenuItem(
                route('home'),
                'Home',
                $request->routeIs('home')
            );

            $navMenuItems[] = new NavMenuItem(
                route('album.index'),
                'Meine Fotoalben',
                $request->routeIs('album.*')
            );

            if(Auth::check() && Auth::user()->is_admin) {
                $menu['isAdminPage'] = false;
            }
        }

        $menu['items'] = NavMenuItemResource::collection($navMenuItems)->toArray($request);

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? UserResource::make($request->user())->toArray($request) : null,
            ],
            'menu' => $menu,
        ];
    }
}
