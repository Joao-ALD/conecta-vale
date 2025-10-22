<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Importe o Hash
use Illuminate\Support\Str; // Importe o Str

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- 1. Criar o Administrador Principal ---
        // (Isso usa o estado 'admin' que criamos na factory)
        User::factory()->admin()->create([
            'name' => 'Admin Conecta Vale',
            'email' => 'admin@conectavale.com',
            'password' => Hash::make('admin123'), // Senha fácil de lembrar
        ]);

        // --- 2. Criar Usuários Clientes ---
        // (Isso usa o role 'usuario' padrão)
        User::factory(10)->create();

        // --- 3. Criar Usuários Vendedores ---
        // (A mágica acontece aqui: a UserFactory vai chamar a SellerProfileFactory)
        $vendedores = User::factory(5)->vendedor()->create();

        // --- 4. Criar Categorias ---
        // Vamos criar algumas categorias específicas
        $categorias = [
            'Eletrônicos', 'Imóveis', 'Veículos', 'Para sua Casa', 'Moda e Beleza',
            'Esportes e Lazer', 'Agro e Indústria', 'Vagas de Emprego'
        ];
        
        foreach ($categorias as $categoria) {
            Category::factory()->create([
                'name' => $categoria,
                'slug' => Str::slug($categoria),
            ]);
        }
        
        // --- 5. Criar Produtos ---
        // Vamos criar 50 produtos, e para cada um,
        // escolher um dos vendedores aleatoriamente.
        Product::factory(50)
            ->sequence(fn () => [
                'user_id' => $vendedores->random()->id
            ])
            ->create();
        
        // O 'configure' da ProductFactory cuidará de anexar as categorias.
    }
}