<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message; // Certifique-se de importar o model Message

class UnreadMessagesComposer
{
    /**
     * Associa dados à view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $unreadCount = 0;
        // Verifica se o usuário está logado antes de fazer a consulta
        if (Auth::check()) {
            $user = Auth::user();
            // Conta mensagens que:
            // 1. Não foram lidas (is_read = false)
            // 2. NÃO foram enviadas pelo usuário logado (user_id != $user->id)
            // 3. Pertencem a uma conversa onde o usuário logado é o comprador OU o vendedor
            $unreadCount = Message::where('is_read', false)
                                ->where('user_id', '!=', $user->id)
                                ->whereHas('conversation', function ($query) use ($user) {
                                    $query->where('buyer_id', $user->id)
                                          ->orWhere('seller_id', $user->id);
                                })
                                ->count();
        }

        // Envia a variável $unreadCount para a view com o nome 'unreadMessagesCount'
        $view->with('unreadMessagesCount', $unreadCount);
    }
}
