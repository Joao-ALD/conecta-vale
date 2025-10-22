<?php

namespace App\Http\Controllers;

use App\Models\Product; // Importe o modelo Product
use Illuminate\Http\Request; // Importe o Request

class CartController extends Controller
{
    /**
     * Adiciona um produto ao carrinho.
     */
    public function store(Request $request, Product $product)
    {
        // Por enquanto, vamos apenas testar se funciona
        // dd() significa "dump and die" (despejar e parar)
        dd('Produto para adicionar ao carrinho:', $product->name);

        // Futuramente, aqui você vai:
        // 1. Pegar o carrinho da sessão (ou criar um).
        // 2. Adicionar o $product->id e a quantidade.
        // 3. Salvar o carrinho de volta na sessão.
        // 4. Redirecionar o usuário para a página do carrinho ou
        //    mostrar uma mensagem de sucesso.

        // return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho!');
    }

    /**
     * Mostra a página do carrinho.
     */
    public function index()
    {
        // Lógica para buscar o carrinho da sessão e mostrar os produtos
        return view('cart.index'); // Você precisará criar esta view
    }

    /**
     * Remove um produto do carrinho.
     */
    public function destroy(Product $product)
    {
        // Lógica para remover o item da sessão
        // return back()->with('success', 'Produto removido do carrinho!');
    }
}