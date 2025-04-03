<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreImageToAlbumRequest;
use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AlbumController extends Controller
{
    public function storeImage(StoreImageToAlbumRequest $request): JsonResponse
    {
        $request->validated();

        //TODO replace album with current active Album
        $album = Album::first();
        $image = $request->file('image');

        $originalName = $image->getClientOriginalName();
        $destPath = 'album/' . $album->uuid . '/';

        $filename = $originalName;
        $counter = 1;
        while (Storage::disk('public')->exists($destPath . $filename)) {
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . '(' . $counter . ').' . $image->getClientOriginalExtension();
            $counter++;
        }

        Storage::disk('public')->put($destPath . $filename, file_get_contents($image));
        Cache::forget('user_album_details_' . $album->uuid);

        return response()->json(['message' => 'Image uploaded successfully.'], ResponseAlias::HTTP_OK);
    }
}
