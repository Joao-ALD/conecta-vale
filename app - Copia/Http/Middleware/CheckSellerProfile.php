<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importe o Auth
use Symfony\Component\HttpFoundation\Response;

class CheckSellerProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Verifica se o usuário é um vendedor E se ele NÃO tem um perfil
        if ($user && $user->role === 'vendedor' && !$user->sellerProfile()->exists()) {

            // 2. Permite o acesso APENAS à rota de criação de perfil
            //    (Evita um loop infinito de redirecionamento)
            if (!$request->routeIs('seller.profile.create') && !$request->routeIs('seller.profile.store')) {

                // 3. Redireciona para a criação do perfil com uma mensagem
                return redirect()->route('seller.profile.create')
                    ->with('warning', 'Por favor, complete seu perfil de vendedor para continuar.');
            }
        }

        // 4. Se tudo estiver ok (ou não for vendedor), continua a requisição
        return $next($request);
    }
}