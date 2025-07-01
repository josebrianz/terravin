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
