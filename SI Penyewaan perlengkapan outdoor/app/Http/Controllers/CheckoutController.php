<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use App\Services\CartService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cart,
        private TransactionService $transactionService,
    ) {}

    public function show()
    {
        $items = $this->cart->items();
        if (empty($items)) {
            return redirect()->route('gear.index')->with('error', 'Keranjang kosong.');
        }

        $leaders = Leader::where('is_active', true)->get();
        $subtotalPerDay = $this->cart->subtotalPerDay();

        return view('checkout', compact('items', 'leaders', 'subtotalPerDay'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rental_start' => 'required|date|after_or_equal:today',
            'rental_end' => 'required|date|after:rental_start',
            'leader_id' => 'nullable|exists:leaders,id',
            'payment_method' => 'required|string|max:50',
        ]);

        $items = $this->cart->items();
        if (empty($items)) {
            return redirect()->route('gear.index')->with('error', 'Keranjang kosong.');
        }

        $user = $request->user();

        try {
            $transaction = $this->transactionService->createBooking([
                'rental_start' => $request->rental_start,
                'rental_end' => $request->rental_end,
                'leader_id' => $request->leader_id,
                'payment_method' => $request->payment_method,
                'items' => array_map(fn($item) => [
                    'gear_id' => $item['gear_id'],
                    'quantity' => $item['quantity'],
                ], $items),
            ], $user->id, $user->name, $user->email);
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $this->cart->clear();

        return redirect()->route('customer.transactions')
            ->with('success', "Pesanan {$transaction->code} berhasil dibuat! Silakan upload bukti pembayaran.");
    }
}
