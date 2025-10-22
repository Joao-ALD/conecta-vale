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
        $products = Product::latest()->paginate(15);
        $categories = Category::all();
        
        // O Breeze usa a view 'welcome' por padrão para a home
        // Podemos usar ela ou criar uma nova view 'home'.
        // Vamos usar a 'welcome' por enquanto.
        return view('welcome', compact('products', 'categories'));
    }
}