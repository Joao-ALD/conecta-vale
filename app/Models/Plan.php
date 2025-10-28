<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    // Permite preencher todos os campos via create() ou update()
    protected $guarded = [];

    protected $casts = [
        'features' => 'array',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getMaxProductsAttribute()
    {
        return $this->features['max_products'] ?? 1;
    }

    public function getMaxPhotosPerProductAttribute()
    {
        return $this->features['max_photos_per_product'] ?? 1;
    }

    public function getCanHighlightProductsAttribute()
    {
        return $this->features['can_highlight_products'] ?? false;
    }
}
