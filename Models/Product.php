<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seller;

class Product extends Model
{
    use HasFactory;

    // Define the table if it’s not 'products' (default plural form of model)
    // protected $table = 'products';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'seller_id',  // assuming each product is linked to a seller
        'category_id', // optional, if you have categories
        'image_path',  // path or URL of product image
        // add other product fields here
    ];

    // If you want to hide certain fields in JSON responses
    // protected $hidden = [];

    // Cast attributes to specific types
    // protected $casts = [
    //     'price' => 'float',
    //     'created_at' => 'datetime',
    // ];

    // Relationships

    // A Product belongs to a Seller (if you have sellers)
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // A Product can have many Orders (through an order_items pivot, for example)
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    // If product has images separately stored
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
