<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GearController extends Controller
{
    public function index(Request $request)
    {
        $query = Gear::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $gears = $query->latest()->get();
        $categories = Gear::pluck('category')->unique()->values();

        return view('admin.inventory', compact('gears', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100',
            'category' => 'required|string|min:1',
            'price_per_day' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:Baik,Cukup,Rusak',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:5120',
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gear', 'public');
        }

        Gear::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'price_per_day' => $validated['price_per_day'],
            'stock' => $validated['stock'],
            'condition' => $validated['condition'],
            'is_available' => true,
            'description' => $validated['description'] ?? '',
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Gear berhasil ditambahkan.');
    }

    public function update(Request $request, Gear $gear)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100',
            'category' => 'required|string|min:1',
            'price_per_day' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:Baik,Cukup,Rusak',
            'is_available' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'name' => $validated['name'],
            'category' => $validated['category'],
            'price_per_day' => $validated['price_per_day'],
            'stock' => $validated['stock'],
            'condition' => $validated['condition'],
            'is_available' => $request->boolean('is_available', true),
            'description' => $validated['description'] ?? '',
        ];

        if ($request->hasFile('image')) {
            if ($gear->image && Storage::disk('public')->exists($gear->image)) {
                Storage::disk('public')->delete($gear->image);
            }
            $data['image'] = $request->file('image')->store('gear', 'public');
        }

        $gear->update($data);

        return redirect()->route('admin.inventory')->with('success', 'Gear berhasil diperbarui.');
    }

    public function destroy(Gear $gear)
    {
        if ($gear->image && Storage::disk('public')->exists($gear->image)) {
            Storage::disk('public')->delete($gear->image);
        }

        $gear->delete();

        return redirect()->route('admin.inventory')->with('success', 'Gear berhasil dihapus.');
    }
}
