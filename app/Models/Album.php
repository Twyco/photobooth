<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * @property string $title
 * @property string $description
 * @property string $uuid
 * @property Carbon $event_date
 * @property string $albumAccessCodes
 * @property array $images
 * @property string $cover
 */
class Album extends Model
{
    /** @use HasFactory<\Database\Factories\AlbumFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
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
            Storage::disk('public')->makeDirectory('album/' . $album->uuid);
        });

        static::created(function ($album) {
            AlbumAccessCode::create(['album_id' => $album->id]);
            $album->createQrCode(1000);
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

    public function createQrCode(int $size): void
    {
        $albumLink = route('album.show', ['album' => $this]);
        $qrImage = QrCode::format('png')->size($size)->generate($albumLink);

        Storage::disk('public')->put("qrCodes/{$this->uuid}.png", $qrImage);
    }

    public function getQrCodeUrl(): string
    {
        return Storage::url("public/qrCodes/{$this->uuid}.png");
    }

    public function getImagesAttribute(): array
    {
        $path = 'album/' . $this->uuid;
        $files = collect(Storage::disk('public')->files($path))
            ->filter(fn($file) => preg_match('/\.(png|jpg|jpeg)$/i', $file))
            ->values()->toArray();

        return array_map(fn($file) => Storage::url($file), $files);
    }

    public function getCoverAttribute(): string
    {
        return Storage::url('cover/' . $this->uuid . '.jpg');
    }

}
