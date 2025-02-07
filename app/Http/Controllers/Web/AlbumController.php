<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Album/Index', [

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

}
