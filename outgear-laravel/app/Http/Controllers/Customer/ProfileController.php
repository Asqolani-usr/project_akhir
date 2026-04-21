<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('customer.profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:300',
        ]);

        $user = $request->user();
        $user->update($request->only(['name', 'phone', 'address']));

        Customer::where('user_id', $user->id)->update($request->only(['name', 'phone', 'address']));

        return redirect()->route('customer.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
