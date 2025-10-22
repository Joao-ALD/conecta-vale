<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Pega todas as categorias para o formulário
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados (essencial!)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'categories' => 'required|array|min:1', // Deve ser um array e ter pelo menos 1
            'categories.*' => 'exists:categories,id', // Verifica se cada ID de categoria existe
        ]);

        // 2. Criação do Produto
        $product = Product::create([
            'user_id' => Auth::id(), // Pega o ID do vendedor logado
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
        ]);

        // 3. Anexar as Categorias (relação Many-to-Many)
        $product->categories()->attach($validatedData['categories']);

        // 4. Redirecionar de volta para "Meus Anúncios" com msg de sucesso
        return redirect()->route('seller.products')->with('success', 'Anúncio criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // O Laravel automaticamente encontra o produto pelo ID (como definimos na rota)

        // Vamos carregar as categorias e o vendedor junto para otimizar
        $product->load('categories', 'seller.sellerProfile');

        // Retorna a nova view que vamos criar
        return view('products.show', compact('product'));
    }

    /**
     * Mostra os produtos do vendedor logado.
     */
    public function myProducts()
    {
        // Pega o ID do usuário logado
        $userId = Auth::id();

        // Busca os produtos que pertencem a este usuário
        $products = Product::where('user_id', $userId)
            ->latest()
            ->paginate(10);

        // Retorna a view do painel de vendedor (que usará o layout logado)
        return view('products.my-products', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
