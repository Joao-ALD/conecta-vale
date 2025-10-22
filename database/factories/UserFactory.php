<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\SellerProfile; // Importe o SellerProfile
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * A senha padrão para todos os usuários criados.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'), // Senha padrão: 'password'
            'remember_token' => Str::random(10),
            'role' => 'usuario', // Role padrão
        ];
    }

    /**
     * Indica que o usuário é um administrador.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Indica que o usuário é um vendedor.
     */
    public function vendedor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'vendedor',
        ]);
    }

    /**
     * Configura o model após a criação.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            // Se o usuário criado for um vendedor, crie um perfil para ele
            if ($user->role === 'vendedor') {
                SellerProfile::factory()->create(['user_id' => $user->id]);
            }
        });
    }

    /**
     * Indica que o e-mail do usuário não foi verificado.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}