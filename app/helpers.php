<?php

if (!function_exists('format_usd')) {
    function format_usd($amount) {
        return '$' . number_format($amount, 2);
    }
} 