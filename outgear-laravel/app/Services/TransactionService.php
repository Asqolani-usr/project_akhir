<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Gear;
use App\Models\Leader;
use App\Models\Customer;
use App\Models\Notification;
use Carbon\Carbon;

class TransactionService
{
    public function __construct(private StockService $stockService) {}

    /**
     * Buat booking baru dan kurangi stok.
     *
     * @throws \RuntimeException Jika stok tidak mencukupi.
     */
    public function createBooking(array $data, int $userId, string $customerName, string $customerEmail): Transaction
    {
        $rentalStart = Carbon::parse($data['rental_start']);
        $rentalEnd = Carbon::parse($data['rental_end']);
        $totalDays = max(1, $rentalStart->diffInDays($rentalEnd));

        $leader = null;
        $leaderFee = 0;
        $leaderCost = 0;

        if (!empty($data['leader_id'])) {
            $leader = Leader::find($data['leader_id']);
            if ($leader) {
                $leaderFee = $leader->fee_per_day;
                $leaderCost = $leaderFee * $totalDays;
            }
        }

        $gearCost = 0;
        $normalizedItems = [];

        // Validasi stok sebelum membuat transaksi
        foreach ($data['items'] as $itemData) {
            $gear = Gear::findOrFail($itemData['gear_id']);
            $qty = max(1, (int) ($itemData['quantity'] ?? 1));

            if ($gear->stock < $qty) {
                throw new \RuntimeException(
                    "Stok \"{$gear->name}\" tidak mencukupi (tersedia: {$gear->stock}, dibutuhkan: {$qty})."
                );
            }

            $subtotal = $gear->price_per_day * $qty * $totalDays;
            $gearCost += $subtotal;

            $normalizedItems[] = [
                'gear_id' => $gear->id,
                'gear_name' => $gear->name,
                'quantity' => $qty,
                'price_per_day' => $gear->price_per_day,
                'subtotal' => $subtotal,
            ];
        }

        $transaction = Transaction::create([
            'code' => Transaction::generateCode(),
            'user_id' => $userId,
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'leader_id' => $leader?->id,
            'leader_name' => $leader?->name ?? '',
            'leader_fee' => $leaderFee,
            'rental_start' => $rentalStart,
            'rental_end' => $rentalEnd,
            'total_days' => $totalDays,
            'gear_cost' => $gearCost,
            'leader_cost' => $leaderCost,
            'late_fee' => 0,
            'total_cost' => $gearCost + $leaderCost,
            'status' => 'Menunggu Konfirmasi',
            'payment_confirmed' => false,
            'stock_reduced' => false,
            'payment_method' => $data['payment_method'] ?? null,
        ]);

        foreach ($normalizedItems as $item) {
            $transaction->items()->create($item);
        }

        // Kurangi stok setelah transaksi dan items berhasil dibuat
        $this->stockService->reduceStock($transaction);

        // Update customer transaction count
        Customer::where('user_id', $userId)->increment('total_transactions');

        // Create notification
        Notification::create([
            'type' => 'booking_confirmed',
            'title' => 'Pesanan Baru',
            'message' => "Pesanan {$transaction->code} berhasil dibuat. Silakan upload bukti pembayaran.",
            'transaction_id' => $transaction->id,
            'user_id' => $userId,
            'icon' => '📋',
        ]);

        return $transaction->load('items');
    }

    public function calculateLateFee(Transaction $transaction): int
    {
        if (!$transaction->return_date || !$transaction->rental_end) {
            return 0;
        }

        $end = Carbon::parse($transaction->rental_end);
        $returnDate = Carbon::parse($transaction->return_date);

        if ($returnDate->lte($end)) {
            return 0;
        }

        $lateDays = $end->diffInDays($returnDate);
        return (int) round($transaction->gear_cost * 0.1 * $lateDays);
    }
}
