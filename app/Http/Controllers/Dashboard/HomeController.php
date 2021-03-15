<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Ship;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        $ships = Ship::all();
        return view('pages.dashboard.index', compact('routes', 'ships'));
    }
}
