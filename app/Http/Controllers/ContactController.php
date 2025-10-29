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
                            ->has('messages')
                            ->with('product', 'buyer', 'seller', 'latestMessage') // Eager load relationships
                            ->withCount(['messages as unread_messages_count' => function ($query) {
                                $query->where('is_read', false)->where('user_id', '!=', Auth::id());
                            }])
                            ->latest('updated_at')
                            ->get();

        return view('contact.inbox', compact('conversations'));
    }

    /**
     * Inicia uma conversa (se não existir) e redireciona para a tela de chat.
     * Acessado pelo COMPRADOR a partir da página do produto.
     */
    public function initiateConversation(Product $product)
    {
        $user = Auth::user();

        // Vendedor não pode mandar mensagem para si mesmo
        if ($user->id === $product->user_id) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Você não pode iniciar uma conversa sobre um produto seu.');
        }

        // Encontra ou cria a conversa
        $conversation = Conversation::firstOrCreate(
            [
                'product_id' => $product->id,
                'buyer_id' => $user->id,
            ],
            [
                'seller_id' => $product->user_id,
            ]
        );

        // Redireciona para a rota que exibe a conversa
        return redirect()->route('contact.show', $conversation);
    }

    /**
     * Mostra a tela de chat para uma conversa existente.
     * Acessado por COMPRADOR ou VENDEDOR a partir da inbox.
     */
    public function showConversation(Conversation $conversation)
    {
        // Autorização: Garante que o usuário logado faz parte da conversa
        if (Auth::id() !== $conversation->buyer_id && Auth::id() !== $conversation->seller_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Marca as mensagens da outra pessoa como lidas
        $conversation->messages()
                     ->where('user_id', '!=', Auth::id()) // Mensagens da outra pessoa
                     ->where('is_read', false)          // Que ainda não foram lidas
                     ->update(['is_read' => true]);     // Marca como lida

        // Carrega as mensagens da conversa
        $conversation->load('messages.user', 'product');

        return view('contact.show', compact('conversation'));
    }


    /**
     * Salva a nova mensagem no banco.
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {        
        // Autorização: Garante que o usuário logado faz parte da conversa
        if (Auth::id() !== $conversation->buyer_id && Auth::id() !== $conversation->seller_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate(['body' => 'required|string|max:2000']);

        // Cria a mensagem
        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // Atualiza o 'updated_at' da conversa (para a inbox)
        $conversation->touch();

        return back()->with('success', 'Mensagem enviada!');
    }
}
