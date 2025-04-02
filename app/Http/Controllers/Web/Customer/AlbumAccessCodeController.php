<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use App\Models\AlbumAccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AlbumAccessCodeController extends Controller
{

  /**
   * Store a newly created resource in storage.
   * @throws ValidationException
   */
  public function store(Request $request)
  {
    $validatedData = Validator::make($request->all(), [
      'albumId' => ['required', 'integer', 'exists:albums,id'],
    ])->validateWithBag('createAlbumAccessCode');
    AlbumAccessCode::create(['album_id' => Arr::get($validatedData, 'albumId')]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(AlbumAccessCode $albumAccessCode)
  {
    if (!Gate::allows('delete', $albumAccessCode)) {
      abort(403);
    }
    $albumAccessCode->delete();
  }

  /**
   * @throws ValidationException
   */
  public function use(Request $request)
  {
    $validatedData = Validator::make($request->all(), [
      'accessCode' => ['required', 'string'],
    ])->validateWithBag('useAlbumAccessCode');

    $cleanedCode = str_replace('-', '', Arr::get($validatedData, 'accessCode'));

    Validator::make([
      'accessCode' => $cleanedCode,
    ], [
      'accessCode' => ['exists:album_access_codes,access_code'],
    ])->validateWithBag('useAlbumAccessCode');

    $albumAccessCode = AlbumAccessCode::where('access_code', $cleanedCode)->firstOrFail();

    $albumAccessCode->increment('usages');
    $album = $albumAccessCode->album;
    if(auth()->check()){
      $user = $request->user();
      $user->savedAlbums()->syncWithoutDetaching([$album->id]);
      $albumAccessCode->increment('saves');
    }

    return to_route('album.show', ['album' => $album]);
  }

}
