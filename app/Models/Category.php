<?php

namespace App\Models;

// 1. ADICIONE ESTE 'USE' NO TOPO
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // 2. ADICIONE ESTA LINHA DENTRO DA CLASSE
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}