<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'customer_name',
        'customer_email',
        'leader_id',
        'leader_name',
        'leader_fee',
        'rental_start',
        'rental_end',
        'return_date',
        'total_days',
        'gear_cost',
        'leader_cost',
        'late_fee',
        'total_cost',
        'status',
        'rejection_reason',
        'payment_proof',
        'payment_confirmed',
        'stock_reduced',
    ];

    protected function casts(): array
    {
        return [
            'rental_start' => 'date',
            'rental_end' => 'date',
            'return_date' => 'date',
            'payment_confirmed' => 'boolean',
            'stock_reduced' => 'boolean',
            'gear_cost' => 'integer',
            'leader_cost' => 'integer',
            'late_fee' => 'integer',
            'total_cost' => 'integer',
            'leader_fee' => 'integer',
            'total_days' => 'integer',
        ];
    }

    public const STATUSES = [
        'Menunggu Konfirmasi',
        'Dikonfirmasi',
        'Dipinjam',
        'Dikembalikan',
        'Terlambat',
        'Selesai',
        'Ditolak',
    ];

    public const ACTIVE_STATUSES = [
        'Menunggu Konfirmasi',
        'Dikonfirmasi',
        'Dipinjam',
        'Terlambat',
    ];

    public static function generateCode(): string
    {
        return 'TRX' . now()->format('ymd') . strtoupper(substr(uniqid(), -5));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leader()
    {
        return $this->belongsTo(Leader::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    public function getPaymentProofUrlAttribute(): string
    {
        if (empty($this->payment_proof)) {
            return '';
        }

        if (str_starts_with($this->payment_proof, 'http')) {
            return $this->payment_proof;
        }

        return asset('storage/' . ltrim($this->payment_proof, '/'));
    }
}
