<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // If your table name is not 'order_items', specify it here
    // protected $table = 'order_items';

    // Fillable fields for mass assignment
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        // Add any other fields you want to track
    ];

    /**
     * Get the order that owns this item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with this order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
