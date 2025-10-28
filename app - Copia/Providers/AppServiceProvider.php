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

        // Composer para a lista de categorias globais (usado no layout público)
        View::composer('components.layouts.public', function ($view) {
            $view->with('categoriesGlobal', Category::where('slug', '!=', 'sem-categoria')->orderBy('name')->get());
        });
    }
}
