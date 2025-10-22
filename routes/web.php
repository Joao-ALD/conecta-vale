<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Página Principal (Home)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Ver um produto específico
Route::get('/produto/{product}', [ProductController::class, 'show'])->name('products.show');

// Ver todos os produtos de uma categoria
Route::get('/categoria/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Rota do Painel Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Rotas do Vendedor
Route::middleware(['auth', 'role:vendedor'])->group(function () {
    Route::get('/vendedor/produtos', [ProductController::class, 'myProducts'])->name('seller.products');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';