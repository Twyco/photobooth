<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAlbumResource;
use Illuminate\Http\Request;
use App\Models\Album;
use Inertia\Inertia;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $albums = Album::viewableAlbums()->get();
        return Inertia::render('Album/Index', [
            'albums' => UserAlbumResource::collection($albums)->toArray($request)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Album $album)
    {
        $user = $request->user();
        return Inertia::render('Album/Show', [
            'album' => UserAlbumResource::make($album)->toArray($request),
            'hasAlbumSaved' => $user->hasAlbumSaved($album),
        ]);
    }

    public function save(Request $request, Album $album)
    {
        $user = $request->user();
        $user->savedAlbums()->syncWithoutDetaching([$album->id]);
        return back()->with(['success' => 'Album saved successfully.']);
    }

}
