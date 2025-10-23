<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
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
        // 1. Validação (adicionamos a validação de 'images')
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            // Validação das imagens:
            'images' => 'required|array|min:1', // Pelo menos 1 imagem
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048' // Cada imagem
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

        // 4. Salvar as Imagens (NOVO)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                // Salva o arquivo em 'storage/app/public/products'
                $path = $imageFile->store('products', 'public');

                // Cria o registro no banco
                $product->images()->create(['path' => $path]);
            }
        }

        // 5. Redirecionar
        return redirect()->route('seller.products')->with('success', 'Anúncio criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product) // <-- Mude aqui
    {
        $product->load('categories', 'seller.sellerProfile');

        // Pega o termo de busca 'q' da URL, se existir
        $query = $request->input('q');

        // Passa 'product' e 'query' para a view
        return view('products.show', compact('product', 'query'));
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
    /**
     * Mostra o formulário para editar um produto existente.
     */
    public function edit(Product $product)
    {
        // 1. Autorizar (usando a Policy)
        // Isso vai checar automaticamente se auth()->user()->id === $product->user_id
        $this->authorize('update', $product);

        // 2. Buscar as categorias
        $categories = Category::all();

        // 3. Retornar a view
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    /**
     * Atualiza um produto existente no banco de dados.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Autorizar (usando a Policy)
        $this->authorize('update', $product);

        // 2. Validação (mesma do 'store')
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        // 3. Atualizar o Produto
        $product->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
        ]);

        // 4. Sincronizar as Categorias
        // sync() é como o attach(), mas remove as antigas que não foram enviadas
        $product->categories()->sync($validatedData['categories']);

        // 5. Redirecionar
        return redirect()->route('seller.products')->with('success', 'Anúncio atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove o produto do banco de dados.
     */
    public function destroy(Product $product)
    {
        // 1. Autorizar (usando a Policy)
        $this->authorize('delete', $product);

        // 2. Excluir o produto
        $product->delete();

        // 3. Redirecionar
        return redirect()->route('seller.products')->with('success', 'Anúncio excluído com sucesso!');
    }
}
