<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $product->name }} - Conecta Vale</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">

        <nav class="bg-vale-primary text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="font-bold text-2xl">Conecta Vale</a>
                    </div>
                    <div class="flex items-center flex-1 px-8">
                        <input type="text" placeholder="Buscar produtos..." class="w-full px-4 py-2 rounded-md text-gray-900">
                    </div>
                    <div class="flex items-center">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-vale-primary-dark">Meu Painel</a>
                            @else
                                <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-vale-primary-dark">Entrar</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 px-3 py-2 rounded-md text-sm font-medium bg-vale-accent text-black hover:bg-yellow-600">Cadastrar</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden lg:grid lg:grid-cols-3 lg:gap-x-8">

                <div class="lg:col-span-2">
                    <img src="https://via.placeholder.com/800x600.png?text=Imagem+do+Produto" alt="{{ $product->name }}" class="h-full w-full object-cover">
                </div>

                <div class="p-6 lg:col-span-1 flex flex-col justify-between">
                    <div>
                        <div class="mb-2">
                            @foreach($product->categories as $category)
                                <span class="inline-block bg-gray-200 text-gray-700 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>

                        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $product->name }}</h1>

                        <p class="text-4xl font-bold text-vale-primary mb-6">
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </p>

                        <div class="mb-6">
                            <h2 class="text-lg font-bold mb-2">Descrição</h2>
                            <p class="text-gray-700 whitespace-pre-line">{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <form action="{{ route('cart.store', $product) }}" method="POST">
                            @csrf
                            <button type
                            ="submit" class="w-full bg-vale-accent hover:bg-yellow-600 text-black font-bold py-3 px-6 rounded-lg text-lg transition-colors duration-300">
                                Adicionar ao Carrinho
                            </button>
                        </form>

                        <a href="#" class="mt-4 w-full block text-center bg-vale-primary hover:bg-opacity-90 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors duration-300">
                            Entrar em Contato com Vendedor
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-3 border-t border-gray-200 p-6">
                    <h2 class="text-xl font-bold mb-4">Informações do Vendedor</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-lg font-semibold">{{ $product->seller->sellerProfile->store_name ?? $product->seller->name }}</p>
                        <p class="text-gray-600">Vendedor desde: {{ $product->seller->created_at->format('M Y') }}</p>
                        <p class="text-gray-600">Telefone: {{ $product->seller->sellerProfile->phone ?? 'Não informado' }}</p>
                        </div>
                </div>
            </div>
        </main>

        <footer class="bg-gray-800 text-white mt-12 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p>&copy; {{ date('Y') }} Conecta Vale. Todos os direitos reservados.</p>
            </div>
        </footer>

    </body>
</html>