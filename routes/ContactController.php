<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Mostra a "Caixa de Entrada" do usuário logado.
     */
    public function inbox()
    {
        $user = Auth::user();
        $conversations = $user->conversations()
                            ->with('product', 'buyer', 'seller') // Otimização
                            ->latest('updated_at')
                            ->get();

        return view('contact.inbox', compact('conversations'));
    }

    /**
     * Mostra a tela de chat para um produto.
     */
    public function showConversation(Request $request, Product $product)
    {
        $user = Auth::user();

        // Vendedor não pode mandar mensagem para si mesmo
        if ($user->id === $product->user_id) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Você não pode enviar uma mensagem para si mesmo.');
        }

        // Encontra (ou cria na memória) a conversa
        $conversation = Conversation::firstOrCreate(
            [
                'product_id' => $product->id,
                'buyer_id' => $user->id,
                'seller_id' => $product->user_id,
            ]
        );

        // Carrega as mensagens
        $conversation->load('messages.user');

        return view('contact.show', compact('conversation'));
    }

    /**
     * Salva a nova mensagem no banco.
     */
    public function sendMessage(Request $request, Product $product)
    {
        $user = Auth::user();

        $request->validate(['body' => 'required|string|max:2000']);

        // Encontra a conversa (deve existir do 'showConversation')
        $conversation = Conversation::where([
            'product_id' => $product->id,
            'buyer_id' => $user->id,
            'seller_id' => $product->user_id,
        ])->firstOrFail();

        // Cria a mensagem
        $conversation->messages()->create([
            'user_id' => $user->id,
            'body' => $request->body,
        ]);

        // Atualiza o 'updated_at' da conversa (para a inbox)
        $conversation->touch();

        return back()->with('success', 'Mensagem enviada!');
    }
}