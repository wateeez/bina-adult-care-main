<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    protected $fillable = [
        'user_admin_id',
        'action_type',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the admin who performed the action
     */
    public function admin()
    {
        return $this->belongsTo(UserAdmin::class, 'user_admin_id');
    }

    /**
     * Log an admin action
     */
    public static function logActivity(
        int $userId,
        string $actionType,
        string $module,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null
    ): void {
        self::create([
            'user_admin_id' => $userId,
            'action_type' => $actionType,
            'module' => $module,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'old_values' => $oldValues,
            'new_values' => $newValues
        ]);
    }
}
