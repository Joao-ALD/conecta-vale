<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Conecta Vale - O seu marketplace do Vale do Ribeira' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    <nav class="bg-vale-primary text-white shadow-md">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="font-bold text-2xl text-white">
                        Conecta Vale
                    </a>
                </div>

                <div class="flex-1 max-w-xl mx-4">
                    <form action="{{ route('search') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   placeholder="Buscar produtos..."
                                   class="w-full px-4 py-2 pl-10 rounded-md text-gray-900 border-gray-300 focus:border-vale-accent focus:ring focus:ring-vale-accent focus:ring-opacity-50"
                                   >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('contact.inbox') }}" class="relative text-white hover:text-gray-200 p-2">
                             <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 5.523-4.477 10-10 10S1 17.523 1 12 5.477 2 11 2s10 4.477 10 10z"></path></svg>
                             @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $unreadMessagesCount }}</span>
                             @endif
                             <span class="sr-only">Chat</span> {{-- Para acessibilidade --}}
                        </a>

                        <!-- Ícone de Favoritos -->
                        <a href="{{ route('favorites.index') }}" class="relative text-white hover:text-gray-200 p-2">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            @if(isset($favoritesCount) && $favoritesCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $favoritesCount }}</span>
                            @endif
                            <span class="sr-only">Favoritos</span>
                        </a>

                        <!-- Ícone do Carrinho -->
                        <a href="{{ route('cart.index') }}" class="relative text-white hover:text-gray-200 p-2">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            @if(isset($cartCount) && $cartCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $cartCount }}</span>
                            @endif
                            <span class="sr-only">Carrinho</span>
                        </a>

                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center text-sm font-medium text-white hover:text-gray-200 focus:outline-none transition duration-150 ease-in-out">
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('admin.dashboard')">Meu Painel</x-dropdown-link>
                                    <x-dropdown-link :href="route('favorites.index')">Meus Favoritos</x-dropdown-link>
                                    @if (Auth::user()->role === 'usuario')
                                        <form method="POST" action="{{ route('user.becomeSeller') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('user.becomeSeller')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                Anunciar meus Produtos
                                            </x-dropdown-link>
                                        </form>
                                    @endif
                                    @if(Auth::user()->role === 'vendedor')
                                        <x-dropdown-link :href="route('products.my')">Meus Anúncios</x-dropdown-link>
                                        @if(Auth::user()->sellerProfile)
                                            <x-dropdown-link :href="route('seller.profile.edit')">Editar Perfil Vendedor</x-dropdown-link>
                                        @endif
                                    @endif
                                    <x-dropdown-link :href="route('profile.edit')">Configurações</x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}"> @csrf <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Sair</x-dropdown-link> </form>
                                </x-slot>
                            </x-dropdown>
                        </div>

                         @if(Auth::user()->role === 'vendedor')
                            <a href="{{ route('products.create') }}" class="ml-4 px-4 py-2 rounded-md text-sm font-medium bg-vale-accent text-black hover:bg-yellow-600 shadow">Anunciar Grátis</a>
                        @endif

                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-gray-200">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 px-4 py-2 rounded-md text-sm font-medium bg-vale-accent text-black hover:bg-yellow-600 shadow">Anunciar Grátis</a>
                        @endif
                    @endauth
                    {{-- Link do carrinho removido do header principal, pode ir para o dropdown ou user menu --}}
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-white shadow-sm mb-6">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-6 overflow-x-auto py-3">
                 @foreach($categoriesGlobal as $category)
                    @php
                        // Verifica se a rota atual é a de exibição de categoria e se a categoria atual do loop é a que está sendo exibida
                        $isCurrentCategory = request()->routeIs('categories.show') && request()->route('category')->is($category);
                        $link = $isCurrentCategory ? route('home') : route('categories.show', $category);
                    @endphp
                    <a href="{{ $link }}" class="flex flex-col items-center text-center text-sm font-medium text-gray-600 hover:text-vale-primary whitespace-nowrap group">
                        {{-- O ícone SVG será inserido aqui dinamicamente --}}
                        <span class="inline-block p-2 rounded-full mb-1 group-hover:bg-vale-primary/10 {{ $isCurrentCategory ? 'bg-vale-primary/20' : 'bg-gray-100' }}">
                            @if($category->icon_svg)
                                {!! $category->icon_svg !!}
                            @else
                                {{-- Ícone Placeholder --}}
                                <svg class="h-6 w-6 text-gray-500 group-hover:text-vale-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.53 0 1.04.21 1.41.59L17 7h3a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2 2V5c0-1.1.9-2 2-2h3l2-2h5l2 2z"></path></svg>
                            @endif
                        </span>
                        <span class="{{ $isCurrentCategory ? 'font-bold text-vale-primary' : '' }}">
                            {{ $category->name }}
                        </span>
                    </a>
                 @endforeach
            </div>
        </div>
    </div>

    <main class="max-w-screen-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>


    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Coluna 1: Logo e Descrição -->
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold text-white">Conecta Vale</h3>
                    <p class="text-gray-400">
                        O seu marketplace para encontrar os melhores produtos e serviços no Vale do Ribeira.
                    </p>
                </div>

                <!-- Coluna 2: Navegação -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Navegação</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Início</a></li>
                        <li><a href="{{ Auth::check() && Auth::user()->role === 'vendedor' ? route('products.create') : route('register') }}" class="text-gray-400 hover:text-white">Anunciar</a></li>
                        <li><a href="{{ route('favorites.index') }}" class="text-gray-400 hover:text-white">Meus Favoritos</a></li>
                    </ul>
                </div>

                <!-- Coluna 3: Institucional -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Institucional</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Sobre Nós</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Termos de Uso</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Política de Privacidade</a></li>
                    </ul>
                </div>

                <!-- Coluna 4: Redes Sociais -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Siga-nos</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white" aria-label="Facebook">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white" aria-label="Instagram">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.012-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049 1.064.218 1.791.465 2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.08 2.525c.636-.247 1.363-.416 2.427-.465C9.53 2.013 9.884 2 12.315 2zM12 7a5 5 0 100 10 5 5 0 000-10zm0 8a3 3 0 110-6 3 3 0 010 6zm4.885-9.45a1.312 1.312 0 100-2.625 1.312 1.312 0 000 2.625z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Conecta Vale. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

</body>

</html>