<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tracking_number',
        'status',
        'carrier',
        'shipping_cost',
        'estimated_delivery_date',
        'shipping_address',
        'actual_delivery_date',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'estimated_delivery_date',
        'actual_delivery_date',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes for filtering
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeInTransit(Builder $query): Builder
    {
        return $query->where('status', 'in_transit');
    }

    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('status', 'delivered');
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', '!=', 'delivered')
            ->where('estimated_delivery_date', '<', now());
    }

    public function scopeByCarrier(Builder $query, string $carrier): Builder
    {
        return $query->where('carrier', $carrier);
    }

    // Accessors
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'badge-warning',
            'in_transit' => 'badge-info',
            'delivered' => 'badge-success',
            'cancelled' => 'badge-danger',
            'returned' => 'badge-secondary',
        ];
        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status !== 'delivered' && 
               $this->estimated_delivery_date && 
               $this->estimated_delivery_date->isPast();
    }

    public function getDaysOverdueAttribute(): int
    {
        if (!$this->is_overdue) {
            return 0;
        }
        return $this->estimated_delivery_date->diffInDays(now());
    }

    public function getDeliveryStatusAttribute(): string
    {
        if ($this->status === 'delivered') {
            return 'Delivered';
        }
        
        if ($this->is_overdue) {
            return "Overdue ({$this->days_overdue} days)";
        }
        
        if ($this->estimated_delivery_date) {
            $daysRemaining = $this->estimated_delivery_date->diffInDays(now(), false);
            return $daysRemaining > 0 ? "Due in {$daysRemaining} days" : "Due today";
        }
        
        return 'No delivery date set';
    }

    // RBAC Methods
    public function canBeViewedBy(User $user): bool
    {
        // Admins can view all shipments
        if ($user->hasPermission('view_all_shipments')) {
            return true;
        }

        // Suppliers can view shipments they're responsible for
        if ($user->hasPermission('view_shipments')) {
            return true;
        }

        // Customers can only view their own shipments
        if ($user->hasPermission('view_own_shipments')) {
            return $this->order->user_id === $user->id;
        }

        return false;
    }

    public function canBeUpdatedBy(User $user): bool
    {
        return $user->hasPermission('update_shipment_status');
    }

    public function canBeCreatedBy(User $user): bool
    {
        return $user->hasPermission('create_shipments');
    }

    // Business Logic Methods
    public function markAsDelivered(): bool
    {
        $this->update([
            'status' => 'delivered',
            'actual_delivery_date' => now(),
            'updated_by' => auth()->id()
        ]);

        // Log the delivery
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'shipment_delivered',
            'resource_type' => 'shipment',
            'resource_id' => $this->id,
            'old_values' => ['status' => $this->getOriginal('status')],
            'new_values' => ['status' => 'delivered'],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'tracking_number' => $this->tracking_number,
                'order_id' => $this->order_id
            ]
        ]);

        return true;
    }

    public function updateStatus(string $newStatus, ?string $notes = null): bool
    {
        $oldStatus = $this->status;
        
        $this->update([
            'status' => $newStatus,
            'notes' => $notes,
            'updated_by' => auth()->id()
        ]);

        // Log the status change
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'shipment_status_changed',
            'resource_type' => 'shipment',
            'resource_id' => $this->id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $newStatus],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'tracking_number' => $this->tracking_number,
                'order_id' => $this->order_id,
                'notes' => $notes
            ]
        ]);

        return true;
    }

    // Static Methods
    public static function generateTrackingNumber(): string
    {
        $prefix = 'TRV';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        return "{$prefix}{$date}{$random}";
    }

    public static function getStatusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'in_transit' => 'In Transit',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned'
        ];
    }

    public static function getCarrierOptions(): array
    {
        return [
            'fedex' => 'FedEx',
            'ups' => 'UPS',
            'dhl' => 'DHL',
            'usps' => 'USPS',
            'local_courier' => 'Local Courier',
            'self_delivery' => 'Self Delivery'
        ];
    }
} 