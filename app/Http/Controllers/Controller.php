<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Require a specific role for access.
     *
     * Note: Prefer using middleware for role-based protection.
     */
    protected function requireRole($role)
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403);
        }
    }
}

if (!function_exists('format_usd')) {
    function format_usd($amount_in_ugx) {
        $usd = round($amount_in_ugx / 3800);
        return '$' . number_format($usd, 0);
    }
}
