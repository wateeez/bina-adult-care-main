<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'text_content',
        'image_path',
        'link_url',
        'link_text',
        'is_active',
        'background_color',
        'text_color',
        'delay_seconds',
        'show_once_per_session',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_once_per_session' => 'boolean',
        'delay_seconds' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    /**
     * Scope for active announcements
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }

    /**
     * Scope for bar announcements
     */
    public function scopeBar($query)
    {
        return $query->where('type', 'bar');
    }

    /**
     * Scope for popup announcements
     */
    public function scopePopup($query)
    {
        return $query->where('type', 'popup');
    }

    /**
     * Get active bar announcement
     */
    public static function getActiveBar()
    {
        return static::active()->bar()->first();
    }

    /**
     * Get active popup announcement
     */
    public static function getActivePopup()
    {
        return static::active()->popup()->first();
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }
        
        return asset('storage/' . $this->image_path);
    }

    /**
     * Check if announcement is currently scheduled
     */
    public function isScheduled()
    {
        $now = now();
        
        $afterStart = !$this->start_date || $this->start_date <= $now;
        $beforeEnd = !$this->end_date || $this->end_date >= $now;
        
        return $afterStart && $beforeEnd;
    }

    /**
     * Get status text
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }
        
        if (!$this->isScheduled()) {
            return 'Scheduled';
        }
        
        return 'Active';
    }
}
