<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_code',
        'total_amount',
        'order_status',
        'payment_status',
        'payment_method',
        'midtrans_order_id',

        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'note',

        'snap_token', // ⬅️ WAJIB

    ];

    // 🔗 RELATION
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
