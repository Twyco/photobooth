<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Http\Resources\AdminAlbumResource;
use App\Http\Resources\GenericPaginationResource;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminAlbumController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('viewAny', Album::class)) {
            abort(403);
        }
        $albums = Album::paginate(10);
        return Inertia::render('Admin/Album/Index', [
            'albums' => GenericPaginationResource::make($albums, AdminAlbumResource::class),
        ]);
    }

    public function show(Request $request, Album $album)
    {
        if (!Gate::allows('viewAny', Album::class)) {
            abort(403);
        }
        $album->load('albumAccessCodes');
        return Inertia::render('Admin/Album/Show', [
            'album' => AdminAlbumResource::make($album)->toArray($request)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Album $album)
    {
        if (!Gate::allows('update', $album)) {
            abort(403);
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
        if (!Gate::allows('create', Album::class)) {
            abort(403);
        }
        return Inertia::render('Admin/Album/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request)
    {
        if (!Gate::allows('create', Album::class)) {
            abort(403);
        }
        $validatedData = $request->validated();
        Album::create($validatedData);
        return to_route('admin.album.index')->with('success', 'Album created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        if (!Gate::allows('update', $album)) {
            abort(403);
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
        if (!Gate::allows('delete', $album)) {
            abort(403);
        }
        $album->delete();
        return to_route('album.index')->with('success', 'Album deleted successfully.');
    }
}
