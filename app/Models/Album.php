<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

/**
 * @property mixed $albumAccessCodes
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
            $album->uuid = (string)Str::uuid();
        });

        static::created(function ($album) {
            AlbumAccessCode::create(['album_id' => $album->id]);
        });
    }

    public function scopeViewableAlbums(Builder $query): Builder
    {
        return $query->whereIn('id', Album::getViewableAlbums()->pluck('id'));
    }

    public static function getViewableAlbums(): Collection
    {
        return Album::all()->filter(function (Album $album) {
            return Gate::allows('view', $album);
        });
    }

    public function albumAccessCodes(): HasMany
    {
        return $this->hasMany(AlbumAccessCode::class);
    }

    public function savedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_albums')->withTimestamps();
    }

}
