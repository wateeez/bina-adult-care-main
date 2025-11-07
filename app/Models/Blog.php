<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'header_image',
        'author_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'published_at',
        'view_count'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'view_count' => 'integer'
    ];

    /**
     * Relationship with paragraph images
     */
    public function paragraphImages()
    {
        return $this->hasMany(BlogParagraphImage::class)->orderBy('paragraph_number')->orderBy('order');
    }

    /**
     * Get images for a specific paragraph
     */
    public function getImagesForParagraph($paragraphNumber)
    {
        return $this->paragraphImages()
            ->where('paragraph_number', $paragraphNumber)
            ->orderBy('order')
            ->get();
    }

    /**
     * Scope for published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');
    }

    /**
     * Scope for latest blogs
     */
    public function scopeLatest($query, $limit = 10)
    {
        return $query->published()->limit($limit);
    }

    /**
     * Generate unique slug from title
     */
    public static function generateSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = static::where('slug', $slug);
            
            if ($id) {
                $query->where('id', '!=', $id);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get header image URL
     */
    public function getHeaderImageUrlAttribute()
    {
        if (!$this->header_image) {
            return null;
        }
        
        return asset('storage/' . $this->header_image);
    }

    /**
     * Get SEO meta title or fallback to title
     */
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    /**
     * Get SEO meta description or fallback to excerpt
     */
    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: $this->excerpt;
    }

    /**
     * Get reading time estimate (words per minute: 200)
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);
        
        return $minutes . ' min read';
    }

    /**
     * Get formatted published date
     */
    public function getPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('F j, Y') : null;
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('view_count');
    }

    /**
     * Get URL for the blog post
     */
    public function getUrlAttribute()
    {
        return route('blog.show', $this->slug);
    }

    /**
     * Get content split by paragraphs
     */
    public function getParagraphsAttribute()
    {
        // Split content by double line breaks or <p> tags
        $content = $this->content;
        
        // Convert to paragraphs if not already HTML
        if (strpos($content, '<p>') === false) {
            $paragraphs = preg_split('/\n\s*\n/', $content);
            return array_filter(array_map('trim', $paragraphs));
        }
        
        // Extract content from p tags
        preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $content, $matches);
        return $matches[1] ?? [];
    }
}
