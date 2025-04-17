<?php

namespace App\Models;

use App\Helpers\ConvertToWebP;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $uuid
 * @property Carbon $event_date
 * @property string $albumAccessCodes
 * @property array $images
 * @property string $cover
 * @property string $qrCode
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photobooth viewableAlbums()
 **/
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
            Storage::disk('public')->makeDirectory('album/' . $album->uuid . '_compressed');
        });

        static::created(function ($album) {
            AlbumAccessCode::create(['album_id' => $album->id]);
            $album->createQrCode(1000);
        });

        static::deleting(function ($album) {
            Cache::forget('user_album_details_' . $album->uuid);
            foreach (User::all() as $user) {
                Cache::forget($user->id . '_viewable_albums');
            }
            Storage::disk('public')->delete("qrCodes/{$album->uuid}.png");
            Storage::disk('public')->delete("cover/{$album->uuid}.jpg");
            Storage::disk('public')->deleteDirectory('album/' . $album->uuid);
            Storage::disk('public')->deleteDirectory('album/' . $album->uuid . '_compressed');
        });
    }

    public function photobooths(): HasMany
    {
        return $this->hasMany(Photobooth::class);
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

    public function getQrCodeAttribute(): string
    {
        return Storage::url("public/qrCodes/{$this->uuid}.png");
    }

    public function getImagesAttribute(): array
    {
        $originalPath = 'album/' . $this->uuid;
        $compressedPath = 'album/' . $this->uuid . '_compressed';

        if (!Storage::disk('public')->exists($compressedPath)) {
            Storage::disk('public')->makeDirectory($compressedPath);
        }

        $originalFiles = Storage::disk('public')->files($originalPath);
        $imageFiles = array_filter($originalFiles, fn($file) => preg_match('/\.(png|jpe?g)$/i', $file));

        return array_values(array_map(function ($file) use ($originalPath, $compressedPath) {
            $compressedFile = preg_replace('/\.(png|jpe?g)$/i', '.webp', str_replace($originalPath, $compressedPath, $file));

            if (!Storage::disk('public')->exists($compressedFile)) {
                ConvertToWebP::convertAndSave(Storage::disk('public')->path($file), Storage::disk('public')->path($compressedFile));
            }

            return [
                'original' => Storage::url($file),
                'compressed' => Storage::disk('public')->exists($compressedFile) ? Storage::url($compressedFile) : null,
            ];
        }, $imageFiles));
    }

    public function getCoverAttribute(): string|null
    {
        $coverExists = Storage::disk('public')->exists('cover/' . $this->uuid . '.jpg');
        return $coverExists ? Storage::url('cover/' . $this->uuid . '.jpg') : null;
    }

}
