<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SellerProfileController;
use Illuminate\Support\Facades\Route;

// ?Página Principal (Home)
Route::get('/', [HomeController::class, 'index'])->name('home');
// Ver um produto específico
Route::get('/produto/{product}', [ProductController::class, 'show'])->name('products.show');
// Ver todos os produtos de uma categoria
Route::get('/categoria/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
// Pesquisar produtos
Route::get('/search', [HomeController::class, 'search'])->name('search');

// ? Rotas do Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // * Rotas de Gerenciamento de Categorias *
    Route::post('/admin/categorias', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/admin/categorias/{category}/editar', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/admin/categorias/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/admin/categorias/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');

    // * Rotas de Gerenciamento de Usuários *
    Route::get('/admin/usuarios', [AdminController::class, 'listUsers'])->name('admin.users.index');
    Route::get('/admin/usuarios/{user}/editar', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/usuarios/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/usuarios/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // * Rotas de Gerenciamento de Produtos *
    Route::delete('/admin/produtos/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
});

// --- ROTAS DO VENDEDOR ---

// Rotas que EXIGEM perfil completo
Route::middleware(['auth', 'role:vendedor', 'seller.profile.complete'])->group(function () {
    Route::get('/vendedor/produtos', [ProductController::class, 'myProducts'])->name('seller.products');
    Route::get('/produtos/criar', [ProductController::class, 'create'])->name('products.create');
    Route::post('/produtos', [ProductController::class, 'store'])->name('products.store');
    Route::get('/produtos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produtos/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produtos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    // Adicione outras rotas de vendedor aqui no futuro (ex: painel de vendas)
});

// Rotas para CRIAR o perfil (não exigem perfil completo)
Route::middleware(['auth', 'role:vendedor'])->group(function () {
    Route::get('/vendedor/perfil/criar', [SellerProfileController::class, 'create'])->name('seller.profile.create');
    Route::post('/vendedor/perfil', [SellerProfileController::class, 'store'])->name('seller.profile.store');
});

//? Rotas de Ações Protegidas (Carrinho, Contato, etc.)
Route::middleware(['auth'])->group(function () {

    // --- ROTAS DO CARRINHO ---
    Route::post('/carrinho/adicionar/{product}', [CartController::class, 'store'])->name('cart.store');

    Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
        // --- ROTAS DE MENSAGENS ---
    Route::get('/mensagens', [ContactController::class, 'inbox'])->name('contact.inbox');
    
    // Rota para um COMPRADOR iniciar uma conversa a partir de um produto
    Route::get('/contato/{product}', [ContactController::class, 'initiateConversation'])->name('contact.initiate');

    // Rota para EXIBIR uma conversa existente (para comprador e vendedor)
    Route::get('/conversations/{conversation}', [ContactController::class, 'showConversation'])->name('contact.show');

    // Rota para ENVIAR uma mensagem em uma conversa existente
    Route::post('/conversations/{conversation}', [ContactController::class, 'sendMessage'])->name('contact.send');

});

//? Rotas do Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
