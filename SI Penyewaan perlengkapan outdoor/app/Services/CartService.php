<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'mangkurinjani_cart';

    public function items(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function itemCount(): int
    {
        return array_sum(array_column($this->items(), 'quantity'));
    }

    public function subtotalPerDay(): int
    {
        return array_sum(array_map(
            fn($item) => $item['price_per_day'] * $item['quantity'],
            $this->items()
        ));
    }

    public function add(array $gear, int $quantity = 1): void
    {
        $items = $this->items();
        $gearId = $gear['id'];
        $stock = $gear['stock'];

        // Jangan izinkan menambah item yang stoknya habis
        if ($stock <= 0) {
            return;
        }

        $existingIndex = null;
        foreach ($items as $index => $item) {
            if ($item['gear_id'] == $gearId) {
                $existingIndex = $index;
                break;
            }
        }

        if ($existingIndex !== null) {
            $items[$existingIndex]['quantity'] = min(
                $items[$existingIndex]['quantity'] + $quantity,
                $stock
            );
            $items[$existingIndex]['stock'] = $stock;
            $items[$existingIndex]['price_per_day'] = $gear['price_per_day'];
        } else {
            $items[] = [
                'gear_id' => $gearId,
                'gear_name' => $gear['name'],
                'category' => $gear['category'],
                'price_per_day' => $gear['price_per_day'],
                'stock' => $stock,
                'quantity' => min($quantity, $stock),
                'image' => $gear['image_url'] ?? '',
            ];
        }

        Session::put(self::SESSION_KEY, $items);
    }

    public function updateQuantity(int $gearId, int $quantity): void
    {
        $items = $this->items();

        foreach ($items as &$item) {
            if ($item['gear_id'] == $gearId) {
                $item['quantity'] = max(1, min($quantity, $item['stock']));
                break;
            }
        }

        Session::put(self::SESSION_KEY, $items);
    }

    public function remove(int $gearId): void
    {
        $items = array_values(array_filter(
            $this->items(),
            fn($item) => $item['gear_id'] != $gearId
        ));

        Session::put(self::SESSION_KEY, $items);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }
}
