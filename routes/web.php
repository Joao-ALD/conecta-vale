<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
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
});

//? Rotas do Vendedor
Route::middleware(['auth', 'role:vendedor'])->group(function () {
    Route::get('/vendedor/produtos', [ProductController::class, 'myProducts'])->name('seller.products');

    Route::get('/produtos/criar', [ProductController::class, 'create'])->name('products.create');
    Route::post('/produtos', [ProductController::class, 'store'])->name('products.store');

    Route::get('/produtos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produtos/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produtos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

//? Rotas de Ações Protegidas (Carrinho, Contato, etc.)
Route::middleware(['auth'])->group(function () {

    // --- ROTAS DO CARRINHO ---
    Route::post('/carrinho/adicionar/{product}', [CartController::class, 'store'])->name('cart.store');

    Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/carrinho/remover/{product}', [CartController::class, 'destroy'])->name('cart.destroy'); // --- ROTAS DE MENSAGENS ---
    Route::get('/mensagens', [ContactController::class, 'inbox'])->name('contact.inbox');
    Route::get('/contato/{product}', [ContactController::class, 'showConversation'])->name('contact.show');
    Route::post('/contato/{product}', [ContactController::class, 'sendMessage'])->name('contact.send');

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
