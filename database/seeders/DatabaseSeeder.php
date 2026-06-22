<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\SellerProfile;
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

        // --- 2b. Criar Vendedor de Teste Específico ---
        // (Este será o seu usuário manual)
        User::factory()
            ->vendedor() // Define a role='vendedor'
            ->has(SellerProfile::factory()->state([ // Cria um SellerProfile específico
                'store_name' => 'Loja do Vendedor Teste',
                'document_type' => 'cnpj',
                'document_number' => '00000000000001', // CNPJ único para teste
                'phone' => '(13) 99999-9999',
            ]))
            ->create([
                'name' => 'Vendedor Teste',
                'email' => 'vendedor@teste.com',
                'password' => Hash::make('password'), // Senha fácil: 'password'
            ]);

        // --- 3. Criar Usuários Vendedores ---
        // (A mágica acontece aqui: a UserFactory vai chamar a SellerProfileFactory)
        $vendedores = User::factory(5)->vendedor()->create();

        // --- 4. Criar Categorias ---
        $defaultCategory = Category::factory()->create([
            'name' => 'Sem Categoria',
            'slug' => 'sem-categoria',
        ]);
        // Vamos criar algumas categorias específicas com seus ícones SVG (Heroicons outline)
        $categorias = [
            'Eletrônicos' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>',
            'Imóveis' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
            'Veículos' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>',
            'Para sua Casa' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>',
            'Moda e Beleza' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>',
            'Esportes e Lazer' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'Agro e Indústria' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'Vagas de Emprego' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>'
        ];

        foreach ($categorias as $nome => $icon) {
            Category::factory()->create([
                'name' => $nome,
                'slug' => Str::slug($nome),
                'icon_svg' => $icon,
            ]);
        }

        // --- 5. Criar Produtos ---
        // Aqui chamamos o novo seeder que usa o dicionário de dados estático
        // para garantir consistência e baixar imagens reais
        $this->call(ProductSeeder::class);
    }
}
