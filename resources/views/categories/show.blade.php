<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->name }} - Conecta Vale</title>

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
                    <input type="text" placeholder="Buscar produtos..."
                        class="w-full px-4 py-2 rounded-md text-gray-900">
                </div>

                <div class="flex items-center">
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
                            <a href="#"
                                class="ml-4 px-3 py-2 rounded-md text-sm font-medium bg-vale-accent text-black hover:bg-yellow-600">Meus
                                Anúncios</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h2 class="font-bold text-xl mb-4 text-gray-800">Categorias</h2>
                    <ul class="space-y-2">
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('categories.show', $cat) }}"
                                    class="block px-3 py-2 rounded-md 
                                    {{ $cat->id == $category->id ? 'bg-vale-primary text-white font-bold' : 'text-gray-700 hover:bg-gray-200 hover:text-vale-primary' }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <section class="w-full lg:w-3/4">
                <h1 class="font-bold text-2xl mb-6 text-gray-900">
                    Mostrando produtos em: <span class="text-vale-primary">{{ $category->name }}</span>
                </h1>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="text-gray-600 col-span-full">Nenhum produto encontrado nesta categoria.</p>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </section>

        </div>
    </main>

    <footer class="bg-gray-800 text-white mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Conecta Vale. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>

</html>