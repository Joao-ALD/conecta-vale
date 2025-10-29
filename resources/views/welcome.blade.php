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

    <section class="w-full">
        <h1 class="font-bold text-2xl mb-6 text-gray-900">Anúncios Recentes</h1>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
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

</x-layouts.public>
