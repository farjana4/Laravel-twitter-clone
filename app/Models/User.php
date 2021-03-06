<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
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
                ->width(128)
                ->height(128)
                ->sharpen(15);
        } catch (InvalidManipulation $e) {
            Log::error('User registerMediaConversions: '.$e->getMessage());    //set on laravel build in log
            //app('log')->error('User registerMediaConversions: ' . $e->getMessage());    //set on laravel build in log
        }
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    //create custom attribute
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getFormattedDateOfBirthAttribute(): string
    {
        return $this->date_of_birth ?
            sprintf('%s %s', __('twitter.born'), $this->date_of_birth->format('F d, Y')) :
            __('twitter.birthday_message');
    }

    public function getFormattedJoinedDateAttribute(): string
    {
        return sprintf('%s %s', __('twitter.joined'), $this->created_at->format('F d, Y'));
    }

    //relationship one to many with Tweet table
    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class);
    }
}
