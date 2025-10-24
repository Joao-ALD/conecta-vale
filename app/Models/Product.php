<?php

namespace App\Models;

use App\Models\ProductImage;
// 1. ADICIONE ESTE 'USE' NO TOPO
use Illuminate\Support\Facades\Storage;
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

    public function images()
    {
        // Retorna todas as imagens associadas, ordenadas pela coluna 'order'
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    /**
     * Pega a URL da primeira imagem do produto, ou um placeholder.
     */
    public function getFirstImageUrlAttribute()
    {
        // Pega a primeira imagem da relação
        $firstImage = $this->images()->first();

        if ($firstImage) {
            // Retorna a URL pública (ex: 'http://localhost/storage/products/imagem.jpg')
            return Storage::url($firstImage->path);
        }

        // Se não houver imagem, retorna o placeholder
        return 'https://via.placeholder.com/300x200.png?text=Sem+Imagem';
    }
}
