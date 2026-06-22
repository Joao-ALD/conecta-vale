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
        $jsonPath = __DIR__ . '/data/products.json';

        if (!file_exists($jsonPath)) {
            Log::error("Arquivo de dados JSON não encontrado em: {$jsonPath}");
            return;
        }

        $productsData = json_decode(file_get_contents($jsonPath), true);

        if (!is_array($productsData)) {
            Log::error("Formato de dados JSON inválido. O conteúdo de {$jsonPath} deve ser um array válido.");
            return;
        }

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

            // 4. Image Caching and Download
            $imageUrl = $data['image_url'];

            // Generate deterministic file name based on URL
            $imageHash = md5($imageUrl);

            $possibleExtensions = ['jpg', 'png', 'webp', 'gif'];
            $existingFile = null;

            foreach ($possibleExtensions as $ext) {
                $possiblePath = "products/{$imageHash}.{$ext}";
                if (Storage::disk('public')->exists($possiblePath)) {
                    $existingFile = $possiblePath;
                    break;
                }
            }

            if ($existingFile) {
                // File exists, skip download
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $existingFile,
                ]);
            } else {
                // File does not exist, download it
                try {
                    $response = Http::timeout(10)->retry(2, 200)->get($imageUrl);

                    if ($response->successful()) {
                        $imageContent = $response->body();
                        $contentType = $response->header('Content-Type') ?? '';

                        // Derive extension from content type
                        $extension = 'jpg'; // Default fallback
                        if (str_contains($contentType, 'image/jpeg')) {
                            $extension = 'jpg';
                        } elseif (str_contains($contentType, 'image/png')) {
                            $extension = 'png';
                        } elseif (str_contains($contentType, 'image/webp')) {
                            $extension = 'webp';
                        } elseif (str_contains($contentType, 'image/gif')) {
                            $extension = 'gif';
                        }

                        $imageName = 'products/' . $imageHash . '.' . $extension;

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
}
