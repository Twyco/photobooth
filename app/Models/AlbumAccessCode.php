<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AlbumAccessCode extends Model
{
    protected $fillable = [
        'album_id'
    ];

    protected $guarded = [
        'access_code',
        'usages',
        'saves'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($accessCode) {
            do {
                $code = strtoupper(Str::random(25));
            } while (self::where('access_code', $code)->exists());
            $accessCode->access_code = $code;
        });
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

}
