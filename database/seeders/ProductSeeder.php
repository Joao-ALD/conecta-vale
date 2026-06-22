<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsData = [
            [
                'name' => 'Smartphone Pro Max',
                'description' => 'Smartphone de última geração com câmera de alta resolução, processador ultrarrápido e bateria de longa duração. Perfeito para fotos, jogos e trabalho.',
                'price' => 4500.00,
                'category' => 'Eletrônicos',
                'image_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Notebook Ultrafino',
                'description' => 'Notebook super leve e fino com tela de 15 polegadas, 16GB de RAM e 512GB de SSD. Ideal para profissionais e estudantes em movimento.',
                'price' => 3200.00,
                'category' => 'Eletrônicos',
                'image_url' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Smartwatch Esportivo',
                'description' => 'Relógio inteligente com monitoramento de batimentos cardíacos, GPS integrado e resistência à água até 50 metros. O companheiro perfeito para seus treinos.',
                'price' => 850.00,
                'category' => 'Eletrônicos',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Casa de Praia com Piscina',
                'description' => 'Maravilhosa casa de praia com 4 quartos, piscina privativa, churrasqueira e vista panorâmica para o mar. Excelente oportunidade de investimento ou lazer.',
                'price' => 850000.00,
                'category' => 'Imóveis',
                'image_url' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Apartamento Moderno no Centro',
                'description' => 'Apartamento recém-reformado no coração da cidade. Conceito aberto, iluminação natural, móveis planejados e varanda gourmet. Perto de tudo!',
                'price' => 420000.00,
                'category' => 'Imóveis',
                'image_url' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Carro Esportivo de Luxo',
                'description' => 'Veículo esportivo importado, motor V8, bancos em couro, teto solar e painel digital. Design aerodinâmico e performance excepcional nas pistas e ruas.',
                'price' => 350000.00,
                'category' => 'Veículos',
                'image_url' => 'https://images.unsplash.com/photo-1503376712351-1c258bbde084?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Moto Clássica Customizada',
                'description' => 'Motocicleta estilo retrô com motorização moderna. Totalmente customizada com escapamento esportivo e pintura exclusiva. Estilo e atitude sobre duas rodas.',
                'price' => 45000.00,
                'category' => 'Veículos',
                'image_url' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Sofá de Couro 3 Lugares',
                'description' => 'Elegante sofá revestido em couro legítimo, almofadas macias e estrutura de madeira maciça. Traz sofisticação e conforto para sua sala de estar.',
                'price' => 2800.00,
                'category' => 'Para sua Casa',
                'image_url' => 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Mesa de Jantar de Madeira',
                'description' => 'Mesa de jantar rústica feita em madeira de demolição, com acabamento envernizado. Comporta confortavelmente até 6 pessoas. Design atemporal.',
                'price' => 1500.00,
                'category' => 'Para sua Casa',
                'image_url' => 'https://images.unsplash.com/photo-1533090161767-e6ffed986c88?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Tênis de Corrida Performance',
                'description' => 'Calçado esportivo com tecnologia de amortecimento avançada, cabedal respirável e solado antiderrapante. Maximize sua velocidade e proteja suas articulações.',
                'price' => 600.00,
                'category' => 'Moda e Beleza',
                'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Jaqueta de Couro Vintage',
                'description' => 'Jaqueta de couro autêntica estilo aviador, forrada, com múltiplos bolsos e fecho em zíper resistente. Um clássico da moda que nunca perde o estilo.',
                'price' => 850.00,
                'category' => 'Moda e Beleza',
                'image_url' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Bicicleta de Montanha Aro 29',
                'description' => 'Bicicleta MTB com quadro em alumínio, freios a disco hidráulico, suspensão dianteira e câmbio de 21 marchas. Pronta para qualquer trilha.',
                'price' => 1800.00,
                'category' => 'Esportes e Lazer',
                'image_url' => 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Prancha de Surf Longboard',
                'description' => 'Prancha de surf 9 pés em epóxi, excelente flutuação e estabilidade. Ideal para surfistas iniciantes e experientes que curtem ondas menores e manobras clássicas.',
                'price' => 2200.00,
                'category' => 'Esportes e Lazer',
                'image_url' => 'https://images.unsplash.com/photo-1531722569936-825d3dd91b15?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Trator Agrícola Potente',
                'description' => 'Trator moderno para uso em propriedades rurais, alta potência, cabine climatizada e tração 4x4. Aumente a produtividade e eficiência no campo.',
                'price' => 150000.00,
                'category' => 'Agro e Indústria',
                'image_url' => 'https://images.unsplash.com/photo-1592982537447-6f204c3bd178?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Câmera Profissional DSLR',
                'description' => 'Câmera fotográfica com sensor Full Frame, gravação em 4K, foco automático ultra rápido e lentes intercambiáveis. O equipamento definitivo para fotógrafos e videomakers.',
                'price' => 12500.00,
                'category' => 'Eletrônicos',
                'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=800&auto=format&fit=crop',
            ],
        ];

        // Ensure the products storage directory exists
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
        }

        // Search for sellers (users with 'vendedor' role or with a seller profile)
        $vendedores = User::whereHas('sellerProfile')->get();
        if ($vendedores->isEmpty()) {
            // Fallback: use all users
            $vendedores = User::all();
        }

        if ($vendedores->isEmpty()) {
            Log::warning('Nenhum usuário encontrado para atribuir os produtos.');
            return;
        }

        foreach ($productsData as $data) {
            // 1. Identify or Create the Category
            $categoryName = $data['category'];
            $categorySlug = Str::slug($categoryName);

            $category = Category::firstOrCreate(
                ['slug' => $categorySlug],
                ['name' => $categoryName]
            );

            // 2. Create the Product assigned to a random seller
            $vendedor = $vendedores->random();

            $product = Product::create([
                'user_id' => $vendedor->id,
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
            ]);

            // 3. Attach Product to Category
            $product->categories()->attach($category->id);

            // 4. Download the image
            $imageUrl = $data['image_url'];
            $imageName = 'products/' . Str::uuid() . '.jpg';

            try {
                $response = Http::get($imageUrl);

                if ($response->successful()) {
                    $imageContent = $response->body();

                    // 5. Save locally in public storage
                    Storage::disk('public')->put($imageName, $imageContent);

                    // 6. Create ProductImage record
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $imageName,
                    ]);
                } else {
                    Log::error("Falha ao baixar imagem do produto {$data['name']}: HTTP status " . $response->status());
                }
            } catch (\Exception $e) {
                Log::error("Falha ao baixar imagem do produto {$data['name']}: {$e->getMessage()}");
            }
        }
    }
}
