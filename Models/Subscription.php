<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Order;
use App\Models\Product;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_id',
        'status', // Add other fields as necessary
    ];

    /**
     * The user who made the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The seller that the user is subscribed to.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}