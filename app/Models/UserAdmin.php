<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserAdmin extends Model
{
    protected $table = 'user_admin';
    
    protected $fillable = [
        'role',
        'email',
        'password',
        'last_activity',
        'is_active'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get activity logs for this admin
     */
    public function activityLogs()
    {
        return $this->hasMany(AdminActivityLog::class, 'user_admin_id');
    }

    /**
     * Check if admin is a super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if admin is a content editor
     */
    public function isContentEditor(): bool
    {
        return $this->role === 'content_editor';
    }

    /**
     * Verify password
     */
    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    /**
     * Update last activity timestamp
     */
    public function updateActivity(): void
    {
        $this->update(['last_activity' => now()]);
    }

    /**
     * Check if session has expired (30 minutes of inactivity)
     */
    public function isSessionExpired(): bool
    {
        if (!$this->last_activity) {
            return true;
        }

        return now()->diffInMinutes($this->last_activity) > 30;
    }

    /**
     * Validate password strength
     */
    public static function validatePasswordStrength(string $password): array
    {
        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter';
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number';
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'Password must contain at least one special character';
        }

        return $errors;
    }
}