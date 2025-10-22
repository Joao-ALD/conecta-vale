<?php

namespace App\Models;

// 1. ADICIONE ESTE 'USE' NO TOPO
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // 2. ADICIONE ESTA LINHA DENTRO DA CLASSE
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}