<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'image_path',
        'title',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get active gallery images ordered by order field
     */
    public static function getActiveImages()
    {
        return self::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Check if gallery should show on homepage
     */
    public static function shouldShowOnHomepage(): bool
    {
        return SiteSetting::get('show_gallery_on_homepage', '1') === '1';
    }
}
