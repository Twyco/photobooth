<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAlbumIndexResource;
use App\Http\Resources\UserAlbumResource;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            session(['intended_route' => 'album.index']);
            return Inertia::render('Customer/Album/Index');
        }

        $searchFilter = $request->query('search');
        $sorting = $request->query('albumSort') ?? 'desc';

        Cache::forget(Auth::user()->id . '_viewable_albums');

        $albums = Cache::rememberForever(Auth::user()->id . '_viewable_albums', function () {
            return Album::viewableAlbums()->get();
        });

        if($searchFilter){
            $albums = $albums->filter(function ($album) use ($searchFilter) {
                return str_contains(strtolower($album->title), strtolower($searchFilter));
            })->values();
        }


        if($sorting === 'desc') {
            $albums = $albums->sortByDesc('event_date')->values();
        }else {
            $albums = $albums->sortBy('event_date')->values();
        }

        return Inertia::render('Customer/Album/Index', [
            'albums' => UserAlbumIndexResource::collection($albums)->toArray($request),
            'searchValue' => $searchFilter,
            'sortDate' => $sorting ?? 'asc',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Album $album)
    {
        if (!Auth::check()) {
            session([
                'intended_route' => 'album.show',
                'intended_route_data' => $album->uuid
            ]);
        }
        $userAlbum = Cache::rememberForever('user_album_details_' . $album->uuid, function () use ($request, $album) {
            return UserAlbumResource::make($album)->toArray($request);
        });
        return Inertia::render('Customer/Album/Show', [
            'album' => $userAlbum,
            'hasAlbumSaved' => optional(Auth::user())->hasAlbumSaved($album) ?? true,
        ]);
    }

    public function save(Request $request, Album $album)
    {
        /** @var User $user */
        $user = Auth::user();
        Cache::forget($user->id . '_viewable_albums');
        $user->savedAlbums()->syncWithoutDetaching([$album->id]);
        return to_route('album.show', $album)->with(['success' => 'Album saved successfully.']);
    }

}
