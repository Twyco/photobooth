<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/*
 * @extends
 */
class Album extends Model
{
    /** @use HasFactory<\Database\Factories\AlbumFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
    ];
    protected $guarded = ['uuid'];

    protected $casts = [
        'event_date' => 'date',
    ];

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($album) {
        $album->uuid = (string) Str::uuid();
      });

      static::created(function ($album) {
        //TODO Create Album AccessCode
      });
    }
}
