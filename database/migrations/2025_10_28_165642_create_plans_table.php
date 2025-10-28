<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Ex: Gratuito, Bronze, Prata, Ouro
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->default(0.00); // Preço mensal/anual
            $table->string('features')->nullable(); // JSON ou texto com os benefícios
            $table->boolean('is_active')->default(true); // Para ativar/desativar planos
            $table->timestamps(); // Adiciona created_at e updated_at
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
