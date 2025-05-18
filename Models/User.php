<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Fillable fields
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'role',
        // Add any other fields as needed
    ];

    // Hidden fields
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts for specific fields
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Get the unread notifications for the user.
     */
    public function unread()
    {
        return $this->unreadNotifications();
    }

    /**
     * Get the products created by the user.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the orders placed by the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Users this user is subscribed to (many-to-many).
     */
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'user_id', 'seller_id');
    }
    
    /**
     * Subscribers of this user (one-to-many).
     */
    public function subscribers()
    {
        return $this->hasMany(Subscription::class, 'seller_id');
    }
}