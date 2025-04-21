<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $auth_key
 * @property Album $album
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth whereAuthKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth whereAlbum($value)
 */
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

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
