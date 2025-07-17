<?php

namespace App\Traits;

trait HasRoles
{
    /**
     * Check if the user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if the user has any of the given roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Check if the user has all of the given roles
     */
    public function hasAllRoles(array $roles): bool
    {
        return count(array_intersect([$this->role], $roles)) === count($roles);
    }

    /**
     * Get the user's role display name
     */
    public function getRoleDisplayName(): string
    {
        $roles = [
            'Admin' => 'Administrator',
            'Vendor' => 'Vendor',
            'Retailer' => 'Retailer',
            'Supplier' => 'Supplier',
            'Customer' => 'Customer'
        ];

        return $roles[$this->role] ?? $this->role;
    }

    /**
     * Get the user's role color for UI display
     */
    public function getRoleColor(): string
    {
        $colors = [
            'Admin' => 'danger',
            'Vendor' => 'info',
            'Retailer' => 'success',
            'Supplier' => 'warning',
            'Customer' => 'secondary'
        ];

        return $colors[$this->role] ?? 'secondary';
    }
} 