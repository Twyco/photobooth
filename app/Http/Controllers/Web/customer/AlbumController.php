<?php

namespace App\Http\Controllers\Web\customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAlbumIndexResource;
use App\Http\Resources\UserAlbumResource;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $albums = Album::viewableAlbums()->get();
        if(!Auth::check()) {
            session(['intended_route' => 'album.index']);
        }
        return Inertia::render('Customer/Album/Index', [
            'albums' => UserAlbumIndexResource::collection($albums)->toArray($request)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Album $album)
    {
        $user = $request->user();
        if(!Auth::check()) {
            session(['intended_route' => 'album.show', 'intended_route_data' => $album->uuid]);
        }
        return Inertia::render('Customer/Album/Show', [
            'album' => UserAlbumResource::make($album)->toArray($request),
            'hasAlbumSaved' => $user ? $user->hasAlbumSaved($album) : true,
        ]);
    }

    public function save(Request $request, Album $album)
    {
        $user = $request->user();
        $user->savedAlbums()->syncWithoutDetaching([$album->id]);
        return to_route('album.show', $album)->with(['success' => 'Album saved successfully.']);
    }

}
