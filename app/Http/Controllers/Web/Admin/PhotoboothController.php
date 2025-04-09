<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminAlbumResource;
use App\Http\Resources\GenericPaginationResource;
use App\Http\Resources\PhotoboothResource;
use App\Models\Album;
use App\Models\Photobooth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PhotoboothController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Photobooth/Index', [
            'photobooths' => GenericPaginationResource::make(Photobooth::paginate(10), PhotoboothResource::class)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return Inertia::render('Admin/Photobooth/Create', [
            'albums' => AdminAlbumResource::collection(Album::all())->toArray($request)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Photobooth $photobooth)
    {
        return Inertia::render('Admin/Photobooth/Show', [
            'photobooth' => PhotoboothResource::make($photobooth)->toArray($request),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Photobooth $photobooth)
    {
        return Inertia::render('Admin/Photobooth/Edit', [
            'photobooth' => PhotoboothResource::make($photobooth)->toArray($request),
            'albums' => AdminAlbumResource::collection(Album::all())->toArray($request),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photobooth $photobooth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photobooth $photobooth)
    {
        //
    }
}
