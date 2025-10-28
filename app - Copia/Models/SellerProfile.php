<?php

namespace App\Models;

// 1. ADICIONE ESTE 'USE' NO TOPO
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    // 2. ADICIONE ESTA LINHA DENTRO DA CLASSE
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'store_name',
        'document_type',
        'document_number',
        'phone',
    ];

    /**
     * Pega o usuário (User) dono deste perfil.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}