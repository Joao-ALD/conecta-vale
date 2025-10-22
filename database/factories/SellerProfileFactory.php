<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SellerProfile>
 */
class SellerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $docType = $this->faker->randomElement(['cpf', 'cnpj']);
        $docNumber = ($docType == 'cpf') 
            ? $this->faker->unique()->numerify('###########') 
            : $this->faker->unique()->numerify('##############');

        return [
            // user_id será fornecido pela UserFactory
            'store_name' => $this->faker->company(),
            'document_type' => $docType,
            'document_number' => $docNumber,
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}