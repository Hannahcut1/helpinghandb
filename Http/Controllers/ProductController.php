<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Order;

class Product extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's naming convention)
    protected $table = 'products';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',    // if you're categorizing products
        'seller_id',      // if a product belongs to a seller
        'image_path',     // if you store an image URL or path
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // Optional: if you have a categories table
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class); // If you track cart items per product
    }
}
