<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; // <-- Use this!

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirectToDashboard()
    {
        if (Auth::user()->role === 'admin') {
            return view('admin-dashboard');
        }
        elseif (Auth::user()->role === 'vendor') {
            return view('vendor-dashboard');
        }
        elseif (Auth::user()->role === 'supplier') {
            return view('supplier-dashboard');
        }
        elseif (Auth::user()->role === 'customer') {
            return redirect()->route('customer.dashboard');
        }
    }
}