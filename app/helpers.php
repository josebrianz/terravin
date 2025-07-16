<?php

if (!function_exists('format_usd')) {
    function format_usd($amount_in_ugx) {
        $usd = round($amount_in_ugx / 3800);
        return '$' . number_format($usd, 0);
    }
} 