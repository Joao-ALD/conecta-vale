<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $subscription = $user->currentSubscription();

        if (!$subscription || ($subscription->expires_at && $subscription->expires_at->isPast())) {
            return redirect()->route('seller.plans.show')->with('error', 'Precisa de uma assinatura ativa para aceder a esta funcionalidade.');
        }

        return $next($request);
    }
}
