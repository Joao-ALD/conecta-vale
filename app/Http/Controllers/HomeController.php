<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Importe o model Product
use App\Models\Category; // Importe o model Category

class HomeController extends Controller
{
    /**
     * Mostra a página inicial do site.
     */
    public function index()
    {
        // Use 'with('seller')' para carregar o vendedor junto (Eager Loading)
        $products = Product::with('seller')->latest()->paginate(16);
        $categories = Category::all();

        // O Breeze usa a view 'welcome' por padrão para a home
        return view('welcome', compact('products', 'categories'));
    }
}
