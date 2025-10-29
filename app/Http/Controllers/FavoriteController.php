<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Adiciona ou remove um produto da lista de favoritos do usuário.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Product $product)
    {
        $user = Auth::user();
        $user->favorites()->toggle($product->id);

        return back()->with('success', 'Estado de favorito atualizado!');
    }

    /**
     * Exibe a lista de produtos favoritos do usuário.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $favorites = Auth::user()
            ->favorites()
            ->with('images') // Eager load para evitar N+1
            ->latest()
            ->paginate(15);

        return view('favorites.index', compact('favorites'));
    }
}
