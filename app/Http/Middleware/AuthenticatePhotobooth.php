<?php

namespace App\Http\Middleware;

use App\Models\Photobooth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthenticatePhotobooth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authKey = $request->header('x-photobooth-auth-key');

        if (! $authKey) {
            return response()->json(['error' => 'Unauthorized'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $photobooth = Photobooth::whereAuthKey($authKey)->first();
        if (! $photobooth) {
            return response()->json(['error' => 'Unauthorized'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $request->attributes->add(['photobooth' => $photobooth]);

        return $next($request);
    }
}
