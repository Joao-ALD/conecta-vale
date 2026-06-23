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
        $jsonPath = database_path('seeders/data/products.json');

        if (!file_exists($jsonPath)) {
            Log::error("Arquivo de dados JSON não encontrado em: {$jsonPath}");
            return;
        }

        $productsData = json_decode(file_get_contents($jsonPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("Erro ao decodificar JSON em {$jsonPath}: " . json_last_error_msg());
            return;
        }

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
            // Fallback: avoid memory leaks on large databases
            Log::warning('ProductSeeder: no users with sellerProfile found; using limited fallback user list.');
            $vendedores = User::inRandomOrder()->limit(100)->get();
        }

        if ($vendedores->isEmpty()) {
            Log::warning('Nenhum usuário encontrado para atribuir os produtos.');
            return;
        }

        foreach ($productsData as $data) {
            // 0. JSON Validation Guard
            if (!isset($data['name'], $data['description'], $data['price'], $data['category'], $data['image_url'])) {
                Log::warning('ProductSeeder: Skipping item due to missing required keys.', ['item' => $data]);
                continue;
            }

            // 1. Identify or Create the Category
            $categoryName = $data['category'];
            $categorySlug = Str::slug($categoryName);

            $category = Category::firstOrCreate(
                ['slug' => $categorySlug],
                ['name' => $categoryName]
            );

            // 2. Create or Update the Product assigned to a random seller (idempotent)
            // Use firstOrCreate to ensure existing products keep their original owner.
            // If the product exists by name, we fetch it. If not, we create it and assign a random seller.
            $vendedor = $vendedores->random();

            $product = Product::firstOrCreate(
                [
                    'name' => $data['name'],
                ],
                [
                    'user_id' => $vendedor->id,
                    'description' => $data['description'],
                    'price' => $data['price'],
                ]
            );

            // If it already existed, we still want to update its description and price to match the seeder data,
            // but WITHOUT changing the `user_id`.
            if (!$product->wasRecentlyCreated) {
                $product->update([
                    'description' => $data['description'],
                    'price' => $data['price'],
                ]);
            }

            // 3. Attach Product to Category (syncWithoutDetaching prevents duplicates)
            $product->categories()->syncWithoutDetaching([$category->id]);

            // 4. Image wipe to prevent orphans
            $product->images()->delete();

            // 5. Image Caching and Download
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

                        // Save locally in public storage
                        Storage::disk('public')->put($imageName, $imageContent);

                        // Create ProductImage record
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
