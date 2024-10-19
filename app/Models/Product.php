<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $fillable = ['title', 'description', 'price', 'product_id', 'user_id'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useDisk('public');
    }

    /**
     * @return array
     */
    public function getAllMediaAttribute(): array
    {
        $ans = [];

        if ($this->hasMedia('images')) {
            $images = $this->getMedia('images');
            foreach ($images as $image) {
                $ans[] = $image->getFullUrl();
            }
        }


        return $ans;
    }
}
