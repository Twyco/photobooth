<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminAlbumResource;
use App\Http\Resources\GenericPaginationResource;
use App\Http\Resources\PhotoboothResource;
use App\Models\Album;
use App\Models\Photobooth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
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
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:50|min:5|unique:photobooths',
            'activeAlbum' => 'required|integer|exists:albums,id'
        ])->validateWithBag('createPhotobooth');
        $photobooth = Photobooth::create([
            'name' => Arr::get($validatedData, 'name'),
            'album_id' => Arr::get($validatedData, 'activeAlbum'),
        ]);
        return to_route('admin.photobooth.show', $photobooth)->with('success', 'Photobooth created successfully.');
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
    {        $validatedData = Validator::make($request->all(), [
        'name' => 'required|string|max:50|min:5|unique:photobooths,name,' . $photobooth->id,
        'activeAlbum' => 'required|integer|exists:albums,id'
    ])->validateWithBag('updatePhotobooth');
        $photobooth->update([
            'name' => Arr::get($validatedData, 'name'),
            'album_id' => Arr::get($validatedData, 'activeAlbum'),
        ]);
        return to_route('admin.photobooth.show', $photobooth)->with('success', 'Photobooth updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photobooth $photobooth)
    {
        //
    }
}
