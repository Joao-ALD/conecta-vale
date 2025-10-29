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
                                    <x-dropdown-link :href="route('dashboard')">Meu Painel</x-dropdown-link>
                                    <x-dropdown-link :href="route('favorites.index')">Meus Favoritos</x-dropdown-link>
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


    <footer class="bg-gray-800 text-white mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Conecta Vale. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>

</html>