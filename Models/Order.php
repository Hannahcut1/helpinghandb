<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // The table associated with the model (optional if the table name is 'orders')
    protected $table = 'orders';

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_method',
        'shipping_address',
        'order_date',
        // add any other relevant columns like transaction_id, delivery_date etc.
    ];

    // Relationships

    // An order belongs to a user (buyer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order has many order items (products in the order)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
