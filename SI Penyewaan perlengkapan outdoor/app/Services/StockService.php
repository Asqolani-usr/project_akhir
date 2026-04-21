<?php

namespace App\Services;

use App\Models\Gear;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Validasi apakah semua item dalam transaksi memiliki stok yang cukup.
     *
     * @return array Array of error messages, empty if all stock is sufficient.
     */
    public function validateStock(Transaction $transaction): array
    {
        $transaction->loadMissing('items');
        $errors = [];

        foreach ($transaction->items as $item) {
            $gear = Gear::find($item->gear_id);

            if (!$gear) {
                $errors[] = "Produk \"{$item->gear_name}\" tidak ditemukan.";
                continue;
            }

            if ($gear->stock < $item->quantity) {
                $errors[] = "Stok \"{$gear->name}\" tidak mencukupi (tersedia: {$gear->stock}, dibutuhkan: {$item->quantity}).";
            }
        }

        return $errors;
    }

    /**
     * Kurangi stok gear sesuai item transaksi.
     * Menggunakan DB transaction & row locking untuk keamanan.
     *
     * @return bool True jika berhasil, false jika sudah diproses sebelumnya.
     * @throws \RuntimeException Jika stok tidak mencukupi.
     */
    public function reduceStock(Transaction $transaction): bool
    {
        // Cegah pengurangan ganda
        if ($transaction->stock_reduced) {
            return false;
        }

        $transaction->loadMissing('items');

        DB::transaction(function () use ($transaction) {
            foreach ($transaction->items as $item) {
                $gear = Gear::lockForUpdate()->find($item->gear_id);

                if (!$gear) {
                    throw new \RuntimeException("Produk \"{$item->gear_name}\" tidak ditemukan.");
                }

                if ($gear->stock < $item->quantity) {
                    throw new \RuntimeException(
                        "Stok \"{$gear->name}\" tidak mencukupi (tersedia: {$gear->stock}, dibutuhkan: {$item->quantity})."
                    );
                }

                $gear->decrement('stock', $item->quantity);
            }

            $transaction->update(['stock_reduced' => true]);
        });

        return true;
    }

    /**
     * Kembalikan stok gear yang sudah dikurangi.
     * Digunakan saat transaksi ditolak atau barang dikembalikan.
     *
     * @return bool True jika berhasil, false jika stok belum pernah dikurangi.
     */
    public function restoreStock(Transaction $transaction): bool
    {
        // Hanya restore jika stok pernah dikurangi
        if (!$transaction->stock_reduced) {
            return false;
        }

        $transaction->loadMissing('items');

        DB::transaction(function () use ($transaction) {
            foreach ($transaction->items as $item) {
                $gear = Gear::lockForUpdate()->find($item->gear_id);

                if ($gear) {
                    $gear->increment('stock', $item->quantity);
                }
            }

            $transaction->update(['stock_reduced' => false]);
        });

        return true;
    }
}
