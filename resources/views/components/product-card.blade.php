<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition-shadow duration-300 ease-in-out flex flex-col">
    <a href="{{ $query ? route('products.show', [$product, 'q' => $query]) : route('products.show', $product) }}" class="block relative aspect-[4/3]"> {{-- Proporção 4:3 para a imagem --}}
        <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover">
         {{-- Botão Favoritar (Placeholder) --}}
        <button class="absolute top-2 right-2 bg-white/70 rounded-full p-1 text-gray-500 hover:text-red-500 hover:bg-white focus:outline-none">
             <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.682l1.318-1.364a4.5 4.5 0 016.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z"></path></svg>
        </button>
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