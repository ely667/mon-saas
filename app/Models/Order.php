<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = [
        'pending' => 'En attente',
        'confirmed' => 'Confirmee',
        'preparing' => 'Preparation',
        'delivering' => 'Livraison',
        'delivered' => 'Livree',
        'cancelled' => 'Annulee',
    ];

    protected $fillable = [
        'shop_id',
        'customer_name',
        'customer_phone',
        'customer_commune',
        'customer_note',
        'status',
        'total_amount',
        'payment_method',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'integer',
        ];
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
