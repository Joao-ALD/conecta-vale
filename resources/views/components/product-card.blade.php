<div class="border border-gray-200 rounded-lg shadow-sm bg-white overflow-hidden hover:shadow-lg transition-shadow duration-300 ease-in-out">
    <a href="{{ route('products.show', $product) }}">
        <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
    </a>

    <div class="p-4">
        <h3 class="font-bold text-lg text-gray-800 mb-2 truncate">
            <a href="{{ route('products.show', $product) }}" class="hover:text-vale-primary">
                {!! highlight($product->name, $query) !!}
            </a>
        </h3>

        <p class="font-extrabold text-vale-primary text-xl mb-3">
            R$ {{ number_format($product->price, 2, ',', '.') }}
        </p>

        <div class="text-sm text-gray-500">
            <p>Vendido por: {{ $product->seller->name }}</p>
            <p>Postado em: {{ $product->created_at->format('d/m/Y') }}</p>
        </div>

        @auth
            <form action="{{ route('cart.store', $product) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full bg-vale-accent hover:bg-yellow-600 text-black font-bold py-2 px-4 rounded transition-colors duration-300">
                    Adicionar ao Carrinho
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="mt-4 block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-300">
                Faça login para comprar
            </a>
        @endauth
    </div>
</div>