<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Http\Resources\AdminAlbumResource;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::viewableAlbums()->get();
        return Inertia::render('Album/Index', [
            'albums' => $albums
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        return Inertia::render('Album/Show', [
            'album' => $album,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Album $album)
    {
        if(!Gate::allows('update', $album)){
            return to_route('dashboard')->with('danger', 'You do not have permission to update this album.');
        }
        $album->load('albumAccessCodes');
        return Inertia::render('Admin/Album/Edit', [
            'album' => AdminAlbumResource::make($album)->toArray($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create', Album::class)){
            return to_route('dashboard')->with('danger', 'You do not have permission to create album.');
        }
        return Inertia::render('Admin/Album/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request)
    {
        if(!Gate::allows('create', Album::class)){
            return to_route('dashboard')->with('danger', 'You do not have permission to create album.');
        }
        $validatedData = $request->validated();
        Album::create($validatedData);
        return to_route('album.index')->with('success', 'Album created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        if(!Gate::allows('update', $album)){
            return to_route('dashboard')->with('danger', 'You do not have permission to update this album.');
        }
        $validatedData = $request->validated();
        $album->update($validatedData);
        return to_route('album.index')->with('success', 'Album updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        if(!Gate::allows('delete', $album)){
            return to_route('dashboard')->with('danger', 'You do not have permission to delete this album.');
        }
        $album->delete();
        return to_route('album.index')->with('success', 'Album deleted successfully.');
    }
}
