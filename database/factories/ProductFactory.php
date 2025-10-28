<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // user_id (o vendedor) será fornecido pelo DatabaseSeeder
            'name' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 10, 5000), 
        ];
    }

    /**
     * Configura o model após a criação.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            // Pega de 1 a 3 categorias aleatórias que já existem
            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            // Vincula o produto a essas categorias (relação many-to-many)
            $product->categories()->attach($categories);
        });
    }
}