<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imagick;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * @property string $title
 * @property string $description
 * @property string $uuid
 * @property Carbon $event_date
 * @property string $albumAccessCodes
 * @property array $images
 * @property array $compressedImages
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
            Storage::disk('public')->makeDirectory('album/' . $album->uuid . '_compressed');
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
        $files = Storage::disk('public')->files($path);
        $imageFiles = array_filter($files, fn($file) => preg_match('/\.(png|jpe?g)$/i', $file));

        return array_map(fn($file) => Storage::url($file), $imageFiles);
    }

    public function getCompressedImagesAttribute(): array
    {
        $originalPath = 'album/' . $this->uuid;
        $compressedPath = 'album/' . $this->uuid . '_compressed';

        if (!Storage::disk('public')->exists($compressedPath)){
            Storage::disk('public')->makeDirectory($compressedPath);
        }

        $originalFiles = Storage::disk('public')->files($originalPath);
        $imageFiles = array_filter($originalFiles, fn($file) => preg_match('/\.(png|jpe?g)$/i', $file));

        return array_map(function ($file) use ($originalPath, $compressedPath) {
            $compressedFile = preg_replace('/\.(png|jpe?g)$/i', '.webp', str_replace($originalPath, $compressedPath, $file));

            if (!Storage::disk('public')->exists($compressedFile)) {
                $this->convertToWebP(Storage::disk('public')->path($file), Storage::disk('public')->path($compressedFile));
            }
            return Storage::disk('public')->exists($compressedFile)
                ? Storage::url($compressedFile)
                : Storage::url($file);
        }, $imageFiles);
    }

    /**
     * Erstellt eine WebP-Version des Bildes mit Imagick (80% Qualität).
     */
    private function convertToWebP(string $sourcePath, string $destinationPath)
    {
        $relativeDestPath = Str::replaceFirst(Storage::disk('public')->path(''), '', $destinationPath);

        try {
            $image = new Imagick();
            $image->readImage($sourcePath);
            $image->setImageFormat('webp');
            $image->setImageCompressionQuality(80);

            Storage::disk('public')->put($relativeDestPath, $image);
        } catch (Exception $e) {
            Log::error("Fehler beim Konvertieren zu WebP: " . $e->getMessage());
        }
    }


    public function getCoverAttribute(): string|null
    {
        $coverExists = Storage::disk('public')->exists('cover/' . $this->uuid . '.jpg');
        return $coverExists ? Storage::url('cover/' . $this->uuid . '.jpg') : null;
    }

}
