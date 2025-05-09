<?php

namespace App\Models;

use App\Notifications\ResetPasswordCustom;
use App\Notifications\VerifyEmailCustom;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Twyco\ImageSystem\Models\Image;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property bool $is_admin
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (User $user) {
            Cache::forget($user->id.'_viewable_albums');
        });
    }

    public function savedAlbums(): BelongsToMany
    {
        return $this->belongsToMany(Album::class, 'saved_albums')->withTimestamps();
    }

    public function hasAlbumSaved(Album $album): bool
    {
        return $this->savedAlbums()->where('album_id', $album->id)->exists();
    }

    public function sendPasswordResetNotification(#[\SensitiveParameter] $token): void
    {
        $this->notify(new ResetPasswordCustom($token));
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailCustom);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'owner');
    }
}
