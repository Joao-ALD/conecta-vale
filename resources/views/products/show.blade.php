<x-layouts.public>
    <x-slot name="title">
        {{ $product->name }} - Conecta Vale
    </x-slot>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden lg:grid lg:grid-cols-3 lg:gap-x-8">

        <div class="lg:col-span-2" x-data="{ mainImage: '{{ $product->first_image_url }}' }">
            <div class="bg-gray-200 dark:bg-gray-700 rounded-lg mb-4">
                <img :src="mainImage" alt="{{ $product->name }}" class="h-96 w-full object-cover rounded-lg">
            </div>
        
            <div class="flex space-x-2 overflow-x-auto">
                @forelse($product->images as $image)
                    <button @click="mainImage = '{{ Storage::url($image->path) }}'" 
                            class="w-24 h-24 flex-shrink-0 rounded-md overflow-hidden border-2" 
                            :class="{ 'border-vale-primary': mainImage === '{{ Storage::url($image->path) }}' }">
                        <img src="{{ Storage::url($image->path) }}" alt="Miniatura" class="w-full h-full object-cover">
                    </button>
                @empty
                    @endforelse
            </div>
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

                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
                    {!! highlight($product->name, $query ?? null) !!}
                </h1>

                <p class="text-4xl font-bold text-vale-primary mb-6">
                    R$ {{ number_format($product->price, 2, ',', '.') }}
                </p>

                <div class="mb-6">
                    <h2 class="text-lg font-bold mb-2">Descrição</h2>
                    <p class="text-gray-700 whitespace-pre-line">
                        {!! highlight($product->description, $query ?? null) !!}
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <form action="{{ route('cart.store', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-vale-accent hover:bg-yellow-600 text-black font-bold py-3 px-6 rounded-lg text-lg transition-colors duration-300">
                        Adicionar ao Carrinho
                    </button>
                </form>

                <a href="{{ route('contact.show', $product) }}" class="mt-4 w-full block text-center bg-vale-primary hover:bg-opacity-90 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors duration-300">
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
</x-layouts.public>