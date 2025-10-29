<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class);
    }

    public function conversations()
    {
        // Retorna conversas onde o usuário é comprador OU vendedor
        return $this->hasMany(Conversation::class, 'buyer_id')
                    ->orWhere('seller_id', $this->id);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function currentSubscription()
    {
        return $this->subscriptions()->latest()->first();
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorite_product', 'user_id', 'product_id')->withTimestamps();
    }
}
