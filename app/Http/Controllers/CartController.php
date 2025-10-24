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
        // 1. Pega o carrinho da sessão ou cria um array vazio
        $cart = $request->session()->get('cart', []);

        // 2. Verifica se o produto já está no carrinho
        if (isset($cart[$product->id])) {
            // Se sim, incrementa a quantidade
            $cart[$product->id]['quantity']++;
        } else {
            // Se não, adiciona o produto
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                // "image" => $product->image_path (guarde para o futuro)
            ];
        }

        // 3. Salva o array do carrinho de volta na sessão
        $request->session()->put('cart', $cart);

        // 4. Redireciona para a página do carrinho com uma msg de sucesso
        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho!');
    }

    /**
     * Mostra a página do carrinho.
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        // Calcular o total
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // Passa os itens do carrinho e o total para a view
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Remove um produto do carrinho.
     */
    // Dentro de app/Http/Controllers/CartController.php

    public function destroy(Request $request, $product)
    {
        $cart = $request->session()->get('cart', []);

        // Verifica se o produto existe no carrinho e o remove
        if (isset($cart[$product])) {
            unset($cart[$product]);
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', 'Produto removido do carrinho!');
    }
}
