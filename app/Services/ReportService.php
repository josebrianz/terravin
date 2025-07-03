<?php

namespace App\Services;

use App\Models\Stakeholder;

class ReportService
{
    public static function generateForStakeholder(Stakeholder $stakeholder)
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
            // Add more report types as needed
        }

        return $data;
    }
} 