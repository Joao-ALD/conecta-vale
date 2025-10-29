<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition-shadow duration-300 ease-in-out flex flex-col">
    <a href="{{ $query ? route('products.show', [$product, 'q' => $query]) : route('products.show', $product) }}" class="block relative aspect-[4/3]"> {{-- Proporção 4:3 para a imagem --}}
        <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover">
        @auth
            <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="absolute top-2 right-2">
                @csrf
                <button type="submit" class="bg-white/70 rounded-full p-1.5 text-gray-600 hover:text-red-500 hover:bg-white focus:outline-none transition-colors duration-200">
                    @if(isset($favoriteProductIds) && in_array($product->id, $favoriteProductIds))
                        {{-- Coração Preenchido (Já é favorito) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    @else
                        {{-- Coração Vazio (Não é favorito) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.682l1.318-1.364a4.5 4.5 0 016.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                        </svg>
                    @endif
                </button>
            </form>
        @endauth
    </a>

    <div class="p-3 flex flex-col flex-grow">
        {{-- Preço --}}
        <p class="font-bold text-lg text-gray-900 mb-1">
            R$ {{ number_format($product->price, 2, ',', '.') }}
        </p>

        {{-- Título --}}
        <h3 class="text-sm text-gray-700 mb-2 flex-grow min-h-[40px]"> {{-- Altura mínima para alinhar --}}
            <a href="{{ $query ? route('products.show', [$product, 'q' => $query]) : route('products.show', $product) }}" class="hover:text-vale-primary line-clamp-2"> {{-- Limita a 2 linhas --}}
                {!! highlight($product->name, $query) !!}
            </a>
        </h3>

        {{-- Informações Adicionais (Data/Localização - Placeholder) --}}
        <div class="text-xs text-gray-500 mt-auto pt-2 border-t border-gray-100">
            <span>{{ $product->created_at->format('d/m/Y') }}</span>
             {{-- Idealmente, adicionar localização do vendedor aqui --}}
            <span class="ml-2">Vale do Ribeira</span>
        </div>

         {{-- Botão Comprar removido do card para um visual mais limpo, como na OLX --}}
    </div>
</div>