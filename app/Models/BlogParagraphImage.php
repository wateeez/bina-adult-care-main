<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogParagraphImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'image_path',
        'paragraph_number',
        'caption',
        'alt_text',
        'order'
    ];

    protected $casts = [
        'paragraph_number' => 'integer',
        'order' => 'integer'
    ];

    /**
     * Relationship with blog
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
