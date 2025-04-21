<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ConvertToWebP;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreImageToAlbumRequest;
use App\Models\Photobooth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AlbumController extends Controller
{
    public function storeImage(StoreImageToAlbumRequest $request): JsonResponse
    {
        $request->validated();

        /** @var Photobooth $photobooth */
        $photobooth = $request->get('photobooth');

        $album = $photobooth->album;
        $image = $request->file('image');

        $originalName = $image->getClientOriginalName();
        $destPath = 'album/'.$album->uuid.'/';

        $time = time();

        $filename = pathinfo($originalName, PATHINFO_FILENAME).'_'.$time.'.'.$image->getClientOriginalExtension();
        $compressedFilename = pathinfo($originalName, PATHINFO_FILENAME).'_'.$time.'.webp';

        Storage::disk('public')->put($destPath.$filename, file_get_contents($image));

        ConvertToWebP::convertAndSave(Storage::disk('public')->path($destPath.$filename),
            Storage::disk('public')->path('album/'.$album->uuid.'_compressed/'.$compressedFilename));
        Cache::forget('user_album_details_'.$album->uuid);

        return response()->json(['message' => 'Image uploaded successfully.'], ResponseAlias::HTTP_OK);
    }
}
