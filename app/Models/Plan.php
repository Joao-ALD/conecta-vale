<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    // Permite preencher todos os campos via create() ou update()
    protected $guarded = []; 

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}