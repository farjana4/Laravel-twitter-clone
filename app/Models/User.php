<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        try {
            $this->addMediaConversion('thumbnail')
                ->width(64)
                ->height(64)
                ->sharpen(10);
        } catch (InvalidManipulation $e) {
            Log::error('User registerMediaConversions: '.$e->getMessage());    //set on laravel build in log
            //app('log')->error('User registerMediaConversions: ' . $e->getMessage());    //set on laravel build in log
        }
    }
}
