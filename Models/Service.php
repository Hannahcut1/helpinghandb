<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seller;

class Service extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's naming convention)
    // protected $table = 'services';

    // Primary key (optional if it's 'id')
    // protected $primaryKey = 'id';

    // Mass assignable attributes (fill these with your service fields)
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration', // example: duration of service in minutes
        'seller_id', // if a service belongs to a seller
        // add other columns here as needed
    ];

    /**
     * Define relationship to Seller (if applicable)
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * (Optional) Define other relationships, e.g., orders, categories, etc.
     */

    // Any additional methods for business logic related to Service can go here
}
