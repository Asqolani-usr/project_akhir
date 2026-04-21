<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    protected $fillable = [
        'name',
        'category',
        'category_id',
        'price_per_day',
        'stock',
        'condition',
        'is_available',
        'description',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'price_per_day' => 'integer',
            'stock' => 'integer',
            'is_available' => 'boolean',
        ];
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return '';
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }
}
