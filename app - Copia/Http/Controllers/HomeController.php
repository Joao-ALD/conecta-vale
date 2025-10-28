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

    //** Mostra os resultados da busca.*/
    public function search(Request $request)
    {
        // 1. Validar a busca (removemos o 'min:3' e 'required')
        $validatedData = $request->validate([
            'q' => 'nullable|string',
        ]);

        $query = $validatedData['q'] ?? null;

        // 2. Se a busca for nula ou vazia, apenas redireciona para a home
        if (!$query || trim($query) === '') {
            return redirect()->route('home');
        }

        // 3. Fazer a busca no banco
        $products = Product::with('seller')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate(15);

        // 4. Reutilizar a sidebar de categorias
        $categories = Category::all();

        // 5. Retornar a view
        return view('search.results', compact('products', 'categories', 'query'));
    }
}
