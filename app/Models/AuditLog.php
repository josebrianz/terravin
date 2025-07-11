<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'resource_type',
        'resource_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'details'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'details' => 'array'
    ];

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log a role change
     */
    public static function logRoleChange(User $user, string $oldRole, string $newRole, User $changedBy): void
    {
        self::create([
            'user_id' => $changedBy->id,
            'action' => 'role_changed',
            'resource_type' => 'user',
            'resource_id' => $user->id,
            'old_values' => ['role' => $oldRole],
            'new_values' => ['role' => $newRole],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'target_user_id' => $user->id,
                'target_user_email' => $user->email,
                'changed_by_user_id' => $changedBy->id,
                'changed_by_user_email' => $changedBy->email
            ]
        ]);
    }

    /**
     * Log a permission check failure
     */
    public static function logPermissionDenied(User $user, array $requiredPermissions, string $resource): void
    {
        self::create([
            'user_id' => $user->id,
            'action' => 'permission_denied',
            'resource_type' => $resource,
            'resource_id' => null,
            'old_values' => [],
            'new_values' => [],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'required_permissions' => $requiredPermissions,
                'user_permissions' => $user->getPermissions(),
                'user_role' => $user->role,
                'request_url' => request()->fullUrl(),
                'request_method' => request()->method()
            ]
        ]);
    }

    /**
     * Log a user creation
     */
    public static function logUserCreated(User $user, User $createdBy): void
    {
        self::create([
            'user_id' => $createdBy->id,
            'action' => 'user_created',
            'resource_type' => 'user',
            'resource_id' => $user->id,
            'old_values' => [],
            'new_values' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'created_user_id' => $user->id,
                'created_user_email' => $user->email,
                'created_by_user_id' => $createdBy->id,
                'created_by_user_email' => $createdBy->email
            ]
        ]);
    }

    /**
     * Log a user deletion
     */
    public static function logUserDeleted(User $user, User $deletedBy): void
    {
        self::create([
            'user_id' => $deletedBy->id,
            'action' => 'user_deleted',
            'resource_type' => 'user',
            'resource_id' => $user->id,
            'old_values' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ],
            'new_values' => [],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'deleted_user_id' => $user->id,
                'deleted_user_email' => $user->email,
                'deleted_by_user_id' => $deletedBy->id,
                'deleted_by_user_email' => $deletedBy->email
            ]
        ]);
    }

    /**
     * Log an order change
     */
    public static function logOrderChange(Order $order, array $oldValues, array $newValues, User $changedBy, string $action = 'order_updated')
    {
        self::create([
            'user_id' => $changedBy->id,
            'action' => $action,
            'resource_type' => 'order',
            'resource_id' => $order->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'order_id' => $order->id,
                'changed_by_user_id' => $changedBy->id,
                'changed_by_user_email' => $changedBy->email
            ]
        ]);
    }

    /**
     * Get audit logs for a specific user
     */
    public static function getUserAuditLogs(int $userId, int $limit = 50)
    {
        return self::where('user_id', $userId)
            ->orWhere('resource_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent security events
     */
    public static function getSecurityEvents(int $limit = 100)
    {
        return self::whereIn('action', ['permission_denied', 'role_changed', 'user_created', 'user_deleted'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
} 