<?php

namespace App\Http\Controllers;

use App\Models\Gear;
use Illuminate\Http\Request;

class GearController extends Controller
{
    public function index(Request $request)
    {
        $query = Gear::where('is_available', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $gears = $query->latest()->get();
        $categories = Gear::where('is_available', true)->pluck('category')->unique()->values();

        return view('gear.index', compact('gears', 'categories'));
    }
}
