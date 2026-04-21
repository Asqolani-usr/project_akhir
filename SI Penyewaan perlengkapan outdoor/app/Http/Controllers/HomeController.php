<?php

namespace App\Http\Controllers;

use App\Models\Gear;

class HomeController extends Controller
{
    public function index()
    {
        $gears = Gear::where('is_available', true)->latest()->get();
        $featured = $gears->take(4);
        $categories = $gears->pluck('category')->unique()->values();

        return view('home', compact('gears', 'featured', 'categories'));
    }
}
