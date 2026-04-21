<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'fee_per_day',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'fee_per_day' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
