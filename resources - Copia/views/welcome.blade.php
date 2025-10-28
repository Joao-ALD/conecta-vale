<x-layouts.public>
    <x-slot name="title">
        Conecta Vale - O seu marketplace do Vale do Ribeira
    </x-slot>

    <div class="mb-6 bg-gradient-to-r from-vale-secondary to-vale-primary text-white p-8 rounded-lg shadow-lg text-center">
        <h2 class="text-3xl font-bold mb-2">Anuncie Grátis no Conecta Vale!</h2>
        <p class="mb-4">A plataforma que conecta compradores e vendedores do Vale do Ribeira.</p>
        @guest
            <a href="{{ route('register') }}" class="inline-block px-6 py-2 rounded-md bg-vale-accent text-black font-semibold hover:bg-yellow-600">Quero Anunciar</a>
        @endguest
        @auth
            @if(Auth::user()->role === 'vendedor')
                <a href="{{ route('products.create') }}" class="inline-block px-6 py-2 rounded-md bg-vale-accent text-black font-semibold hover:bg-yellow-600">Anunciar Agora</a>
            @else
                {{-- Usuário logado mas não vendedor --}}
                <p class="text-sm">(Torne-se um vendedor para anunciar)</p>
            @endif
        @endauth
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-1/4">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <h2 class="font-bold text-xl mb-4 text-gray-800">Categorias</h2>
                <ul class="space-y-2">
                    @forelse($categories as $category)
                        <li>
                            <a href="{{ route('categories.show', $category) }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-200 hover:text-vale-primary">
                                {{ $category->name }}
                            </a>
                        </li>
                    @empty
                        <li>
                            <p class="text-gray-500">Nenhuma categoria cadastrada.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </aside>

        <section class="w-full lg:w-3/4">
            <h1 class="font-bold text-2xl mb-6 text-gray-900">Anúncios Recentes</h1>

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse ($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <p class="text-gray-600 col-span-full">Nenhum produto encontrado.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </section>

    </div>
</x-layouts.public>