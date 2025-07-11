<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApplicationStatusController extends Controller
{
    /**
     * Show the application status page for newly registered users.
     */
    public function index(): View
    {
        $user = Auth::user();
        // Optionally, you can fetch the user's pending role request here
        return view('auth.application-status', compact('user'));
    }
} 