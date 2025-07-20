<?php

namespace App\Services;

use App\Models\Stakeholder;

class ReportService
{
    public static function generateForStakeholder($stakeholder)
    {
        $data = [];
        $types = $stakeholder->reportPreference->report_types ?? [];

        foreach ($types as $type) {
            if ($type === 'inventory') {
                $data['inventory'] = \App\Models\Inventory::all();
            }
            if ($type === 'orders') {
                $data['orders'] = \App\Models\Order::all();
            }
            if ($type === 'procurement') {
                $data['procurement'] = \App\Models\Procurement::all();
            }
        }

        return $data;
    }

    public static function generateForUser($user, $preferences)
    {
        $data = [];
        foreach ($preferences['report_types'] as $type) {
            if ($type === 'inventory') {
                $data['inventory'] = \App\Models\Inventory::all();
            }
            if ($type === 'orders') {
                $data['orders'] = \App\Models\Order::all();
            }
            if ($type === 'procurement') {
                $data['procurement'] = \App\Models\Procurement::all();
            }
        }
        return $data;
    }
} 