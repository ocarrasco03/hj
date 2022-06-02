<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements HasMedia
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    use Searchable;
    use InteractsWithMedia;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    #[SearchUsingPrefix(['email'])]
    function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
        ];
    }

    function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();
    }

    /**
     * Delete the associated media with the given id.
     * You may also pass a media object.
     *
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted
     */
    function deleteMedia(int | string | Media $mediaId): void
    {
        if ($mediaId instanceof Media) {
            $mediaId = $mediaId->getKey();
        }

        $media = $this->media()->find($mediaId);

        if (!$media) {
            throw MediaCannotBeDeleted::doesNotBelongToModel($mediaId, $this);
        }

        $media->delete();
    }
}
