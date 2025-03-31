<?php

namespace App\Http\Controllers\Web\customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAlbumIndexResource;
use App\Http\Resources\UserAlbumResource;
use App\Models\Album;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $albums = Album::viewableAlbums()->get();
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
        return Inertia::render('Customer/Album/Show', [
            'album' => UserAlbumResource::make($album)->toArray($request),
            'hasAlbumSaved' => $user ? $user->hasAlbumSaved($album) : true,
        ]);
    }

    public function save(Request $request, Album $album)
    {
        $user = $request->user();
        $user->savedAlbums()->syncWithoutDetaching([$album->id]);
        return back()->with(['success' => 'Album saved successfully.']);
    }

}
