<?php

namespace App\Models;

use App\Traits\HasOrders;
use App\Traits\Addressable;
use Spatie\Image\Manipulations;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use Addressable;
    use HasOrders;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'phone',
        'suscribed',
        'acepted_terms_conditions',
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
        'acepted_terms_conditions' => 'datetime',
        'suscribed' => 'boolean',
    ];

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
