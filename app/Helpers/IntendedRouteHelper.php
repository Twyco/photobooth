<?php

namespace App\Helpers;

class IntendedRouteHelper
{

    public static function intendedRoute(): string
    {
        $intendedRoute = session('intended_route', 'home');
        $data = null;
        if($intendedRoute === 'album.show') {
            $data['album'] = session('intended_route_data', '');
        }
        return route($intendedRoute, $data, absolute: false);
    }

    public static function intendedRouteAndClear(): string
    {
        $intendedRoute = IntendedRouteHelper::intendedRoute();
        session()->forget('intended_route');
        session()->forget('intended_route_data');
        return $intendedRoute;
    }
}