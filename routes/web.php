<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\OrderController;
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
    
    // * Rotas de Gerenciamento de Categorias (Admin) *
    Route::get('/admin/categorias', [AdminController::class, 'listCategory'])->name('admin.categories.index');
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
    Route::get('/admin/produtos', [AdminController::class, 'listProducts'])->name('admin.products.index');
    Route::delete('/admin/produtos/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');

    // * Rotas de Gerenciamento de Planos *
    Route::get('/admin/planos', [AdminController::class, 'listPlans'])->name('admin.plans.index');
    Route::get('/admin/planos/criar', [AdminController::class, 'createPlan'])->name('admin.plans.create');
    Route::post('/admin/planos', [AdminController::class, 'storePlan'])->name('admin.plans.store');
    Route::get('/admin/planos/{plan}/editar', [AdminController::class, 'editPlan'])->name('admin.plans.edit');
    Route::put('/admin/planos/{plan}', [AdminController::class, 'updatePlan'])->name('admin.plans.update');
    Route::delete('/admin/planos/{plan}', [AdminController::class, 'destroyPlan'])->name('admin.plans.destroy');
});

// Rotas que EXIGEM perfil completo
Route::middleware(['auth', 'role:vendedor', 'seller.profile.complete', 'subscription.active'])->group(function () {
    // Rota customizada para listar "Meus Produtos" (o index do vendedor)
    Route::get('/vendedor/meus-produtos', [ProductController::class, 'myProducts'])->name('products.my');

    // Esta linha substitui as 5 rotas de CRUD (create, store, edit, update, destroy)
    Route::resource('products', ProductController::class)->except([
        'index',
        'show'
    ]);

    // Adicione outras rotas de vendedor aqui no futuro (ex: painel de vendas)
});

// Rotas para CRIAR o perfil (não exigem perfil completo)
Route::middleware(['auth', 'role:vendedor'])->group(function () {
    Route::get('/vendedor/perfil/criar', [SellerProfileController::class, 'create'])->name('seller.profile.create');
    Route::post('/vendedor/perfil', [SellerProfileController::class, 'store'])->name('seller.profile.store');
    Route::get('/vendedor/perfil/editar', [SellerProfileController::class, 'edit'])->name('seller.profile.edit');
    Route::put('/vendedor/perfil', [SellerProfileController::class, 'update'])->name('seller.profile.update');

    Route::get('/vendedor/planos', [SellerProfileController::class, 'showPlans'])->name('seller.plans.show');
    Route::post('/vendedor/planos/assinar', [SellerProfileController::class, 'subscribeToPlan'])->name('seller.plans.subscribe');
    
    // Rotas para GERENCIAR o perfil (exigem perfil completo)
    Route::get('/vendedor/perfil/editar', [SellerProfileController::class, 'edit'])->name('seller.profile.edit'); // Editar
    Route::put('/vendedor/perfil', [SellerProfileController::class, 'update'])->name('seller.profile.update'); // Atualizar
});

// Rotas para CRIAR o perfil (não exigem perfil completo, mas exigem ser vendedor)
Route::middleware(['auth', 'role:vendedor', 'seller.profile.incomplete'])->group(function () {
    Route::get('/vendedor/perfil/criar', [SellerProfileController::class, 'create'])->name('seller.profile.create'); // Criar
    Route::post('/vendedor/perfil', [SellerProfileController::class, 'store'])->name('seller.profile.store'); // Armazenar
});

//? Rotas de Ações Protegidas (Carrinho, Contato, Perfil de Usuário)
Route::middleware(['auth'])->group(function () {

    // --- ROTAS DO CARRINHO ---
    Route::post('/carrinho/adicionar/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/carrinho/remover/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

    // --- ROTAS DE CHECKOUT ---
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // --- ROTAS DE MENSAGENS ---
    Route::get('/mensagens', [ContactController::class, 'inbox'])->name('contact.inbox');

    // Rota para um COMPRADOR iniciar uma conversa a partir de um produto
    Route::get('/contato/{product}', [ContactController::class, 'initiateConversation'])->name('contact.initiate');

    // Rota para EXIBIR uma conversa existente (para comprador e vendedor)
    Route::get('/conversations/{conversation}', [ContactController::class, 'showConversation'])->name('contact.show');

    // Rota para ENVIAR uma mensagem em uma conversa existente
    Route::post('/conversations/{conversation}', [ContactController::class, 'sendMessage'])->name('contact.send');

    // --- ROTAS DE FAVORITOS ---
    Route::post('/favoritos/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
});
// --- ROTAS DE PERFIL DE USUÁRIO (Breeze) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Editar
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Atualizar
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Excluir
    Route::post('/tornar-vendedor', [ProfileController::class, 'becomeSeller'])->name('user.becomeSeller');
});

// Rota do Dashboard (Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
