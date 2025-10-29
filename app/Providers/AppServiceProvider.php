<?php

namespace App\Providers;

use App\Http\View\Composers\UnreadMessagesComposer;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Composer para o contador de mensagens não lidas (usado em ambos os layouts)
        View::composer(['layouts.navigation', 'components.layouts.public'], UnreadMessagesComposer::class);

        // Composer para a lista de categorias globais, contagem do carrinho e favoritos (usado no layout público)
        View::composer('components.layouts.public', function ($view) {
            $cartCount = session()->has('cart') ? count(session('cart')) : 0;

            $favoritesCount = 0;
            if (auth()->check()) {
                $favoritesCount = auth()->user()->favorites()->count();
            }

            $view->with([
                'categoriesGlobal' => Category::where('slug', '!=', 'sem-categoria')->orderBy('name')->get(),
                'cartCount' => $cartCount,
                'favoritesCount' => $favoritesCount,
            ]);
        });
    }
}
