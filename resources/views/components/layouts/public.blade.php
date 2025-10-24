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

    <nav class="bg-vale-primary text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="font-bold text-2xl">
                        Conecta Vale
                    </a>
                </div>

                <div class="flex items-center flex-1 px-8">
                    <form action="{{ route('search') }}" method="GET" class="w-full">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar produtos..."
                            class="w-full px-4 py-2 rounded-md text-gray-900" >
                    </form>
                </div>

                <div class="flex items-center">
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-white hover:text-gray-300">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        {{-- <span class="font-bold">Carrinho</span> --}}

                        @if(session('cart') && count(session('cart')) > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-vale-primary-dark">Meu Painel</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-vale-primary-dark">Entrar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ml-4 px-3 py-2 rounded-md text-sm font-medium bg-vale-accent text-black hover:bg-yellow-600">Cadastrar</a>
                            @endif
                        @endauth
                    @endif

                    @auth
                        @if(auth()->user()->role == 'vendedor')
                            <a href="{{ route('seller.products') }}"
                                class="ml-4 px-3 py-2 rounded-md text-sm font-medium bg-vale-accent text-black hover:bg-yellow-600">Meus
                                Anúncios</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

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