<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;


class Ticket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    // protected $fillable = [
    //     'title',
    //     'body',
    // ];
    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $with = ['comments'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media');
        // ->singleFile();
    }

    public function getMediaFilesAttribute()
    {
        // $media =  $this->getMedia('avatar');
        $collection = collect($this->media)->map(function ($arr, $key) {
            $arr['thumb_url'] = $arr->getAvailableUrl(['thumb']);
            return collect($arr)->only('id', 'model_type', 'model_id', 'file_name', 'mime_type', 'size', 'original_url', 'thumb_url');
        });
        return $collection;
    }

    public function registerMediaConversions(Media $media = null): void
    { 
        $this->addMediaConversion('thumb')->crop('crop-center', 40, 40);
    }
}
