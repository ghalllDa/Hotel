<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Hotel;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'role' => Auth::user()->role,
            'hotels' => Hotel::all()
        ]);
    }
}
