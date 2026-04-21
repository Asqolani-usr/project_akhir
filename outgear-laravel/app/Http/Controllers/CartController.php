<?php

namespace App\Http\Controllers;

use App\Models\Gear;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index()
    {
        return response()->json([
            'items' => $this->cart->items(),
            'item_count' => $this->cart->itemCount(),
            'subtotal_per_day' => $this->cart->subtotalPerDay(),
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'gear_id' => 'required|exists:gears,id',
            'quantity' => 'integer|min:1',
        ]);

        $gear = Gear::findOrFail($request->gear_id);
        $qty = $request->integer('quantity', 1);

        if ($gear->stock <= 0) {
            return response()->json(['message' => 'Stok barang ini sudah habis.'], 422);
        }

        if ($qty > $gear->stock) {
            return response()->json(['message' => "Stok tidak mencukupi (tersedia: {$gear->stock})."], 422);
        }

        $this->cart->add([
            'id' => $gear->id,
            'name' => $gear->name,
            'category' => $gear->category,
            'price_per_day' => $gear->price_per_day,
            'stock' => $gear->stock,
            'image_url' => $gear->image_url,
        ], $qty);

        return response()->json([
            'message' => 'Item ditambahkan ke keranjang.',
            'items' => $this->cart->items(),
            'item_count' => $this->cart->itemCount(),
            'subtotal_per_day' => $this->cart->subtotalPerDay(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'gear_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cart->updateQuantity($request->gear_id, $request->quantity);

        return response()->json([
            'items' => $this->cart->items(),
            'item_count' => $this->cart->itemCount(),
            'subtotal_per_day' => $this->cart->subtotalPerDay(),
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate(['gear_id' => 'required|integer']);
        $this->cart->remove($request->gear_id);

        return response()->json([
            'items' => $this->cart->items(),
            'item_count' => $this->cart->itemCount(),
            'subtotal_per_day' => $this->cart->subtotalPerDay(),
        ]);
    }

    public function clear()
    {
        $this->cart->clear();
        return response()->json(['message' => 'Keranjang dikosongkan.', 'items' => [], 'item_count' => 0]);
    }
}
