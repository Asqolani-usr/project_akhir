<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Transaction;
use App\Services\StockService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService,
        private StockService $stockService,
    ) {}

    public function index(Request $request)
    {
        $query = Transaction::with('items', 'user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->get();

        return view('admin.transactions', compact('transactions'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Transaction::STATUSES),
            'rejection_reason' => 'nullable|string|max:500',
            'return_date' => 'nullable|date',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'Ditolak') {
            $data['rejection_reason'] = $request->rejection_reason ?? '';
            $data['payment_confirmed'] = false;

            // Kembalikan stok jika transaksi ditolak dan stok sudah pernah dikurangi
            try {
                $this->stockService->restoreStock($transaction);
            } catch (\Exception $e) {
                return redirect()->route('admin.transactions')
                    ->with('error', "Gagal mengembalikan stok: {$e->getMessage()}");
            }
        }

        if ($request->status === 'Dikonfirmasi') {
            $data['payment_confirmed'] = true;
        }

        // Kembalikan stok saat barang dikembalikan (sistem rental)
        if (in_array($request->status, ['Dikembalikan', 'Selesai'])) {
            try {
                $this->stockService->restoreStock($transaction);
            } catch (\Exception $e) {
                return redirect()->route('admin.transactions')
                    ->with('error', "Gagal mengembalikan stok: {$e->getMessage()}");
            }
        }

        if ($request->filled('return_date')) {
            $data['return_date'] = $request->return_date;
            $lateFee = $this->transactionService->calculateLateFee(
                tap($transaction, fn($t) => $t->return_date = $request->return_date)
            );
            $data['late_fee'] = $lateFee;
            $data['total_cost'] = $transaction->gear_cost + $transaction->leader_cost + $lateFee;
        }

        $transaction->update($data);

        // Create notification for customer
        $notifMessages = [
            'Dikonfirmasi' => ['title' => 'Pembayaran Dikonfirmasi', 'message' => "Pembayaran untuk pesanan {$transaction->code} telah dikonfirmasi.", 'type' => 'payment_confirmed', 'icon' => '✅'],
            'Dipinjam' => ['title' => 'Status Diperbarui', 'message' => "Pesanan {$transaction->code} sudah dalam status Dipinjam.", 'type' => 'status_changed', 'icon' => '📦'],
            'Dikembalikan' => ['title' => 'Barang Dikembalikan', 'message' => "Pesanan {$transaction->code} telah dikembalikan.", 'type' => 'status_changed', 'icon' => '🔄'],
            'Selesai' => ['title' => 'Transaksi Selesai', 'message' => "Pesanan {$transaction->code} telah selesai. Terima kasih!", 'type' => 'status_changed', 'icon' => '🎉'],
            'Ditolak' => ['title' => 'Pembayaran Ditolak', 'message' => "Pembayaran untuk pesanan {$transaction->code} ditolak. " . ($request->rejection_reason ?? ''), 'type' => 'status_changed', 'icon' => '❌'],
        ];

        if (isset($notifMessages[$request->status])) {
            $n = $notifMessages[$request->status];
            Notification::create([
                'type' => $n['type'],
                'title' => $n['title'],
                'message' => $n['message'],
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'icon' => $n['icon'],
            ]);
        }

        return redirect()->route('admin.transactions')->with('success', "Status transaksi {$transaction->code} diperbarui ke {$request->status}.");
    }
}

