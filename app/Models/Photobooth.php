<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;


class Photobooth extends Model
{
    protected $fillable = [
        'name',
        'album_id',
    ];

    protected $guarded = [
        'auth_key',
    ];

    protected $hidden = [
        'auth_key',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Photobooth $photobooth) {
            $photobooth->auth_key = bin2hex(random_bytes(32));
        });
    }

    public function activeAlbum(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
