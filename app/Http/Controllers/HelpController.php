<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HelpController extends Controller
{
    /**
     * Display the help and support page.
     */
    public function index(Request $request): View
    {
        return view('help.index');
    }
} 