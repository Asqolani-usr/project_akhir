<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    public function index()
    {
        $leaders = Leader::latest()->get();
        return view('admin.leaders', compact('leaders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:300',
            'fee_per_day' => 'required|integer|min:0',
        ]);

        Leader::create([
            'name' => $request->name,
            'phone' => $request->phone ?? '',
            'address' => $request->address ?? '',
            'fee_per_day' => $request->fee_per_day,
            'is_active' => true,
        ]);

        return redirect()->route('admin.leaders')->with('success', 'Leader berhasil ditambahkan.');
    }

    public function update(Request $request, Leader $leader)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:300',
            'fee_per_day' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $leader->update([
            'name' => $request->name,
            'phone' => $request->phone ?? '',
            'address' => $request->address ?? '',
            'fee_per_day' => $request->fee_per_day,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.leaders')->with('success', 'Leader berhasil diperbarui.');
    }

    public function destroy(Leader $leader)
    {
        $leader->delete();
        return redirect()->route('admin.leaders')->with('success', 'Leader berhasil dihapus.');
    }
}
