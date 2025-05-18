<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    // Table name if not 'purchases'
    // protected $table = 'purchases';

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'quantity',
        'price', // price at time of purchase
        'total', // quantity * price or total for this purchase
        'status', // e.g. pending, completed, cancelled
        'payment_method', // e.g. COD, GCash
        'purchase_date',
    ];

    // Cast attributes to native types if needed
    protected $casts = [
        'purchase_date' => 'datetime',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * The user who made the purchase
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The order this purchase belongs to
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * The product purchased
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
