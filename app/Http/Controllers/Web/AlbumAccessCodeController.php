<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AlbumAccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class AlbumAccessCodeController extends Controller
{

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'albumId' => ['required', 'integer', 'exists:albums,id'],
    ]);
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
}
